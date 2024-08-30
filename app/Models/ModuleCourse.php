<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleCourse extends Model
{
    use HasFactory;
    protected $fillable = ["title","course_id","status","stt"];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function outlines()
    {
        return $this->hasMany(OutlineModule::class,"module_id");
    }
}
