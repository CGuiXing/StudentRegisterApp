<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class StudentsImport implements ToModel, WithHeadingRow
{
    use RegistersEventListeners;
    private $processedIds = [];

    public function model(array $row)
    {
        // Retrieve the student with the given id
        $existingStudent = Student::find($row['id']);

        // If the student exists, update the record
        if ($existingStudent) {
            $existingStudent->update([
                'name' => $row['name'],
                'email' => $row['email'],
                'address' => $row['address'],
                'study_course' => $row['study_course'],
            ]);
        } else {
            // If no existing student is found, create a new student
            $newStudent = new Student([
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'address' => $row['address'],
                'study_course' => $row['study_course'],
            ]);

            $newStudent->save();
        }

        $this->processedIds[] = $row['id'];
        
        Student::whereNotIn('id', $this->processedIds)->delete();
    }
}
