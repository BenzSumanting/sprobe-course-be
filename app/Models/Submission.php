<?php

namespace App\Models;

use App\app\Traits\HasUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
   use HasFactory, HasUlid, SoftDeletes;

    protected $fillable = ['assignment_id', 'student_id', 'submitted_at', 'grade'];

    public function assignment() {
        return $this->belongsTo(Assignment::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }
}
