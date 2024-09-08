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
use Illuminate\Support\Facades\File;
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
        try {
            $fileThumnail = "";
            $fileLetter = "";
            // Kiểm tra xem checkbox có được chọn hay không
            if ($request->hasFile('thumbnail')) {
                $fileThumnail = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
                $request->thumbnail->move(public_path("courseImages"), $fileThumnail);
            }
            if ($request->hasFile('letter')) {
                $fileLetter = uniqid() . '.' . $request->letter->getClientOriginalName();
                $request->letter->move(public_path("courseLetters"), $fileThumnail);
            }
            Course::create([
                'name' => $request->name,
                'startDate' => $request->startDate,
                'typeLearn' => $request->typeLearn,
                'status' => $request->status,
                'thumbnail' => '/courseImages/' . $fileThumnail,
                'letter' => '/courseLetters/' . $fileLetter,
                'duration' => $request->duration,
                'stunumber' => $request->stunumber,
                'dayweek' => $request->dayweek,
                'hourday' => $request->hourday,
                "class" => $request->class
            ]);
            return redirect()->route('admin.course.index')->with('success', 'Course created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Opp error serve.');
        }
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

        try {
            $fileLetterUpdate = "";
            $fileThumnailUpdate = "";
            if ($request->hasFile('thumbnail')) {
                $fileThumnail = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
                $request->thumbnail->move(public_path("courseImages"), $fileThumnail);
                $fileThumnailUpdate = "/courseImages/" . $fileThumnail;
                $imagePath = public_path($request->thumbnailExisting);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            } else {
                $fileThumnailUpdate = $request->thumbnailExisting;
            }
            if ($request->hasFile('letter')) {
                $fileLetter = uniqid() . '.' . $request->letter->getClientOriginalName();
                $request->thumbnail->move(public_path("courseLetters"), $fileLetter);
                $fileLetterUpdate = "/courseLetters/" . $fileLetter;
                $imagePath = public_path($request->letterExisting);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            } else {
                $fileLetterUpdate = $request->letterExisting;
            }
            $course->update([
                'name' => $request->name,
                'startDate' => $request->startDate,
                'typeLearn' => $request->typeLearn,
                'thumbnail' => $fileThumnailUpdate,
                'letter' => $fileLetterUpdate,
                'duration' => $request->duration,
                'status' => $request->status,
                'stunumber' => $request->stunumber,
                'dayweek' => $request->dayweek,
                'hourday' => $request->hourday,
                "class" => $request->class
            ]);
            return redirect()->route('admin.course.index')->with('success', 'Course updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Opp error serve.' . $th);
        }

    }
    public function delete($id)
    {
        $course = Course::find($id);
        if ($course != null) {
            $imagePath = public_path($course->thumbnail);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
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
        try {
            if ($request->hasFile('thumbnail')) {
                $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
                $request->thumbnail->move(public_path("courseImages"), $filename);
                WhoCourse::create([
                    'description' => $request->description,
                    'course_id' => $request->course_id,
                    'thumbnail' => '/courseImages/' . $filename,
                    'status' => $request->status,
                ]);
            } else {
                return redirect()->route('admin.course.index')->with('thumbnail', 'Image is required.');
            }
            return redirect()->route('admin.course.index')->with('success', 'CourseDetail created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Opp error serve.');
        }
    }
    public function updateWhoCourse(Request $request, WhoCourse $whoCourse)
    {
        $request->validate([
            'description' => 'required',
            'course_id' => 'required',
            'thumbnail' => 'image|nullable|max:1999',
        ]);
        try {
            if ($request->hasFile('thumbnail')) {
                $imagePath = public_path($whoCourse->thumbnail);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
                $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
                $request->thumbnail->move(public_path("courseImages"), $filename);
                $thumbnail = '/courseImages/' . $filename;

            } else {
                $thumbnail = $request->thumbnailExisted;
            }
            $whoCourse->update([
                'id' => $request->id,
                'description' => $request->description,
                'course_id' => $request->course_id,
                'thumbnail' => $thumbnail,
                'status' => $request->status,
            ]);
            return redirect()->route('admin.course.index')->with('success', 'CourseDetail updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Opp error serve.');
        }
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
        try {
            // dd($request->all());
            if ($request->hasFile('thumbnail')) {
                $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
                $request->thumbnail->move(public_path("courseImages"), $filename);
                AchiveCourse::create([
                    'title' => $request->title,
                    'course_id' => $id,
                    'description' => $request->description,
                    'status' => $request->status,
                    'thumbnail' => '/courseImages/' . $filename,
                ]);
            } else {
                return redirect()->route('admins.course.achive_create', $id)->with('thumbnail', 'Image is required.');
            }
            return redirect()->route('admin.course.detail', $id)->with('success', 'Achive course created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Opp error serve.');
        }
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
        try {
            // dd($request->all());
            if ($request->hasFile('thumbnail')) {
                $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
                $request->thumbnail->move(public_path("courseImages"), $filename);
                $thumbnail = '/courseImages/' . $filename;
            } else {
                $thumbnail = $request->thumbnailExisted;
            }
            $achiveCourse->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
                'thumbnail' => $thumbnail
            ]);
            return redirect()->route('admin.course.detail', $achiveCourse->course_id)->with('success', 'Achive course updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Opp error serve.');
        }
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
        try {
            // Kiểm tra nếu có tệp ảnh được tải lên
            if ($request->hasFile('thumbnail')) {
                // Tạo tên tệp ảnh độc nhất
                $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
                // Lưu ảnh vào thư mục 'public/knowImages'
                $request->thumbnail->move(public_path("knowledgesImages"), $filename);
                // Xử lý nội dung editor
                $description = $request->input('description');
                // Làm sạch HTML
                $description = $this->cleanHtml($description);
                $dom = new DOMDocument('1.0', 'UTF-8');
                libxml_use_internal_errors(true); // Bỏ qua các lỗi không quan trọng

                // Tải HTML vào DOMDocument
                $dom->loadHTML(mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
                libxml_clear_errors(); // Xóa các lỗi đã xảy ra
                // Xử lý các ảnh base64 trong nội dung
                $images = $dom->getElementsByTagName('img');
                foreach ($images as $img) {
                    $src = $img->getAttribute('src');
                    // Chỉ xử lý ảnh base64
                    if (preg_match('/^data:image\/(\w+);base64,/', $src)) {
                        $data = substr($src, strpos($src, ',') + 1);
                        $data = base64_decode($data);
                        $image_name = time() . '_' . uniqid() . '.png';
                        $path = public_path('desCourseImages/' . $image_name);
                        // Lưu file vào storage
                        file_put_contents($path, $data);
                        // Cập nhật đường dẫn ảnh trong nội dung
                        $img->removeAttribute('src');
                        $img->setAttribute('src', '/desCourseImages/' . $image_name);
                    }
                }
                $description = $dom->saveHTML();
                DesCourse::create([
                    'title' => $request->title,
                    'description' => $description,
                    'course_id' => $id,
                    'status' => $request->status,
                ]);

                return redirect()->route('admin.course.detail', ['id' => $id])->with('success', 'Des course created successfully.');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Opp error serve.');
        }

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

        // Lấy và xử lý nội dung mô tả
        $description = $request->input('description');
        $deletedImages = json_decode($request->input('deleted_images'), true);
        // Xóa các ảnh đã được đánh dấu để xóa
        if ($deletedImages) {
            foreach ($deletedImages as $image) {
                $parsedUrl = parse_url($image, PHP_URL_PATH);
                $imagePathUrl = ltrim($parsedUrl, '/');
                $imagePath = public_path($imagePathUrl);
                if (file_exists($imagePath)) {
                    unlink($imagePath); // Xóa file khỏi public
                }
            }
        }
        // Làm sạch và xử lý các ảnh base64 trong nội dung
        $description = $this->cleanHtml($description);
        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true); // Bỏ qua các lỗi không quan trọng

        // Tải HTML vào DOMDocument
        $dom->loadHTML(mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors(); // Xóa các lỗi đã xảy ra

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            // Xử lý chỉ các ảnh base64
            if (preg_match('/^data:image\/(\w+);base64,/', $src)) {
                $data = substr($src, strpos($src, ',') + 1);
                $data = base64_decode($data);
                $image_name = time() . '_' . uniqid() . '.png';
                $path = public_path('desCourseImages/' . $image_name);

                // Lưu tệp vào storage
                file_put_contents($path, $data);

                // Cập nhật đường dẫn ảnh trong nội dung HTML
                $img->removeAttribute('src');
                $img->setAttribute('src', '/desCourseImages/' . $image_name);
            }
        }

        $description = $dom->saveHTML();
        // Update the Knowledge record
        $desC->update([
            'title' => $request->input('title'),
            'description' => $description,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.course.detail', ['id' => $desC->course_id])->with('success', 'Des course created successfully.');
    }
    protected function cleanHtml($html)
    {
        // Danh sách các thẻ không hợp lệ
        $invalid_tags = ['canvas', 'script', 'iframe']; // Thêm các thẻ không hợp lệ khác nếu cần

        foreach ($invalid_tags as $tag) {
            // Loại bỏ các thẻ không hợp lệ
            $html = preg_replace('/<' . $tag . '[^>]*>.*?<\/' . $tag . '>/', '', $html);
            $html = preg_replace('/<' . $tag . '[^>]*>/', '', $html);
        }

        return $html;
    }
}
