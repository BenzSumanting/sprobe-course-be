<?php

namespace App\Services;

use App\Http\ApiResponse\ApiResponse;
use App\Http\Resources\AssignmentResource;
use App\Http\Resources\StudentResource;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\error;

class StudentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private StudentRepository $studentRepo)
    {
        //
    }

    public function create(array $data)
    {
        try {

            DB::beginTransaction();
            $student = $this->studentRepo->create($data);

            if (request()->has('courses')) {
                $courses = $data['courses'];

                if (is_array($courses) && count($courses) === 1 && is_string($courses[0])) {
                    $courses = array_map('trim', explode(',', $courses[0]));
                }

                $student->courses()->attach($courses);
            }

            if (request()->hasFile('image')) {
                $student->addMediaFromRequest('image')->toMediaCollection('profile');
            }

            DB::commit();
            return ApiResponse::success(new StudentResource($student->load('courses')), 'Success', 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function student(string $id)
    {
        try {

            $student = $this->studentRepo->find($id, with: ['courses.assignments','submissions']);

            return ApiResponse::success(new StudentResource($student));
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function students()
    {
        try {

            $students = $this->studentRepo->all(
                sortBy: 'desc',
                orderBy: 'created_at'
            );

            return ApiResponse::success(StudentResource::collection($students));
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage());
        }
    }

    public function update(string $id, array $data)
    {

        try {
            DB::beginTransaction();
            $student = $this->studentRepo->find($id);

            if (!$student) return ApiResponse::error('Not found', 404);

            $student->update($data);

            if (request()->has('courses')) {
                $student->courses()->sync($data['courses']);
            }

            if (request()->hasFile('image')) {
                $student->clearMediaCollection('profile');
                $student->addMediaFromRequest('image')->toMediaCollection('profile');
            }

            DB::commit();
            return ApiResponse::success(new StudentResource($student->refresh()), 'Success', 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {
            $student = $this->studentRepo->find($id);

            if (!$student) return ApiResponse::error('Not found', 404);

            $student->delete();

            return ApiResponse::success();
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage());
        }
    }

    public function studentAssignments($id)
    {
        try {
            $student = $this->studentRepo->find($id, with: ['courses.assignments']);

            if (!$student) {
                return ApiResponse::error('Student not found', 404);
            }

            $assignments = $student->courses->pluck('assignments')->flatten();

            return ApiResponse::success(AssignmentResource::collection($assignments));
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage());
        }
    }

    public function submitScore(string $id, array $data)
    {
        try {
            $student = $this->studentRepo->find($id);

            $student->submissions()->create([
                'assignment_id' => $data['assignment_id'],
                'submitted_at' => $data['submitted_at'],
                'grade' => $data['grade']
            ]);

            if (!$student) return ApiResponse::error('Not found', 404);

            return ApiResponse::success($student->refresh());
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage());
        }
    }
}
