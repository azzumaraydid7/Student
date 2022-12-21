<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StudentRegisterRequest;
use App\Models\Student;
use Image;

class StudentController extends Controller
{
    public function getAllStudents() {
        $students = Student::orderBy('id', 'DESC')->get();

        $data = [
            'students' => $students
        ];

        return response()->json($data, 200);
    }

    public function addStudent(StudentRegisterRequest $request) {
        $request->validated();

        $student = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
            'student_registration_number' => $request->student_registration_number,
            'contact_number' => $request->contact_number
        ];

        $file = $request->photo;

        if($file != ""){
            $fileName = time().'.'.$file->extension();
            $file->move(public_path('upload'), $fileName);
            $student['photo'] = $fileName;
        } else {
            $student['photo'] = "no-image.png";
        }

        Student::create($student);

        $data = [
            'message' => 'Student created'
        ];

        return response()->json($data, 200);
    }

    public function editStudent($id) {
        $student = Student::find($id);

        $data = [
            'student' => $student
        ];

        return response()->json($data, 200);
    }

    public function updateStudent(StudentRegisterRequest $request, $id) {
        $student = Student::find($id);

        $request->validated();

        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->address = $request->address;
        $student->student_registration_number = $request->student_registration_number;
        $student->contact_number = $request->contact_number;

        $file = $request->photo;

        if($file != ""){
            $fileName = time().'.'.$file->extension();
            $file->move(public_path('upload'), $fileName);
            $student->photo = $fileName;
        }

        $student->save();

        $data = [
            'message' => 'Student updated'
        ];

        return response()->json($data, 200);
    }

    public function deleteStudent($id) {
        $student = Student::findOrFail($id);

        $student->delete();

        $data = [
            "message" => "Student deleted"
        ];

        return response()->json($data, 200);
    }
}
