@extends('layouts.app')

@section('content')
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    @include('partials.sidebar')
    
    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center">
                    <button id="sidebarToggle" class="mr-4 text-gray-500 md:hidden">
                        <i class="fas fa-bars"></i>
                    </button>
                    <h2 class="text-xl font-semibold text-gray-800">Proyectos</h2>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Buscar proyectos..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                </div>
            </div>
        </header>
        
        <!-- Content -->
        <main class="flex-1 overflow-y-auto p-6">
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Proyectos activos</p>
                            <p class="text-2xl font-bold mt-1">{{ $activeProjects }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Proyectos completados</p>
                            <p class="text-2xl font-bold mt-1">{{ $completedProjects }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Proyectos atrasados</p>
                            <p class="text-2xl font-bold mt-1">{{ $overdueProjects }}</p>
                        </div>
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Promedio de progreso</p>
                            <p class="text-2xl font-bold mt-1">{{ $averageProgress }}%</p>
                        </div>
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Bar -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex space-x-3">
                    <button id="gridViewBtn" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                        <i class="fas fa-th-large mr-2"></i> Vista en cuadrícula
                    </button>
                    <button id="listViewBtn" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                        <i class="fas fa-list mr-2"></i> Vista en lista
                    </button>
                    <button id="kanbanViewBtn" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                        <i class="fas fa-columns mr-2"></i> Vista Kanban
                    </button>
                </div>
                
                <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-plus mr-2"></i> Nuevo Proyecto
                </a>
            </div>
            
            <!-- Filters -->
            <div class="bg-white rounded-lg shadow p-4 mb-6">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="relative w-full md:w-auto">
                        <select class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">
                            <option>Todas las materias</option>
                            @foreach($courses as $course)
                            <option>{{ $course->name }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs"></i>
                    </div>
                    
                    <div class="relative w-full md:w-auto">
                        <select class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">
                            <option>Todos los estados</option>
                            <option>Pendiente</option>
                            <option>En progreso</option>
                            <option>Completado</option>
                            <option>Atrasado</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs"></i>
                    </div>
                    
                    <div class="relative w-full md:w-auto">
                        <select class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 w-full">
                            <option>Todas las prioridades</option>
                            <option>Alta</option>
                            <option>Media</option>
                            <option>Baja</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs"></i>
                    </div>
                    
                    <button class="flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">
                        <i class="fas fa-filter mr-2"></i> Filtrar
                    </button>
                    
                    <button class="flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                        <i class="fas fa-sync-alt mr-2"></i> Reiniciar
                    </button>
                </div>
            </div>
            
            <!-- Projects Grid View -->
            <div id="gridView" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                <div class="project-card bg-white rounded-lg shadow overflow-hidden transition-all duration-300 ease-in-out">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $project->title }}</h3>
                                <p class="text-sm text-gray-500 mt-1">{{ $project->course->name }}</p>
                            </div>
                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $project->status_color }}-100 text-{{ $project->status_color }}-800">{{ $project->status }}</span>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-sm text-gray-600 mb-4">{{ $project->description }}</p>
                            
                            <div class="flex justify-between text-sm text-gray-500 mb-1">
                                <span>Progreso</span>
                                <span>{{ $project->progress }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: {{ $project->progress }}%"></div>
                            </div>
                        </div>
                        
                        <div class="mt-4 flex items-center text-sm text-gray-500">
                            <i class="far fa-calendar-alt mr-1"></i>
                            <span>Vence: {{ $project->due_date->format('d/m/Y') }}</span>
                        </div>
                        
                        <div class="mt-4">
                            <div class="flex items-center space-x-2">
                                @foreach($project->tags as $tag)
                                <span class="px-2 py-1 text-xs rounded-full bg-{{ $tag->color }}-100 text-{{ $tag->color }}-800">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-6 py-3 flex justify-between items-center">
                        <div class="flex items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($project->user->name) }}" alt="Team member" class="w-6 h-6 rounded-full border-2 border-white">
                        </div>
                        
                        <div class="flex space-x-2">
                            <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800">
                                <i class="far fa-eye"></i>
                            </a>
                            <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 hover:text-indigo-800">
                                <i class="far fa-edit"></i>
                            </a>
                            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Projects List View (Hidden by default) -->
            <div id="listView" class="hidden">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="grid grid-cols-12 gap-4 font-medium text-gray-500">
                            <div class="col-span-5">Nombre del proyecto</div>
                            <div class="col-span-2">Materia</div>
                            <div class="col-span-2">Estado</div>
                            <div class="col-span-2">Progreso</div>
                            <div class="col-span-1">Acciones</div>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        @foreach($projects as $project)
                        <div class="p-4 hover:bg-gray-50 transition-colors duration-200">
                            <div class="grid grid-cols-12 gap-4 items-center">
                                <div class="col-span-5">
                                    <div class="font-medium text-gray-800">{{ $project->title }}</div>
                                    <div class="text-sm text-gray-500 mt-1">{{ Str::limit($project->description, 50) }}</div>
                                </div>
                                <div class="col-span-2 text-sm text-gray-700">{{ $project->course->name }}</div>
                                <div class="col-span-2">
                                    <span class="px-2 py-1 text-xs rounded-full bg-{{ $project->status_color }}-100 text-{{ $project->status_color }}-800">{{ $project->status }}</span>
                                </div>
                                <div class="col-span-2">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                            <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $project->progress }}%"></div>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $project->progress }}%</span>
                                    </div>
                                </div>
                                <div class="col-span-1 flex justify-end space-x-2">
                                    <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 hover:text-indigo-800">
                                        <i class="far fa-edit"></i>
                                    </a>
                                    <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <!-- Kanban View (Hidden by default) -->
            <div id="kanbanView" class="hidden">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Pendiente Column -->
                    <div class="kanban-column bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-medium text-gray-900">Pendiente</h3>
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-gray-800">{{ $projects->where('status', 'Pendiente')->count() }}</span>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($projects->where('status', 'Pendiente') as $project)
                            <div class="draggable-project bg-white rounded-lg shadow p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $project->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ $project->course->name }}</p>
                                    </div>
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-{{ $project->priority_color }}-100 text-{{ $project->priority_color }}-800">{{ $project->priority }}</span>
                                </div>
                                
                                <div class="mt-3">
                                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                                        <span>Progreso</span>
                                        <span>{{ $project->progress }}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $project->progress }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="mt-3 flex justify-between items-center">
                                    <div class="text-xs text-gray-500">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        <span>{{ $project->due_date->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 hover:text-indigo-800">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- En progreso Column -->
                    <div class="kanban-column bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-medium text-gray-900">En progreso</h3>
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-gray-800">{{ $projects->where('status', 'En progreso')->count() }}</span>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($projects->where('status', 'En progreso') as $project)
                            <div class="draggable-project bg-white rounded-lg shadow p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $project->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ $project->course->name }}</p>
                                    </div>
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-{{ $project->priority_color }}-100 text-{{ $project->priority_color }}-800">{{ $project->priority }}</span>
                                </div>
                                
                                <div class="mt-3">
                                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                                        <span>Progreso</span>
                                        <span>{{ $project->progress }}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $project->progress }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="mt-3 flex justify-between items-center">
                                    <div class="text-xs text-gray-500">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        <span>{{ $project->due_date->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 hover:text-indigo-800">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Completado Column -->
                    <div class="kanban-column bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-medium text-gray-900">Completado</h3>
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-200 text-gray-800">{{ $projects->where('status', 'Completado')->count() }}</span>
                        </div>
                        
                        <div class="space-y-4">
                            @foreach($projects->where('status', 'Completado') as $project)
                            <div class="draggable-project bg-white rounded-lg shadow p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $project->title }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">{{ $project->course->name }}</p>
                                    </div>
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-{{ $project->priority_color }}-100 text-{{ $project->priority_color }}-800">{{ $project->priority }}</span>
                                </div>
                                
                                <div class="mt-3">
                                    <div class="flex justify-between text-xs text-gray-500 mb-1">
                                        <span>Progreso</span>
                                        <span>{{ $project->progress }}%</span>
                                    </div>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: {{ $project->progress }}%"></div>
                                    </div>
                                </div>
                                
                                <div class="mt-3 flex justify-between items-center">
                                    <div class="text-xs text-gray-500">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        <span>{{ $project->due_date->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-800">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{ route('projects.edit', $project) }}" class="text-indigo-600 hover:text-indigo-800">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    .progress-bar {
        height: 8px;
        border-radius: 4px;
        background-color: #e5e7eb;
    }
    
    .progress-fill {
        height: 100%;
        border-radius: 4px;
        background-color: #4f46e5;
        transition: width 0.3s ease;
    }
    
    .kanban-column {
        min-height: 500px;
    }
    
    .draggable-project {
        cursor: grab;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .draggable-project:active {
        cursor: grabbing;
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
    
    // View toggle buttons
    const gridViewBtn = document.getElementById('gridViewBtn');
    const listViewBtn = document.getElementById('listViewBtn');
    const kanbanViewBtn = document.getElementById('kanbanViewBtn');
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const kanbanView = document.getElementById('kanbanView');
    
    gridViewBtn.addEventListener('click', function() {
        gridView.classList.remove('hidden');
        listView.classList.add('hidden');
        kanbanView.classList.add('hidden');
        gridViewBtn.classList.remove('bg-white', 'border-gray-300', 'text-gray-700');
        gridViewBtn.classList.add('bg-indigo-600', 'text-white');
        listViewBtn.classList.remove('bg-indigo-600', 'text-white');
        listViewBtn.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
        kanbanViewBtn.classList.remove('bg-indigo-600', 'text-white');
        kanbanViewBtn.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
    });
    
    listViewBtn.addEventListener('click', function() {
        gridView.classList.add('hidden');
        listView.classList.remove('hidden');
        kanbanView.classList.add('hidden');
        gridViewBtn.classList.remove('bg-indigo-600', 'text-white');
        gridViewBtn.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
        listViewBtn.classList.remove('bg-white', 'border-gray-300', 'text-gray-700');
        listViewBtn.classList.add('bg-indigo-600', 'text-white');
        kanbanViewBtn.classList.remove('bg-indigo-600', 'text-white');
        kanbanViewBtn.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
    });
    
    kanbanViewBtn.addEventListener('click', function() {
        gridView.classList.add('hidden');
        listView.classList.add('hidden');
        kanbanView.classList.remove('hidden');
        gridViewBtn.classList.remove('bg-indigo-600', 'text-white');
        gridViewBtn.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
        listViewBtn.classList.remove('bg-indigo-600', 'text-white');
        listViewBtn.classList.add('bg-white', 'border-gray-300', 'text-gray-700');
        kanbanViewBtn.classList.remove('bg-white', 'border-gray-300', 'text-gray-700');
        kanbanViewBtn.classList.add('bg-indigo-600', 'text-white');
    });
    
    // Simple drag and drop for kanban (basic functionality)
    const draggableProjects = document.querySelectorAll('.draggable-project');
    const kanbanColumns = document.querySelectorAll('.kanban-column');
    
    draggableProjects.forEach(project => {
        project.addEventListener('dragstart', () => {
            project.classList.add('opacity-50');
        });
        
        project.addEventListener('dragend', () => {
            project.classList.remove('opacity-50');
        });
    });
    
    kanbanColumns.forEach(column => {
        column.addEventListener('dragover', e => {
            e.preventDefault();
            const afterElement = getDragAfterElement(column, e.clientY);
            const draggable = document.querySelector('.draggable-project.opacity-50');
            
            if (afterElement == null) {
                column.appendChild(draggable);
            } else {
                column.insertBefore(draggable, afterElement);
            }
        });
    });
    
    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.draggable-project:not(.opacity-50)')];
        
        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;
            
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child };
            } else {
                return closest;
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element;
    }
</script>
@endsection 