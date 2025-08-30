<?php

namespace App\Models;

use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, HasUlid, SoftDeletes;

    protected $fillable = ['course_id', 'title', 'description', 'due_date'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // public function submissions()
    // {
    //     return $this->hasMany(Submission::class);
    // }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'submissions')
            ->using(Submission::class)
            ->withPivot(['grade', 'submitted_at'])
            ->withTimestamps();
    }
}
