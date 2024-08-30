<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchiveCourse extends Model
{
    use HasFactory;
    protected $fillable = ["title","course_id","thumbnail","description","status"];
    public function course()
    {
        return $this->belongsTo(Course::class,"course_id");
    }
}
