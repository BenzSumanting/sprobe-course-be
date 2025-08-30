<?php

namespace App\Services;

use App\Http\ApiResponse\ApiResponse;
use App\Http\Resources\CourseResource;
use App\Repositories\CourseRepository;
use Illuminate\Support\Facades\DB;

class CourseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private CourseRepository $courseRepo)
    {
        //
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();

            $course = $this->courseRepo->create($data);

            DB::commit();
            return ApiResponse::success(new CourseResource($course), 'Success', 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function course(string $id)
    {
        try {

            $course = $this->courseRepo->find($id, with: ['assignments']);

            return ApiResponse::success(new CourseResource($course));
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function courses()
    {
        try {

            $courses = $this->courseRepo->all();

            return ApiResponse::success(CourseResource::collection($courses));
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage());
        }
    }

    public function update(string $id, array $data)
    {
        try {
            DB::beginTransaction();
            $course = $this->courseRepo->find($id);

            if (!$course) return ApiResponse::error('Not found', 404);

            $course->update($data);

            DB::commit();
            return ApiResponse::success(new CourseResource($course->refresh()), 'Success', 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {
            $student = $this->courseRepo->find($id);

            if (!$student) return ApiResponse::error('Not found', 404);

            $student->delete();

            return ApiResponse::success();
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage());
        }
    }
}
