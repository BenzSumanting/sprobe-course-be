<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Student $model)
    {
        parent::__construct($model);
    }
}
