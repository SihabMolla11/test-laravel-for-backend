<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{

    public function addedTeacher(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'subject' => 'required|string'
        ]);

        if ($validator->fails()) {
            $data = [
                "status" => 422,
                "message" => $validator->errors()
            ];

            return response()->json($data, 422);
        } else {
            $teacher = new Teacher;

            $teacher->name = $request->name;
            $teacher->email = $request->email;
            $teacher->subject = $request->subject;
            $teacher->education = $request->education;
            $teacher->is_class_teacher = $request->is_class_teacher;

            $teacher->save();

            $data = [
                "status" => 200,
                "message" => "Data uploaded successfully"
            ];

            return response()->json($data, 200);
        }
    }

    public function getSingleTeacher(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return  response(['status' => 404, 'message' => 'Teacher not found']);
        }

        return  response(['status' => 200, 'message' => 'Teacher get Successful', 'teacher' => $teacher]);
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                'status' => 404,
                'message' => 'Teacher Not found'
            ]);
        }

        if ($request->has('name')) {
            $teacher->name = $request->name;
        }

        if ($request->has('email')) {
            $teacher->email = $request->email;
        }

        if ($request->has('subject')) {
            $teacher->subject = $request->subject;
        }

        if ($request->has('education')) {
            $teacher->education = $request->education;
        }

        if ($request->has('is_class_teacher')) {
            $teacher->is_class_teacher = $request->is_class_teacher;
        }

        $teacher->save();

        $data = [
            'status' => 200,
            'message' => 'teacher updated successfully',
            'teacher' => $teacher
        ];

        return response()->json(
            $data
        );
    }
}
