<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index()
    {
        $student = Student::all();

        $data = [
            'status' => 200,
            'students' => $student
        ];

        return response()->json($data, 200);
    }


    public function addStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'role_number' => 'required|integer',
        ]);

        if ($validator->fails()) {
            $data = [
                "status" => 422,
                "message" => $validator->errors()
            ];

            return response()->json($data, 422);
        } else {
            $student = new Student;

            $student->name = $request->name;
            $student->email = $request->email;
            $student->role_number = $request->role_number;
            $student->class = $request->class;

            $student->save();

            $data = [
                "status" => 200,
                "message" => "Data uploaded successfully"
            ];

            return response()->json($data, 200);
        }
    }

    public function editStudent(Request $request, $id)
    {

        $student = Student::find($id);


        if (!$student) {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:students,email,' . $id,
            'role_number' => 'sometimes|integer',
            'class' => 'sometimes|integer'
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        }


        if ($request->has('name')) {
            $student->name = $request->name;
        }
        if ($request->has('email')) {
            $student->email = $request->email;
        }
        if ($request->has('role_number')) {
            $student->role_number = $request->role_number;
        }
        if ($request->has('class')) {
            $student->class = $request->class;
        }

        $student->save();


        $data = [
            'status' => 200,
            'message' => 'student updated successfully',
            'student' => $student
        ];

        return response()->json([
            'status' => 200,
            $data
        ]);
    }

    public function deleteStudent($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'status' => 404,
                'message' => 'Student not found'
            ]);
        }

        $student->delete();

        return response()->json(['status' => 200, 'message' => 'student has deleted']);
    }
}
