<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Course;
use App\Models\Knowledge;
use App\Models\TimeLine;
use Illuminate\Http\Request;

class ClientController extends Controller
{
  public function home()
  {
    $courses = Course::all();
    $knows = Knowledge::orderBy('created_at', 'desc')->take(4)->get();
    $banner = Banner::first();
    $timelines = TimeLine::all();
    return view("clients.home", compact("courses", "knows", "banner", "timelines"));
  }
  public function course($slug, $id)
  {
    $course = Course::find($id);
    if (!($course->status)) {
      return redirect()->route("client.home");
    }
    if ($course) {
      return view("clients.course_detail", [
        'course' => $course,
        'pageTitle' => $course->name,
        'pageDescription' => $course->DesCourse->description,
        'pageImage' => $course->thumbnail,
        'pageUrl' => url()->current(),
      ]);

    }

  }
}
