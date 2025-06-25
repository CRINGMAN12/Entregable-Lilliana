<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Course;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $projects = Project::with('course')
            ->where('user_id', auth()->id())
            ->orderBy('due_date')
            ->paginate(10);
            
        $courses = Course::where('user_id', auth()->id())->get();
            
        return view('projects.index', compact('projects', 'courses'));
    }

    public function create()
    {
        $courses = Course::where('user_id', auth()->id())->get();
        return view('projects.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:active,completed',
            'progress' => 'required|integer|min:0|max:100',
            'course_id' => 'required|exists:courses,id'
        ]);

        $project = Project::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'progress' => $validated['progress'],
            'course_id' => $validated['course_id']
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Proyecto creado exitosamente.');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        $courses = Course::where('user_id', auth()->id())->get();
        return view('projects.edit', compact('project', 'courses'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:active,completed',
            'progress' => 'required|integer|min:0|max:100',
            'course_id' => 'required|exists:courses,id'
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Proyecto actualizado exitosamente.');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Proyecto eliminado exitosamente.');
    }

    public function updateProgress(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $request->validate([
            'progress' => 'required|integer|min:0|max:100'
        ]);

        $project->progress = $validated['progress'];
        if ($validated['progress'] === 100) {
            $project->status = 'completed';
        }
        $project->save();

        return response()->json([
            'success' => true,
            'progress' => $project->progress,
            'status' => $project->status
        ]);
    }
} 