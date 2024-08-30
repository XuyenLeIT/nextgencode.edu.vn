<?php

namespace App\Http\Controllers;

use App\Models\AchiveCourse;
use App\Models\Course;
use App\Models\DesCourse;
use App\Models\ModuleCourse;
use App\Models\OutlineModule;
use App\Models\User;
use App\Models\WhoCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use DOMDocument;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('admins.course.index', compact('courses'));
    }
    public function create()
    {
        return view('admins.course.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'startDate' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'letter' => 'required|mimes:pdf|max:10240',
            "duration" => 'required',
            "stunumber" => 'required',
            "dayweek" => 'required',
            "hourday" => 'required',
            "class" => 'required'

        ]);
        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("typeLearn") ? true : false;
        if ($request->hasFile('thumbnail')) {
            $fileThumnail = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
            $request->thumbnail->storeAs('public/courseImages', $fileThumnail);
        }
        if ($request->hasFile('letter')) {
            $fileLetter = uniqid() . '.' . $request->letter->getClientOriginalName();
            $request->letter->storeAs('public/courseLetters', $fileLetter);
        }
        Course::create([
            'name' => $request->name,
            'startDate' => $request->startDate,
            'typeLearn' => $isActive,
            'thumbnail' => '/storage/courseImages/' . $fileThumnail,
            'letter' => '/storage/courseLetters/' . $fileLetter,
            'duration' => $request->duration,
            'stunumber' => $request->stunumber,
            'dayweek' => $request->dayweek,
            'hourday' => $request->hourday,
             "class" => 'required'
        ]);
        return redirect()->route('admin.course.index')->with('success', 'Course created successfully.');
    }
    public function detail($id)
    {
        $course = Course::find($id);
        if ($course != null) {
            Session::put('courseId', $id);
            $desCourse = $course->DesCourse()->first();
            $whoCourse = $course->whoCourse()->first();
            $achivesCourse = $course->achivesCourse;
            $students = User::where("course_id", $id)->get();
            $modulesCourse = $course->modulesCourse->sortBy('stt');
            $checkReference = ($course->achivesCourse()->exists() || $course->achivesCourse()->exists());
            return view(
                'admins.course.detail',
                compact('course', "id", 'whoCourse', 'achivesCourse', 'modulesCourse', 'checkReference', 'students', 'desCourse')
            );
        }
        $courseId = Session::get('courseId');
        return redirect()->route("admin.course.detail", $courseId);
    }
    //update course 
    public function edit($id)
    {
        $course = Course::find($id);
        return view('admins.course.edit', compact('course'));
    }
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required',
            'startDate' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:10240',
            'letter' => 'nullable|mimes:pdf|max:10240',
            "duration" => 'required',
            "stunumber" => 'required',
            "dayweek" => 'required',
            "hourday" => 'required',
             "class" => 'required'

        ]);
        // Kiểm tra xem checkbox có được chọn hay không
        $isActiveTypeLearn = $request->has("typeLearn") ? true : false;
        $isActiveStatus = $request->has("status") ? true : false;
        // dd($request->all());
        if ($request->hasFile('thumbnail')) {
            $fileThumnail = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
            $request->thumbnail->storeAs('public/courseImages', $fileThumnail);
            $thumbnail = '/storage/courseImages/' . $fileThumnail;
            $thumbnailPath = str_replace('storage', 'public', $request->thumbnailExisting);
            if (Storage::exists($thumbnailPath)) {
                Storage::delete($thumbnailPath);
            }
        } else {
            $thumbnail = $request->thumbnailExisting;
        }
        if ($request->hasFile('letter')) {
            $fileLetter = uniqid() . '.' . $request->letter->getClientOriginalName();
            $request->letter->storeAs('public/courseLetters', $fileLetter);
            $letter = '/storage/courseLetters/' . $fileLetter;
            $letterPath = str_replace('storage', 'public', $request->letterExisting);
            if (Storage::exists($letterPath)) {
                Storage::delete($letterPath);
            }
        } else {
            $letter = $request->letterExisting;
        }
        $course->update([
            'name' => $request->name,
            'startDate' => $request->startDate,
            'typeLearn' => $isActiveTypeLearn,
            'thumbnail' => $thumbnail,
            'letter' => $letter,
            'duration' => $request->duration,
            'status' => $isActiveStatus,
            'stunumber' => $request->stunumber,
            'dayweek' => $request->dayweek,
            'hourday' => $request->hourday,
             "class" => $request->class
        ]);
        return redirect()->route('admin.course.index')->with('success', 'Course created successfully.');
    }
    public function delete($id)
    {
        $course = Course::find($id);
        if ($course != null) {
            $imagePath = str_replace('storage', 'public', $course->thumbnail);
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
            $course->delete();
        }
        return redirect()->route('admin.course.index')->with("success", "delete course successfully");
    }
    public function createWhoCourse(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'course_id' => 'required',
            'thumbnail' => 'image|nullable|max:1999',
        ]);
        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("status") ? true : false;
        if ($request->hasFile('thumbnail')) {
            $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
            $request->thumbnail->storeAs('public/courseImages', $filename);
            WhoCourse::create([
                'description' => $request->description,
                'course_id' => $request->course_id,
                'thumbnail' => 'storage/courseImages/' . $filename,
                'status' => $isActive,
            ]);
        } else {
            return redirect()->route('admin.course.index')->with('thumbnail', 'Image is required.');
        }
        return redirect()->route('admin.course.index')->with('success', 'CourseDetail created successfully.');
    }
    public function updateWhoCourse(Request $request, WhoCourse $whoCourse)
    {
        $request->validate([
            'description' => 'required',
            'course_id' => 'required',
            'thumbnail' => 'image|nullable|max:1999',
        ]);
        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("status") ? true : false;
        //dd("status",$isActive);
        if ($request->hasFile('thumbnail')) {
            $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
            $request->thumbnail->storeAs('public/courseImages', $filename);
            $thumbnail = 'storage/courseImages/' . $filename;
        } else {
            $thumbnail = $request->thumbnailExisted;
        }
        $whoCourse->update([
            'id' => $request->id,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'thumbnail' => $thumbnail,
            'status' => $isActive,
        ]);
        return redirect()->route('admin.course.index')->with('success', 'CourseDetail updated successfully.');
    }
    //achiveCourse
    public function createAchiveCourse($id)
    {
        return view('admins.course.achive_create', compact("id"));
    }
    public function storeAchiveCourse(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'thumbnail' => 'image|nullable|max:1999',
            "description" => 'required'

        ]);
        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("status") ? true : false;
        // dd($request->all());
        if ($request->hasFile('thumbnail')) {
            $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
            $request->thumbnail->storeAs('public/courseImages', $filename);
            AchiveCourse::create([
                'title' => $request->title,
                'course_id' => $id,
                'description' => $request->description,
                'status' => $isActive,
                'thumbnail' => 'storage/courseImages/' . $filename,
            ]);
        } else {
            return redirect()->route('admins.course.achive_create', $id)->with('thumbnail', 'Image is required.');
        }
        return redirect()->route('admin.course.detail', $id)->with('success', 'Achive course created successfully.');
    }
    public function editAchiveCourse(AchiveCourse $achiveCourse)
    {
        return view('admins.course.achive_edit', compact("achiveCourse"));
    }
    public function updateAchiveCourse(Request $request, AchiveCourse $achiveCourse)
    {
        $request->validate([
            'title' => 'required',
            'thumbnail' => 'image|nullable|max:1999',
            "description" => 'required'

        ]);
        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("status") ? true : false;
        // dd($request->all());
        if ($request->hasFile('thumbnail')) {
            $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
            $request->thumbnail->storeAs('public/courseImages', $filename);
            $thumbnail = 'storage/courseImages/' . $filename;
        } else {
            $thumbnail = $request->thumbnailExisted;
        }
        $achiveCourse->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $isActive,
            'thumbnail' => $thumbnail
        ]);
        return redirect()->route('admin.course.detail', $achiveCourse->course_id)->with('success', 'Achive course updated successfully.');
    }
    //ModuleCourse
    public function createModuleCourse($id)
    {
        return view('admins.course.module_create', compact("id"));
    }
    public function storeModuleCourse(Request $request, $id)
    {
        $request->validate([
            "title" => "required",
        ]);

        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("status") ? true : false;
        $modules = ModuleCourse::all()->count();

        ModuleCourse::create([
            'title' => $request->title,
            'status' => $isActive,
            "course_id" => $id,
            "stt" => $modules + 1
        ]);
        return redirect()->route('admin.course.detail', $id)->with('success', 'Achive course created successfully.');
    }
    public function editModuleCourse(ModuleCourse $moduleCourse)
    {
        return view('admins.course.module_edit', compact("moduleCourse"));
    }
    public function updateModuleCourse(Request $request, ModuleCourse $moduleCourse)
    {
        $request->validate([
            "title" => "required",
            "stt" => "required|unique:module_courses,stt," . $moduleCourse->id,
        ]);
        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("status") ? true : false;
        $moduleCourse->update([
            'title' => $request->title,
            'status' => $isActive,
            'stt' => $request->stt,
        ]);
        return redirect()->route('admin.course.detail', $moduleCourse->course_id)->with('success', 'Achive course updated successfully.');
    }

    public function outlineModuleCourse($id)
    {
        $outlines = OutlineModule::where('module_id', $id)->get();
        $moduleCourse = ModuleCourse::findOrFail($id);
        if ($moduleCourse != null) {
            $moduleCourse->module_courses;
        }
        Session::put('moduleId', $id);
        return view('admins.course.module_outline', compact("outlines", "id", "moduleCourse"));
    }
    public function createOutlineModuleCourse()
    {
        //dd($moduleId);
        $moduleId = Session::get('moduleId');
        if ($moduleId == null) {
            return redirect()->route('admin.course')->with('success', 'Please process step by step.');
        }
        return view('admins.course.module_outline_create');
    }
    public function storeOutlineModuleCourse(Request $request)
    {
        $moduleId = Session::get('moduleId');
        if ($moduleId == null) {
            return redirect()->route('admin.course')->with('success', 'Please process step by step.');
        }
        $request->validate([
            "title" => "required",
            "description" => "required"
        ]);
        OutlineModule::create([
            'title' => $request->title,
            'status' => $request->status,
            'description' => $request->description,
            "module_id" => $moduleId
        ]);
        return redirect()->route('admin.moduleOutline', $moduleId)->with('success', 'outline course created successfully.');
    }
    public function editOutlineModuleCourse($id)
    {
        $outline = OutlineModule::find($id);
        return view('admins.course.module_outline_edit', compact("outline"));
    }
    public function updateOutlineModuleCourse(Request $request, OutlineModule $outline)
    {
        $moduleId = Session::get('moduleId');
        if ($moduleId == null) {
            return redirect()->route('admin.course')->with('success', 'Please process step by step.');
        }
        $request->validate([
            "title" => "required",
            "description" => "required"
        ]);
        // dd($request->all());
        $outline->update([
            'title' => $request->title,
            'status' => $request->status,
            'description' => $request->description,
            "module_id" => $moduleId
        ]);
        return redirect()->route('admin.moduleOutline', $moduleId)->with('success', 'outline course updated successfully.');
    }
    public function deleteOutlineModuleCourse($id)
    {
        $moduleId = Session::get('moduleId');
        if ($moduleId == null) {
            return redirect()->route('admin.course')->with('success', 'Please process step by step.');
        }
        $outline = OutlineModule::findOrFail($id);
        $outline->delete();
        return redirect()->route('admin.moduleOutline', $moduleId)->with('success', 'outline course updated successfully.');
    }
    //des coourse
    public function indexDes()
    {
        $desCourses = DesCourse::all();
        return view("admins.desCourse.index", compact("desCourses"));
    }

    public function createDes($id)
    {
        return view("admins.desCourse.create", compact("id"));
    }
    public function storeDesCourse(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            "description" => 'required'
        ]);

        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("status") ? true : false;
        // Xử lý nội dung editor
        $description = $request->input('description');
        $dom = new DOMDocument('1.0', 'UTF-8');
        // Tùy chọn để xử lý HTML tốt hơn
        $dom->loadHTML(mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            // Chỉ xử lý ảnh base64
            if (preg_match('/^data:image\/(\w+);base64,/', $src)) {
                $data = substr($src, strpos($src, ',') + 1);
                $data = base64_decode($data);
                $image_name = time() . '_' . uniqid() . '.png';
                $path = storage_path('app/public/uploads/') . $image_name;

                // Lưu file vào storage
                file_put_contents($path, $data);
                // Cập nhật đường dẫn ảnh trong nội dung
                $img->removeAttribute('src');
                $img->setAttribute('src', '/storage/uploads/' . $image_name);
            }
        }
        $description = $dom->saveHTML();
        // dd($request->all());
        DesCourse::create([
            'title' => $request->title,
            'description' => $description,
            'course_id' => $id,
            'status' => $isActive,
        ]);

        return redirect()->route('admin.course.detail', ['id' => $id])->with('success', 'Des course created successfully.');
    }
    public function editDes($id)
    {
        $desC = DesCourse::find($id);
        // dd($desC);
        return view("admins.desCourse.edit", compact("desC"));
    }
    public function updateDesCourse(Request $request, DesCourse $desC)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required',
            "description" => 'required'
        ]);

        // Check if checkbox is checked
        $isActive = $request->has('status') ? true : false;

        // Get and process description
        $description = $request->input('description');
        $deletedImages = json_decode($request->input('deleted_images'), true);

        // Delete images marked for deletion
        if ($deletedImages) {
            foreach ($deletedImages as $image) {
                $parsedUrl = parse_url($image, PHP_URL_PATH);
                $imagePathUrl = ltrim($parsedUrl, '/');
                $imagePath = str_replace('storage', 'public', $imagePathUrl);
                Storage::delete($imagePath);
            }
        }

        // Process base64 images in the description
        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true); // Suppress warnings from malformed HTML
        $dom->loadHTML(mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            // Process only base64 images
            if (preg_match('/^data:image\/(\w+);base64,/', $src)) {
                $data = substr($src, strpos($src, ',') + 1);
                $data = base64_decode($data);
                $image_name = time() . '_' . uniqid() . '.png';
                $path = storage_path('app/public/uploads/') . $image_name;

                // Save the file to storage
                file_put_contents($path, $data);

                // Update the image path in the HTML content
                $img->removeAttribute('src');
                $img->setAttribute('src', '/storage/uploads/' . $image_name);
            }
        }

        $description = $dom->saveHTML();

        // Update the Knowledge record
        $desC->update([
            'title' => $request->input('title'),
            'description' => $description,
            'status' => $isActive,
        ]);

        return redirect()->route('admin.course.detail', ['id' => $desC->course_id])->with('success', 'Des course created successfully.');
    }
}
