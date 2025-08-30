<?php

namespace App\Services;

use App\Http\ApiResponse\ApiResponse;
use App\Http\Resources\AssignmentResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Repositories\AssignmentRepository;

class AssignmentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(private AssignmentRepository $assignmentRepo)
    {
        //
    }

    public function create(array $data)
    {
        try {
            DB::beginTransaction();

            $assignment = $this->assignmentRepo->create($data);

            DB::commit();
            return ApiResponse::success(new AssignmentResource($assignment), 'Success', 201);
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function assignment(string $id)
    {
        try {

            $assignment = Cache::remember("assignment_{$id}", now()->addMinutes(10), function () use ($id) {
                return $this->assignmentRepo->find($id, with: ['course']);
            });


            return ApiResponse::success(new AssignmentResource($assignment->load('course')));
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function assignments()
    {
        try {

            $assignments = Cache::remember('assignments_all', now()->addMinutes(10), function () {
                return $this->assignmentRepo->all(with: ['course']);
            });

            return ApiResponse::success(AssignmentResource::collection($assignments));
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function update(string $id, array $data)
    {
        try {
            DB::beginTransaction();
            $assignment = $this->assignmentRepo->find($id);

            if (!$assignment) return ApiResponse::error('Not found', 404);

            $assignment->update($data);

            DB::commit();
            return ApiResponse::success(new AssignmentResource($assignment->refresh()), 'Success', 200);
        } catch (\Throwable $th) {
            DB::rollback();
            return ApiResponse::error($th->getMessage());
        }
    }

    public function delete(string $id)
    {
        try {
            $assignment = $this->assignmentRepo->find($id);

            if (!$assignment) return ApiResponse::error('Not found', 404);

            $assignment->delete();

            return ApiResponse::success();
        } catch (\Throwable $th) {
            return ApiResponse::error($th->getMessage());
        }
    }
}
