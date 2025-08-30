<?php

namespace App\Models;

use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Support\Facades\Cache;

class Student extends Model implements HasMedia
{
    use HasFactory, HasUlid, SoftDeletes, InteractsWithMedia;

    protected $fillable = ['name', 'email', 'age'];

    public static function booted()
    {
       static::created(function ($student) {
            Cache::forget('students_all');
        });

        static::updated(function ($student) {
            Cache::forget("student_{$student->id}");
            Cache::forget('students_all');
        });

        static::deleted(function ($student) {
            Cache::forget("student_{$student->id}");
            Cache::forget('students_all');
        });
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    protected $appends = [
        'profile',
    ];

    public function getProfileAttribute()
    {
        return $this->getFirstMediaUrl(collectionName: 'profile');
    }
    
}
