<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Reminder;
use App\Models\Course;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $courses = Course::where('user_id', Auth::id())->get();
        $tags = Tag::where('user_id', Auth::id())->get();

        return view('calendario.index', compact('courses', 'tags'));
    }

    public function events()
    {
        $events = collect();

        // Obtener tareas
        $tasks = Task::where('user_id', auth()->id())
            ->where('due_date', '>=', Carbon::now()->startOfMonth())
            ->where('due_date', '<=', Carbon::now()->endOfMonth())
            ->get()
            ->map(function ($task) {
                return [
                    'id' => 'task-' . $task->id,
                    'title' => $task->title,
                    'start' => $task->due_date,
                    'end' => $task->due_date,
                    'color' => '#3B82F6',
                    'type' => 'task',
                    'description' => $task->description,
                    'status' => $task->status,
                    'priority' => $task->priority
                ];
            });

        // Obtener proyectos
        $projects = Project::where('user_id', auth()->id())
            ->where('due_date', '>=', Carbon::now()->startOfMonth())
            ->where('due_date', '<=', Carbon::now()->endOfMonth())
            ->get()
            ->map(function ($project) {
                return [
                    'id' => 'project-' . $project->id,
                    'title' => $project->title,
                    'start' => $project->due_date,
                    'end' => $project->due_date,
                    'color' => '#10B981',
                    'type' => 'project',
                    'description' => $project->description,
                    'status' => $project->status,
                    'progress' => $project->progress
                ];
            });

        // Obtener recordatorios
        $reminders = Reminder::where('user_id', auth()->id())
            ->where('due_date', '>=', Carbon::now()->startOfMonth())
            ->where('due_date', '<=', Carbon::now()->endOfMonth())
            ->get()
            ->map(function ($reminder) {
                return [
                    'id' => 'reminder-' . $reminder->id,
                    'title' => $reminder->title,
                    'start' => $reminder->due_date,
                    'end' => $reminder->due_date,
                    'color' => '#F59E0B',
                    'type' => 'reminder',
                    'description' => $reminder->description,
                    'status' => $reminder->status
                ];
            });

        $events = $events->concat($tasks)->concat($projects)->concat($reminders);

        return response()->json($events);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date',
            'type' => 'required|in:task,project,reminder'
        ]);

        switch ($validated['type']) {
            case 'task':
                $event = Task::create([
                    'user_id' => auth()->id(),
                    'title' => $validated['title'],
                    'description' => $validated['description'],
                    'due_date' => $validated['start'],
                    'status' => 'pending',
                    'priority' => 'medium'
                ]);
                break;
            case 'project':
                $event = Project::create([
                    'user_id' => auth()->id(),
                    'title' => $validated['title'],
                    'description' => $validated['description'],
                    'due_date' => $validated['start'],
                    'status' => 'active',
                    'progress' => 0
                ]);
                break;
            case 'reminder':
                $event = Reminder::create([
                    'user_id' => auth()->id(),
                    'title' => $validated['title'],
                    'description' => $validated['description'],
                    'due_date' => $validated['start'],
                    'status' => 'pending'
                ]);
                break;
        }

        return response()->json([
            'id' => $validated['type'] . '-' . $event->id,
            'title' => $event->title,
            'start' => $event->due_date,
            'end' => $event->due_date,
            'color' => $this->getEventColor($validated['type']),
            'type' => $validated['type']
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date'
        ]);

        list($type, $id) = explode('-', $id);

        switch ($type) {
            case 'task':
                $event = Task::findOrFail($id);
                break;
            case 'project':
                $event = Project::findOrFail($id);
                break;
            case 'reminder':
                $event = Reminder::findOrFail($id);
                break;
        }

        $this->authorize('update', $event);

        $event->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['start']
        ]);

        return response()->json([
            'id' => $type . '-' . $event->id,
            'title' => $event->title,
            'start' => $event->due_date,
            'end' => $event->due_date,
            'color' => $this->getEventColor($type),
            'type' => $type
        ]);
    }

    public function destroy($id)
    {
        list($type, $id) = explode('-', $id);

        switch ($type) {
            case 'task':
                $event = Task::findOrFail($id);
                break;
            case 'project':
                $event = Project::findOrFail($id);
                break;
            case 'reminder':
                $event = Reminder::findOrFail($id);
                break;
        }

        $this->authorize('delete', $event);
        $event->delete();

        return response()->json(['success' => true]);
    }

    private function getEventColor($type)
    {
        switch ($type) {
            case 'task':
                return '#3B82F6';
            case 'project':
                return '#10B981';
            case 'reminder':
                return '#F59E0B';
            default:
                return '#6B7280';
        }
    }
} 