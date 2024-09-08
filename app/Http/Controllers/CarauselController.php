<?php

namespace App\Http\Controllers;

use App\Models\Carausel;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class CarauselController extends Controller
{
    public function index()
    {
        $carausels = Carausel::all();
        return view('admins.carausel.index', compact('carausels'));
    }

    public function create()
    {
        return view('admins.carausel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image|mimes:jpeg,png,,webp,jpg,gif|max:2048',
            'description' => 'required',
        ]);
        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("status") ? true : false;
        if ($request->hasFile('image')) {
            $filename = uniqid() . '.' . $request->image->getClientOriginalName();
            $request->image->move(public_path("carauselImages"),$filename);
            Carausel::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $isActive,
                'image' => 'carauselImages/' . $filename,
            ]);
        } 
        return redirect()->route('admin.carausel.index')->with('success', 'carausel created successfully.');
    }
    public function edit($id)
    {
        $carausel = Carausel::find($id);
        return view('admins.carausel.edit',compact('carausel'));
    }

    public function update(Request $request,Carausel $carausel)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
        ]);
        // Kiểm tra xem checkbox có được chọn hay không
        // $isActive = $request->has("status") ? true : false;
        if ($request->hasFile('image')) {
            $existingImagePath = public_path($carausel->image);
            if (File::exists($existingImagePath)) {
                File::delete($existingImagePath);
            }
            $filename = uniqid() . '.' . $request->image->getClientOriginalName();
            $request->image->move(public_path("carauselImages"),$filename);
            $image = 'carauselImages/' . $filename;
        }else{
            $image = $request->imageExisting;
        } 
        $carausel->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status ,
            'image' => $image
        ]);
        return redirect()->route('admin.carausel.index')->with('success', 'carausel updated successfully.');
    }
    public function delete($id)
    {
        $carausel = Carausel::find($id);
        if($carausel != null){
            // $imagePath = str_replace('storage', 'public', $carausel->image);
            $imagePath = public_path($carausel->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $carausel->delete();

        }
        return redirect()->route("admin.carausel.index")->with("success","delete carausel successfully");
    }

}
