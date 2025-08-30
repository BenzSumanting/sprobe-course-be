<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\StudentScoreRequest;
use App\Http\Requests\StudentUpdateRequest;
use App\Services\StudentService;

class StudentController extends Controller
{
    public function __construct(private StudentService $studentRepo) {}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->studentRepo->students();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentRequest $request)
    {
        return $this->studentRepo->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->studentRepo->student($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StudentUpdateRequest $request, string $id)
    {
        return $this->studentRepo->update($id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->studentRepo->delete($id);
    }

    public function studentAssignment(string $id)
    {
        return $this->studentRepo->studentAssignments($id);
    }

    public function studentScore(string $id, StudentScoreRequest $request)
    {
        return $this->studentRepo->submitScore($id, $request->validated());
    }
}
