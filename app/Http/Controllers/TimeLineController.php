<?php

namespace App\Http\Controllers;

use App\Models\TimeLine;
use Illuminate\Http\Request;

class TimeLineController extends Controller
{
    public function index()
    {
        $timelines = TimeLine::all();
        return view('admins.timeline.index', compact('timelines'));
    }

    public function create()
    {
        return view('admins.timeline.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            "title"=>"required",
            "content"=> "required",
            "type"=> "required",
        ]);
        TimeLine::create($request->all());
        return redirect()->route("admin.timeline.index")->with("success","Create timeline successfully");
    }
}
