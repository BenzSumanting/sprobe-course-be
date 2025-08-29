<?php

namespace App\Repositories;

use App\Models\Course;

class CourseRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Course $model)
    {
        parent::__construct($model);
    }
}
