<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Course;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banner = Banner::first();
        $courses = Course::all();
        if($banner){
            return redirect()->route('admin.banner.edit',["id"=> $banner->id]);
        }else{
            return view("banner.create",compact("courses"));
        }
      
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'startDate' => 'required',
            'promotion' => 'required',
            'image' => 'required|image|mimes:jpeg,png,,webp,jpg,gif|max:2048',
            'sortContent' => 'required',
        ]);
        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("status") ? true : false;
        if ($request->hasFile('image')) {
            $filename = uniqid() . '.' . $request->image->getClientOriginalName();
            $request->image->storeAs('public/bannerImages', $filename);
            Banner::create([
                'title' => $request->title,
                'sortContent' => $request->sortContent,
                'promotion' => $request->promotion,
                'startDate' => $request->startDate,
                'status' => $isActive,
                'image' => '/storage/bannerImages/' . $filename,
            ]);
        } 
        return redirect()->back()->with('success', 'banner created successfully.');
    }
    public function edit($id)
    {
        $courses = Course::all();
        $banner = Banner::find($id);
        return view('admins.banner.edit',compact('banner',"courses"));
    }

    public function update(Request $request,Banner $banner)
    {
        $request->validate([
            'title' => 'required',
            'startDate' => 'required',
            'promotion' => 'required',
            'image' => 'image|mimes:jpeg,png,,webp,jpg,gif|max:2048',
            'sortContent' => 'required',
            'course_id' => 'required',
        ]);
        $imagePath = "";
        // Kiểm tra xem checkbox có được chọn hay không
        $isActive = $request->has("status") ? true : false;
        if ($request->hasFile('image')) {
            $filename = uniqid() . '.' . $request->image->getClientOriginalName();
            $request->image->storeAs('public/bannerImages', $filename);
            $imagePath = '/storage/bannerImages/' . $filename;
        } else{
            $imagePath =  $request->imageExisting;
        }
        $banner->update([
            'title' => $request->title,
            'sortContent' => $request->sortContent,
            'promotion' => $request->promotion,
            'startDate' => $request->startDate,
            'status' => $isActive,
            'image' => $imagePath,
            'course_id' =>$request->course_id
        ]);
        return redirect()->back()->with('success', 'banner updated successfully.');
    }
}
