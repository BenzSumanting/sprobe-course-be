<?php

namespace App\Models;

use App\app\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, HasUlid, SoftDeletes;

    protected $fillable = ['name', 'email', 'enrollment_date'];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
