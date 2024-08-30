<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Knowledge;
use DOMDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KnowledgeController extends Controller
{
    //client
    public function index()
    {
        $knows = Knowledge::all();
        $banner = Banner::first();
        return view("clients.knowledge.index", compact("knows","banner"));
    }
    public function detail($id)
    {
        $know = Knowledge::find($id);
        return view("clients.knowledge.detail", compact("know"));
    }
    //admin
    public function indexAdmin()
    {
        $knows = Knowledge::all();
        return view("admins.knows.index", compact("knows"));
    }

    public function createKnow()
    {
        return view("admins.knows.create");
    }
    public function storeKnow(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'thumbnail' => 'image|nullable|max:1999',
            "description" => 'required'
        ]);

        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("status") ? true : false;

        if ($request->hasFile('thumbnail')) {
            $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
            $request->thumbnail->storeAs('public/knowImages', $filename);

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

            Knowledge::create([
                'title' => $request->title,
                'description' => $description,
                'sort_content' => $request->sort_content,
                'status' => $isActive,
                'thumbnail' => 'storage/knowImages/' . $filename,
            ]);
        } else {
            return redirect()->route('admin.knows.index')->with('thumbnail', 'Image is required.');
        }

        return redirect()->route('admin.knows.index')->with('success', 'Knows created successfully.');
    }

    public function editKnow($id)
    {
        $know = Knowledge::find($id);
        return view("admins.knows.edit", compact("know"));
    }
    public function updateKnow(Request $request, Knowledge $know)
    {
        // Validate the request data
        $request->validate([
            'title' => 'required',
            'thumbnail' => 'image|nullable|max:1999',
            'description' => 'required',
        ]);

        // Check if checkbox is checked
        $isActive = $request->has('status') ? true : false;

        // Handle file upload for thumbnail
        if ($request->hasFile('thumbnail')) {
            $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalExtension();
            $request->thumbnail->storeAs('public/knowImages', $filename);
            $thumbnail = 'storage/knowImages/' . $filename;
        } else {
            $thumbnail = $request->input('thumbnailExisted');
        }

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
        $know->update([
            'title' => $request->input('title'),
            'description' => $description,
            'sort_content' => $request->input('sort_content'),
            'status' => $isActive,
            'thumbnail' => $thumbnail,
        ]);

        return redirect()->route('admin.knows.index')->with('success', 'Knows updated successfully.');
    }
    public function destroy($id)
    {
        // Tìm đối tượng Knowledge theo ID hoặc hiển thị lỗi 404 nếu không tìm thấy
        $know = Knowledge::findOrFail($id);

        // Xóa các hình ảnh liên quan từ mô tả
        $dom = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true); // Suppress warnings from malformed HTML
        $dom->loadHTML(mb_convert_encoding($know->description, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $images = $dom->getElementsByTagName('img');
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            // Xử lý URL của hình ảnh
            $parsedUrl = parse_url($src, PHP_URL_PATH);
            $imagePathTrim = ltrim($parsedUrl, '/');
            $imagePath = str_replace('storage', 'public', $imagePathTrim);

            // Xóa tệp hình ảnh nếu tồn tại
            if (Storage::exists($imagePath)) {
                Storage::delete($imagePath);
            }
        }

        // Xóa bài viết khỏi cơ sở dữ liệu
        $know->delete();

        // Redirect về trang trước đó với thông báo thành công
        return redirect()->back()->with('success', 'Post deleted successfully!');
    }
}
