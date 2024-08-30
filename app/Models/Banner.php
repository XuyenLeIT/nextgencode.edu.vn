<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = ["title","image","sortContent","status","startDate","promotion","course_id"];
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
