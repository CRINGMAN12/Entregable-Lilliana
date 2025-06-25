<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $courses = Course::where('user_id', auth()->id())
            ->orderBy('name')
            ->get();
            
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'credits' => 'required|integer|min:1|max:10',
            'teacher' => 'required|string|max:255',
            'schedule' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $course = Course::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'code' => $validated['code'],
            'credits' => $validated['credits'],
            'teacher' => $validated['teacher'],
            'schedule' => $validated['schedule'],
            'description' => $validated['description']
        ]);

        return redirect()->route('courses.index')
            ->with('success', 'Curso creado exitosamente.');
    }

    public function show(Course $course)
    {
        $this->authorize('view', $course);
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'credits' => 'required|integer|min:1|max:10',
            'teacher' => 'required|string|max:255',
            'schedule' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $course->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Curso actualizado exitosamente.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        $course->delete();

        return redirect()->route('courses.index')
            ->with('success', 'Curso eliminado exitosamente.');
    }
} 