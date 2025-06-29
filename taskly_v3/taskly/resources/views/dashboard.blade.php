@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="sidebar bg-white w-64 border-r border-gray-200 flex flex-col">
        <div class="p-4 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-indigo-600 flex items-center">
                <i class="fas fa-graduation-cap mr-2"></i> Taskly
            </h1>
            <p class="text-sm text-gray-500">Organiza tu éxito académico</p>
        </div>
        
        <div class="flex-1 overflow-y-auto">
            <nav class="p-4">
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Menú</h3>
                    <ul>
                        <li class="mb-1">
                            <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md bg-indigo-50 text-indigo-700">
                                <i class="fas fa-tachometer-alt mr-3 text-indigo-500"></i> Dashboard
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('tasks.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                <i class="fas fa-tasks mr-3 text-gray-500"></i> Tareas
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('projects.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                <i class="fas fa-project-diagram mr-3 text-gray-500"></i> Proyectos
                            </a>
                        </li>
                        <li class="mb-1">
                            <a href="{{ route('calendar.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                <i class="fas fa-calendar-alt mr-3 text-gray-500"></i> Calendario
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="mb-6">
                    <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Mis Cursos</h3>
                    <ul>
                        @foreach($courses as $course)
                        <li class="mb-1">
                            <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                <span class="w-2 h-2 mr-3 rounded-full bg-green-500"></span> {{ $course->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
        </div>
        
        <div class="p-4 border-t border-gray-200">
            <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50 mb-2">
                <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full mr-3">
                <div>
                    <p class="font-medium text-gray-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500">Estudiante</p>
                </div>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-md text-red-600 hover:bg-red-50 transition-colors">
                    <i class="fas fa-sign-out-alt mr-3"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center">
                    <button id="sidebarToggle" class="mr-4 text-gray-500 md:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <button class="p-1 text-gray-500 hover:text-gray-700">
                            <i class="fas fa-bell"></i>
                            <span class="absolute top-0 right-0 w-2 h-2 rounded-full bg-red-500"></span>
                        </button>
                    </div>
                    <div class="relative">
                        <input type="text" placeholder="Buscar..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Tasks Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total tareas</p>
                            <p class="text-2xl font-bold mt-1">{{ $tasks->count() }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <i class="fas fa-tasks"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Projects Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Proyectos</p>
                            <p class="text-2xl font-bold mt-1">{{ $projects->count() }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Reminders Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Recordatorios</p>
                            <p class="text-2xl font-bold mt-1">{{ $reminders->count() }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-bell"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Courses Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Cursos</p>
                            <p class="text-2xl font-bold mt-1">{{ $courses->count() }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Upcoming Activities -->
            <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Próximas Actividades</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($upcomingActivities as $activity)
                    <div class="p-6 hover:bg-gray-50 transition-all duration-200 ease-in-out">
                        <div class="flex items-start justify-between">
                            <div class="flex items-start">
                                <div class="p-2 rounded-full bg-{{ $activity->type === 'task' ? 'indigo' : ($activity->type === 'project' ? 'green' : 'yellow') }}-100 text-{{ $activity->type === 'task' ? 'indigo' : ($activity->type === 'project' ? 'green' : 'yellow') }}-600 mr-4">
                                    <i class="fas fa-{{ $activity->type === 'task' ? 'tasks' : ($activity->type === 'project' ? 'project-diagram' : 'bell') }}"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $activity->title }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">{{ $activity->course->name }}</p>
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        <span>{{ $activity->due_date->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $activity->type === 'task' ? 'indigo' : ($activity->type === 'project' ? 'green' : 'yellow') }}-100 text-{{ $activity->type === 'task' ? 'indigo' : ($activity->type === 'project' ? 'green' : 'yellow') }}-800">
                                    {{ ucfirst($activity->type) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Project Progress -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Progreso de Proyectos</h3>
                </div>
                <div class="divide-y divide-gray-200">
                    @foreach($projects->where('status', 'active') as $project)
                    <div class="p-6 hover:bg-gray-50 transition-all duration-200 ease-in-out">
                        <div class="flex items-start justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">{{ $project->title }}</h4>
                                <p class="text-sm text-gray-500 mt-1">{{ $project->course->name }}</p>
                                <div class="mt-4">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Progreso</span>
                                        <span class="font-medium text-gray-900">{{ $project->progress }}%</span>
                                    </div>
                                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ $project->progress }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Activo
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    .sidebar {
        transition: all 0.3s ease;
    }
    
    @media (max-width: 768px) {
        .sidebar {
            transform: translateX(-100%);
            position: absolute;
            z-index: 10;
            height: 100vh;
        }
        
        .sidebar-open {
            transform: translateX(0);
        }
    }
    
    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    // Sidebar toggle functionality
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('sidebar-open');
    });
</script>
@endsection
