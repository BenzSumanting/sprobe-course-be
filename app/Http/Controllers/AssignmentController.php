<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignmentRequest;
use App\Http\Requests\AssignmentUpdateRequest;
use App\Services\AssignmentService;

class AssignmentController extends Controller
{

    public function __construct(private AssignmentService $assignmentService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->assignmentService->assignments();
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
    public function store(AssignmentRequest $request)
    {
        return $this->assignmentService->create($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->assignmentService->assignment($id);
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
    public function update(AssignmentUpdateRequest $request, string $id)
    {
        return $this->assignmentService->update($id, $request->validated());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->assignmentService->delete($id);
    }
}
