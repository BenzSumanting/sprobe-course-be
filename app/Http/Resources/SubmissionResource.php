<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
        'id' => $this->id,
        'student_id' => $this->student_id,
        'assignment_id' => $this->assignment_id,
        'student' => new StudentResource($this->whenLoaded('student')),
        'assignment' => new AssignmentResource($this->whenLoaded('assignment')),
        'submitted_at' => Carbon::parse($this->submitted_at)->format('Y-m-d'),
        'grade' => $this->grade
       ];
    }
}
