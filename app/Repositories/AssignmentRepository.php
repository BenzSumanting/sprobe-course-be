<?php

namespace App\Repositories;

use App\Models\Assignment;

class AssignmentRepository extends BaseRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(Assignment $model)
    {
        parent::__construct($model);
    }
}
