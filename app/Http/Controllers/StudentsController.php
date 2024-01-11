<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\StudentsResource;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Imports\StudentsImport;
use Maatwebsite\Excel\Facades\Excel;

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

        // Handle cases where no student is found
        if (!$student) {
            return response()->json(['message' => 'Student not found'], 404);
        }
        else{
            return StudentsResource::collection($student);
        }
    }

    public function importStudents(Request $request)
    {
        // Validate the request, ensuring that a file is present
        $request->validate([
            'file' => 'required|mimes:csv,xlsx',
        ]);

        // Get the file from the request
        $file = $request->file('file');

        // Use Laravel Excel to import the data using the StudentsImport class
        Excel::import(new StudentsImport, $file);

        // Return a response or redirect as needed
        return response()->json(['message' => 'Students import completed successfully']);
    }
}
