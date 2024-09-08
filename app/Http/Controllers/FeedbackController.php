<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class FeedbackController extends Controller
{
    //client
    public function index()
    {
        $feedbacks = Feedback::all();
        return view("clients.feedback.index", compact("feedbacks"));
    }
    //admin
    public function indexAdmin()
    {
        $feedbacks = Feedback::all();
        return view("admins.feedback.index", compact("feedbacks"));
    }
    public function create()
    {
        return view("admins.feedback.create");
    }
    public function store(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,webp,jpg,gif,svg|max:2048',
            'name' => 'required',
            'content' => 'required',
        ]);
        try {
            if ($request->hasFile('avatar')) {
                $fileAvatar = uniqid() . '.' . $request->avatar->getClientOriginalName();
                $request->image->move(public_path("feedbackImages"), $fileAvatar);
            }
            Feedback::create([
                'avatar' => '/feedbackImages/' . $fileAvatar,
                'status' => $request->status,
                'name' => $request->name,
                'content' => $request->content
            ]);
            return redirect()->route('admin.feedback.index')->with('success', 'Feedback created successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Opp error serve.');
        }
    }
    public function edit($id)
    {
        $feed = Feedback::find($id);
        return view("admins.feedback.edit", compact('feed'));
    }
    public function update(Request $request, Feedback $feed)
    {
        $request->validate([
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required',
            'content' => 'required',
        ]);
        try {
            // Kiểm tra xem checkbox có được chọn hay không
            if ($request->hasFile('avatar')) {
                $fileAvatar = uniqid() . '.' . $request->avatar->getClientOriginalName();
                $request->avatar->move(public_path("feedbackImages"), $fileAvatar);
                $avatarPath = '/feedbackImages/' . $fileAvatar;
                $imagePath = public_path($request->avatarExisting);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            } else {
                $avatarPath = $request->avatarExisting;
            }
            $feed->update([
                'avatar' => $avatarPath,
                'status' => $request->status,
                'name' => $request->name,
                'content' => $request->content
            ]);
            return redirect()->route('admin.feedback.index')->with('success', 'Feedback updated successfully.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('info', 'Opp error serve.');
        }
    }
    public function delete($id)
    {
        $feedback = Feedback::find($id);
        if ($feedback != null) {
            $imagePath = public_path($feedback->avatar);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
            $feedback->delete();

        }
        return redirect()->route('admin.feedback.index')->with("success", "delete course successfully");
    }
}
