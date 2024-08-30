<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ["name","startDate","thumbnail","duration","typeLearn","letter","status","dayweek","stunumber","hourday","class"];
    public function BannerCourse()
    {
        return $this->hasOne(Banner::class);
    }
    public function DesCourse()
    {
        return $this->hasOne(DesCourse::class);
    }
    public function whoCourse()
    {
        return $this->hasOne(WhoCourse::class);
    }
    public function achivesCourse()
    {
        return $this->hasMany(AchiveCourse::class);
    }
    public function modulesCourse()
    {
        return $this->hasMany(ModuleCourse::class,"course_id");
    }
    public function user()
    {
        return $this->belongsTo(Course::class,"id");
    }
}
