<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutlineModule extends Model
{
    use HasFactory;
    protected $fillable = ["title","description","module_id","status"];
    public function module_courses()
    {
        return $this->belongsTo(ModuleCourse::class,"id");
    }
}
