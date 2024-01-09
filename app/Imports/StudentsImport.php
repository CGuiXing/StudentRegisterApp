<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    private $processedEmails = [];

    public function model(array $row)
    {
        // Retrieve all students with the given email
        $existingStudents = Student::where('email', $row['email'])->get();

        // Loop through the existing students and update each one
        foreach ($existingStudents as $existingStudent) {
            $existingStudent->update([
                'name' => $row['name'],
                'email' => $row['email'],
                'address' => $row['address'],
                'study_course' => $row['study_course'],
            ]);
        }

        // If no existing students are found, create a new student
        if ($existingStudents->isEmpty()) {
            $newStudent = new Student([
                'name' => $row['name'],
                'email' => $row['email'],
                'address' => $row['address'],
                'study_course' => $row['study_course'],
            ]);
            $newStudent->save();

            $this->processedEmails[] = $row['email'];
        }
    }

    public function onCompleted()
    {
        // Delete students not present in the import file
        Student::whereNotIn('email', $this->processedEmails)->delete();
    }
}
