<?php

namespace App\Models;

use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Course extends Model
{
    use HasFactory, HasUlid, SoftDeletes;

    protected $fillable = ['title', 'description', 'credits'];

    public static function booted()
    {
        static::created(function ($course) {
            Cache::forget('courses_all');
        });

        static::updated(function ($course) {
            Cache::forget("course_{$course->id}");
            Cache::forget('courses_all');
        });

        static::deleted(function ($course) {
            Cache::forget("course_{$course->id}");
            Cache::forget('courses_all');
        });
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
