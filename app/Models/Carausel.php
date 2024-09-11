<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carausel extends Model
{
    use HasFactory;
    protected $fillable = ["title","image","description","course_id","status"];
    public function course()
    {
        return $this->belongsTo(Course::class,"course_id");
    }
}
