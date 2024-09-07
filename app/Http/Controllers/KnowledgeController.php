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
        if($know){
            return view("clients.knowledge.detail", compact("know"));
        }
        return redirect()->back();
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
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'title' => 'required',
            'thumbnail' => 'image|nullable|max:1999',
            'description' => 'required'
        ]);
    
        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("status") ? true : false;
    
        // Kiểm tra nếu có tệp ảnh được tải lên
        if ($request->hasFile('thumbnail')) {
            // Tạo tên tệp ảnh độc nhất
            $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalName();
            // Lưu ảnh vào thư mục 'public/knowImages'
            $request->thumbnail->storeAs('public/knowImages', $filename);
    
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
                    $path = storage_path('app/public/uploads/') . $image_name;
    
                    // Lưu file vào storage
                    file_put_contents($path, $data);
                    // Cập nhật đường dẫn ảnh trong nội dung
                    $img->removeAttribute('src');
                    $img->setAttribute('src', '/storage/uploads/' . $image_name);
                }
            }
            $description = $dom->saveHTML();
    
            // Tạo bản ghi mới trong cơ sở dữ liệu
            Knowledge::create([
                'title' => $request->title,
                'description' => $description,
                'sort_content' => $request->sort_content,
                'status' => $isActive,
                'thumbnail' => 'storage/knowImages/' . $filename,
            ]);
        } else {
            // Nếu không có ảnh tải lên, chuyển hướng về trang danh sách với thông báo lỗi
            return redirect()->route('admin.knows.index')->with('thumbnail', 'Image is required.');
        }
    
        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('admin.knows.index')->with('success', 'Knows created successfully.');
    }
    
    /**
     * Làm sạch HTML để loại bỏ các thẻ không hợp lệ
     */
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
    
    public function editKnow($id)
    {
        $know = Knowledge::find($id);
        return view("admins.knows.edit", compact("know"));
    }
    public function updateKnow(Request $request, Knowledge $know)
{
    // Xác thực dữ liệu đầu vào
    $request->validate([
        'title' => 'required',
        'thumbnail' => 'image|nullable|max:1999',
        'description' => 'required',
    ]);

    // Kiểm tra xem checkbox có được chọn hay không
    $isActive = $request->has('status');

    // Xử lý tải ảnh thumbnail
    if ($request->hasFile('thumbnail')) {
        // Tạo tên tệp ảnh độc nhất
        $filename = uniqid() . '.' . $request->thumbnail->getClientOriginalExtension();
        // Lưu ảnh vào thư mục 'public/knowImages'
        $request->thumbnail->storeAs('public/knowImages', $filename);
        $thumbnail = 'storage/knowImages/' . $filename;
    } else {
        // Giữ nguyên thumbnail cũ nếu không có ảnh mới
        $thumbnail = $request->input('thumbnailExisted');
    }

    // Lấy và xử lý nội dung mô tả
    $description = $request->input('description');
    $deletedImages = json_decode($request->input('deleted_images'), true);

    // Xóa các ảnh đã được đánh dấu để xóa
    if ($deletedImages) {
        foreach ($deletedImages as $image) {
            $parsedUrl = parse_url($image, PHP_URL_PATH);
            $imagePathUrl = ltrim($parsedUrl, '/');
            $imagePath = str_replace('storage', 'public', $imagePathUrl);
            Storage::delete($imagePath);
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
            $path = storage_path('app/public/uploads/') . $image_name;

            // Lưu tệp vào storage
            file_put_contents($path, $data);

            // Cập nhật đường dẫn ảnh trong nội dung HTML
            $img->removeAttribute('src');
            $img->setAttribute('src', '/storage/uploads/' . $image_name);
        }
    }

    $description = $dom->saveHTML();

    // Cập nhật bản ghi Knowledge
    $know->update([
        'title' => $request->input('title'),
        'description' => $description,
        'sort_content' => $request->input('sort_content'),
        'status' => $isActive,
        'thumbnail' => $thumbnail,
    ]);

    // Chuyển hướng về trang danh sách với thông báo thành công
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
