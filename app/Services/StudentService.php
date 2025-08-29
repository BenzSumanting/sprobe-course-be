<?php

namespace App\Services;

use App\Http\ApiResponse\ApiResponse;
use App\Http\Resources\StudentResource;
use App\Repositories\StudentRepository;
use Illuminate\Support\Facades\DB;

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
            }

            if (request()->hasFile('image')) {
                $student->addMediaFromRequest('image')->toMediaCollection('profile');
            }

            DB::commit();
            return ApiResponse::success(new StudentResource($student), 'Success', 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function student(string $id)
    {
        try {

            $student = $this->studentRepo->find($id);

            return ApiResponse::success(new StudentResource($student));
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function students()
    {
        try {

            $students = $this->studentRepo->all();

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
}
