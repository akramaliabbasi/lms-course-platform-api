<?php

namespace App\Http\Controllers\API\V1; 

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return response()->json($courses);
    }

    public function show($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        return response()->json($course);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'teacher_id' => 'required|exists:users,id',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date',
            'status' => 'required|in:enabled,disabled',
        ]);

        $course = Course::create($request->all());

        return response()->json($course, 201);
    }

    public function update(Request $request, $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'teacher_id' => 'required|exists:users,id',
            'started_at' => 'nullable|date',
            'finished_at' => 'nullable|date',
            'status' => 'required|in:enabled,disabled',
        ]);

        $course->update($request->all());

        return response()->json($course);
    }

    public function destroy($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['message' => 'Course not found'], 404);
        }

        $course->delete();

        return response()->json(['message' => 'Course deleted']);
    }
}
