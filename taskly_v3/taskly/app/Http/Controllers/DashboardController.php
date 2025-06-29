<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use App\Models\Reminder;
use App\Models\Course;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        Log::info('User ID: ' . $userId);
        
        $tasks = Task::where('user_id', $userId)->get();
        Log::info('Tasks count: ' . $tasks->count());
        
        $projects = Project::where('user_id', $userId)->get();
        Log::info('Projects count: ' . $projects->count());
        
        $reminders = Reminder::where('user_id', $userId)->get();
        Log::info('Reminders count: ' . $reminders->count());
        
        $courses = Course::where('user_id', $userId)->get();
        Log::info('Courses count: ' . $courses->count());
        
        // Obtener actividades próximas (tareas, proyectos y recordatorios)
        $upcomingActivities = collect()
            ->merge($tasks->where('status', 'pending'))
            ->merge($projects->where('status', 'active'))
            ->merge($reminders->where('status', 'pending'))
            ->sortBy('due_date')
            ->take(5);

        return view('dashboard', compact(
            'tasks',
            'projects',
            'reminders',
            'courses',
            'upcomingActivities'
        ));
    }
} 