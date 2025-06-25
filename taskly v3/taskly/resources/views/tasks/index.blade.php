<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Taskly - Panel de Tareas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }
        
        .task-priority-high {
            border-left: 4px solid var(--danger);
        }
        
        .task-priority-medium {
            border-left: 4px solid var(--warning);
        }
        
        .task-priority-low {
            border-left: 4px solid var(--secondary);
        }
        
        .progress-bar {
            height: 8px;
            border-radius: 4px;
            background-color: #e5e7eb;
        }
        
        .progress-fill {
            height: 100%;
            border-radius: 4px;
            background-color: var(--primary);
            transition: width 0.3s ease;
        }
        
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
        
        .task-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
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
                                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                    <i class="fas fa-tachometer-alt mr-3 text-indigo-500"></i> Dashboard
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="{{ route('tasks.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md bg-indigo-50 text-indigo-700">
                                    <i class="fas fa-tasks mr-3 text-indigo-500"></i> Tareas
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
                <div class="flex items-center">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="User" class="w-8 h-8 rounded-full mr-2">
            <div>
                        <p class="text-sm font-medium">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">Estudiante</p>
    </div>
                </div>
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
                        <h2 class="text-xl font-semibold text-gray-800">Panel de Tareas</h2>
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
                <!-- Task Stats and Filters -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Total tareas</p>
                                <p class="text-2xl font-bold mt-1">{{ $tasks->total() }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                                <i class="fas fa-tasks"></i>
                            </div>
            </div>
        </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                                <p class="text-sm font-medium text-gray-500">Pendientes</p>
                                <p class="text-2xl font-bold mt-1">{{ $tasks->where('status', 'pending')->count() }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                                <p class="text-sm font-medium text-gray-500">Completadas</p>
                                <p class="text-2xl font-bold mt-1">{{ $tasks->where('status', 'completed')->count() }}</p>
                </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                                <div>
                                <p class="text-sm font-medium text-gray-500">Vencidas</p>
                                <p class="text-2xl font-bold mt-1">{{ $tasks->where('status', 'overdue')->count() }}</p>
                            </div>
                            <div class="p-3 rounded-full bg-red-100 text-red-600">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tasks Section -->
                <div class="grid grid-cols-1 gap-6">
                    <div>
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">Mis Tareas</h3>
                                <a href="{{ route('tasks.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-plus mr-1"></i> Nueva Tarea
                                </a>
                            </div>
                            
                            <!-- Task Filters -->
                            <div class="px-6 py-3 border-b border-gray-200 bg-gray-50">
                                <form action="{{ route('tasks.index') }}" method="GET" class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                                    <div class="flex items-center space-x-4">
                                        <div class="relative">
                                            <select name="course" class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="">Todas las materias</option>
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}" {{ request('course') == $course->id ? 'selected' : '' }}>
                                                        {{ $course->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs"></i>
                                        </div>
                                        
                                        <div class="relative">
                                            <select name="priority" class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="">Todas las prioridades</option>
                                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>Alta</option>
                                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Media</option>
                                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Baja</option>
                                            </select>
                                            <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs"></i>
                                        </div>
                                        
                                        <div class="relative">
                                            <select name="status" class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="">Todos los estados</option>
                                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completada</option>
                                                <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Vencida</option>
                                            </select>
                                            <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center space-x-2">
                                        <button type="submit" class="px-3 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <i class="fas fa-filter mr-1"></i> Aplicar Filtros
                                    </button>
                                        <a href="{{ route('tasks.index') }}" class="px-3 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                            <i class="fas fa-sync-alt mr-1"></i> Resetear
                                        </a>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Task List -->
                            <div class="divide-y divide-gray-200">
                                @foreach($tasks as $task)
                                <div class="task-item p-6 hover:bg-gray-50 transition-all duration-200 ease-in-out task-priority-{{ $task->priority }}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5 mt-1">
                                                <form action="{{ route('tasks.toggle-status', $task) }}" method="PATCH" class="toggle-status-form">
                                                    @csrf
                                                    <input type="checkbox" 
                                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded task-status-checkbox" 
                                                           {{ $task->status === 'completed' ? 'checked' : '' }}
                                                           data-task-id="{{ $task->id }}">
                                            </div>
                                            <div class="ml-3">
                                                <div class="flex items-center">
                                                    <p class="text-sm font-medium text-gray-900 {{ $task->status === 'completed' ? 'line-through' : '' }}">
                                                        {{ $task->title }}
                                                    </p>
                                                    <span class="ml-2 px-2 py-1 text-xs rounded-full bg-{{ $task->priority === 'high' ? 'red' : ($task->priority === 'medium' ? 'yellow' : 'green') }}-100 text-{{ $task->priority === 'high' ? 'red' : ($task->priority === 'medium' ? 'yellow' : 'green') }}-800">
                                                        {{ ucfirst($task->priority) }}
                                                    </span>
                                                </div>
                                                <p class="text-sm text-gray-500 mt-1">{{ $task->description }}</p>
                                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    <span class="{{ $task->status === 'completed' ? 'line-through' : '' }}">
                                                        Vence: {{ $task->due_date->format('d/m/Y') }}
                                                    </span>
                                                    @if($task->status === 'completed')
                                                        <span class="ml-2 text-green-600">Completada</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('tasks.edit', $task) }}" class="text-gray-400 hover:text-indigo-600">
                                                <i class="far fa-edit"></i>
                                            </a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-600">
                                                    <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            
                            <!-- Pagination -->
                            <div class="px-6 py-4 border-t border-gray-200">
                                {{ $tasks->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('sidebar-open');
        });

        // Toggle task status
        document.querySelectorAll('.task-status-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const form = this.closest('form');
                const taskItem = this.closest('.task-item');
                const title = taskItem.querySelector('p.text-sm.font-medium');
                const dueDate = taskItem.querySelector('.mt-2 span:not(.ml-2)');
                const statusText = taskItem.querySelector('.mt-2 .ml-2');

                // Mostrar un indicador de carga
                this.disabled = true;

                fetch(form.action, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la respuesta del servidor');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        if (data.status === 'completed') {
                            title.classList.add('line-through');
                            dueDate.classList.add('line-through');
                            if (!statusText) {
                                const statusSpan = document.createElement('span');
                                statusSpan.className = 'ml-2 text-green-600';
                                statusSpan.textContent = 'Completada';
                                dueDate.parentNode.appendChild(statusSpan);
                            }
                        } else {
                            title.classList.remove('line-through');
                            dueDate.classList.remove('line-through');
                            if (statusText) {
                                statusText.remove();
                            }
                        }
                    } else {
                        throw new Error(data.message || 'Error al actualizar el estado');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    this.checked = !this.checked; // Revertir el checkbox si hay error
                    alert('Hubo un error al actualizar el estado de la tarea: ' + error.message);
                })
                .finally(() => {
                    this.disabled = false; // Habilitar el checkbox nuevamente
                });
            });
        });
    </script>
</body>
</html> 