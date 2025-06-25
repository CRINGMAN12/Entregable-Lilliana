<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Course;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Task::with('course')
            ->where('user_id', auth()->id());

        // Filtrar por curso si se especifica
        if ($request->has('course') && $request->course !== '') {
            $query->where('course_id', $request->course);
        }

        // Filtrar por estado si se especifica
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $tasks = $query->orderBy('due_date')->paginate(10);
        $courses = Course::where('user_id', auth()->id())->get();
            
        return view('tasks.index', compact('tasks', 'courses'));
    }

    public function create()
    {
        $courses = Course::where('user_id', auth()->id())->get();
        return view('tasks.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,completed',
            'course_id' => 'required|string'
        ]);

        // Si el course_id es una materia predefinida, crear o encontrar el curso
        if (!is_numeric($validated['course_id'])) {
            $predefinedCourses = Course::getPredefinedCourses();
            $courseName = null;
            
            // Buscar el nombre de la materia en las categorías predefinidas
            foreach ($predefinedCourses as $category => $courses) {
                if (isset($courses[$validated['course_id']])) {
                    $courseName = $courses[$validated['course_id']];
                    break;
                }
            }

            if ($courseName) {
                // Buscar si ya existe el curso para este usuario
                $course = Course::where('user_id', auth()->id())
                    ->where('name', $courseName)
                    ->first();

                // Si no existe, crear el curso
                if (!$course) {
                    $course = Course::create([
                        'user_id' => auth()->id(),
                        'name' => $courseName,
                        'code' => strtoupper(substr($validated['course_id'], 0, 3)),
                        'credits' => 3,
                        'teacher' => 'Por asignar',
                        'schedule' => 'Por asignar',
                        'color' => '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT),
                        'semester' => '2024-1',
                        'professor' => 'Por asignar'
                    ]);
                }

                $validated['course_id'] = $course->id;
            }
        }

        $task = Task::create([
            'user_id' => auth()->id(),
            'course_id' => $validated['course_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_date' => $validated['start_date'],
            'due_date' => $validated['due_date'],
            'priority' => $validated['priority'],
            'status' => $validated['status']
        ]);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea creada exitosamente.');
    }

    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $courses = Course::where('user_id', auth()->id())->get();
        return view('tasks.edit', compact('task', 'courses'));
    }

    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,completed'
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea actualizada exitosamente.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Tarea eliminada exitosamente.');
    }

    public function toggleStatus(Task $task)
    {
        try {
            $this->authorize('update', $task);

            $task->status = $task->status === 'completed' ? 'pending' : 'completed';
            $task->save();

            return response()->json([
                'success' => true,
                'status' => $task->status,
                'message' => $task->status === 'completed' ? 'Tarea marcada como completada' : 'Tarea marcada como pendiente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el estado de la tarea'
            ], 500);
        }
    }
} 