<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = ["name","email","password","phone","status","course_id","role","class","otp"];
    public function courses()
    {
        return $this->hasMany(Course::class,"id");
    }
}
