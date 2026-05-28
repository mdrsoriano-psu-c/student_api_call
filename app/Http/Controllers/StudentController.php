<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    // GET all students
    public function index()
    {
        return response()->json(Student::all(), 200);
    }

    // GET one student by ID
    public function show($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        return response()->json($student, 200);
    }

    // POST create student
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
        ]);

        $student = Student::create([
            'name' => $request->name,
            'course' => $request->course,
        ]);

        return response()->json([
            'message' => 'Student added successfully',
            'data' => $student
        ], 201);
    }

    // PUT update student
    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        // validation
        $request->validate([
            'name' => 'required|string|max:255',
            'course' => 'required|string|max:255',
        ]);

        $student->update([
            'name' => $request->name,
            'course' => $request->course,
        ]);

        return response()->json([
            'message' => 'Student updated successfully',
            'data' => $student
        ], 200);
    }

    // PATCH partial update
    public function patch(Request $request, $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        // update only provided fields
        if ($request->has('name')) {
            $student->name = $request->name;
        }

        if ($request->has('course')) {
            $student->course = $request->course;
        }

        $student->save();

        return response()->json([
            'message' => 'Student patched successfully',
            'data' => $student
        ], 200);
    }

    // DELETE one student
    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Student not found'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Student deleted successfully'
        ], 200);
    }

    // DELETE all students
    public function destroyAll()
    {
        Student::truncate();

        return response()->json([
            'message' => 'All students deleted successfully'
        ], 200);
    }
}