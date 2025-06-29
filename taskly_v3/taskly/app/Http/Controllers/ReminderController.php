<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\Course;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $reminders = Reminder::with('course')
            ->where('user_id', auth()->id())
            ->orderBy('due_date')
            ->get();
            
        return view('reminders.index', compact('reminders'));
    }

    public function create()
    {
        $courses = Course::where('user_id', auth()->id())->get();
        return view('reminders.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,completed',
            'course_id' => 'required|exists:courses,id'
        ]);

        $reminder = Reminder::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'status' => $validated['status'],
            'course_id' => $validated['course_id']
        ]);

        return redirect()->route('reminders.index')
            ->with('success', 'Recordatorio creado exitosamente.');
    }

    public function show(Reminder $reminder)
    {
        $this->authorize('view', $reminder);
        return view('reminders.show', compact('reminder'));
    }

    public function edit(Reminder $reminder)
    {
        $this->authorize('update', $reminder);
        $courses = Course::where('user_id', auth()->id())->get();
        return view('reminders.edit', compact('reminder', 'courses'));
    }

    public function update(Request $request, Reminder $reminder)
    {
        $this->authorize('update', $reminder);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'status' => 'required|in:pending,completed',
            'course_id' => 'required|exists:courses,id'
        ]);

        $reminder->update($validated);

        return redirect()->route('reminders.index')
            ->with('success', 'Recordatorio actualizado exitosamente.');
    }

    public function destroy(Reminder $reminder)
    {
        $this->authorize('delete', $reminder);
        $reminder->delete();

        return redirect()->route('reminders.index')
            ->with('success', 'Recordatorio eliminado exitosamente.');
    }

    public function toggleStatus(Reminder $reminder)
    {
        $this->authorize('update', $reminder);

        $reminder->status = $reminder->status === 'completed' ? 'pending' : 'completed';
        $reminder->save();

        return response()->json([
            'success' => true,
            'status' => $reminder->status
        ]);
    }
} 