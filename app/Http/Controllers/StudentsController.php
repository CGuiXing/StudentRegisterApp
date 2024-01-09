<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\StudentsResource;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 10;
        $students = Student::paginate($pageSize);

        // Handle cases where no students are found.
        if ($students->isEmpty()) {
            return response()->json(['message' => 'No students found'], 404);
        }
        return StudentsResource::collection($students);
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
    public function store(StoreStudentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //return new StudentsResource($student);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        //
    }

    /**
     * Search the specified resource from storage.
     */
    public function search_name($name)
    {
        $student = Student::where('name', 'like', '%'.$name.'%')->get();

        // Handle cases where no student is found.
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        else{
            return StudentsResource::collection($student);
        }
        
    }

    public function search_email($email)
    {
        $student = Student::where('email', 'like', '%'.$email.'%')->get();

        // You may want to handle cases where no student is found
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        else{
            return StudentsResource::collection($student);
        }
        
    }
}
