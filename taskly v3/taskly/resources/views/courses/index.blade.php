@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Encabezado y Botón de Nuevo Curso -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Cursos</h1>
        <a href="{{ route('courses.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Nuevo Curso
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form action="{{ route('courses.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Semestre</label>
                <select name="semester" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    <option value="">Todos los semestres</option>
                    @foreach(range(1, 10) as $semester)
                        <option value="{{ $semester }}" {{ request('semester') == $semester ? 'selected' : '' }}>
                            Semestre {{ $semester }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Créditos</label>
                <select name="credits" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                    <option value="">Todos los créditos</option>
                    @foreach(range(1, 6) as $credits)
                        <option value="{{ $credits }}" {{ request('credits') == $credits ? 'selected' : '' }}>
                            {{ $credits }} créditos
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">
                    <i class="fas fa-filter mr-2"></i>
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <!-- Estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-2xl font-semibold">{{ $courses->count() }}</p>
                </div>
                <span class="text-purple-500">
                    <i class="fas fa-book text-2xl"></i>
                </span>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Créditos Totales</p>
                    <p class="text-2xl font-semibold">{{ $courses->sum('credits') }}</p>
                </div>
                <span class="text-blue-500">
                    <i class="fas fa-graduation-cap text-2xl"></i>
                </span>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Tareas Pendientes</p>
                    <p class="text-2xl font-semibold">{{ $courses->sum(function($course) { return $course->tasks->where('status', 'pending')->count(); }) }}</p>
                </div>
                <span class="text-yellow-500">
                    <i class="fas fa-tasks text-2xl"></i>
                </span>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-md p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500">Proyectos Activos</p>
                    <p class="text-2xl font-semibold">{{ $courses->sum(function($course) { return $course->projects->where('status', 'active')->count(); }) }}</p>
                </div>
                <span class="text-green-500">
                    <i class="fas fa-project-diagram text-2xl"></i>
                </span>
            </div>
        </div>
    </div>

    <!-- Lista de Cursos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($courses as $course)
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $course->name }}</h3>
                    <span class="px-2 py-1 text-xs font-semibold rounded-full" style="background-color: {{ $course->color }}20; color: {{ $course->color }}">
                        {{ $course->code }}
                    </span>
                </div>
                
                <div class="space-y-2 mb-4">
                    <p class="text-sm text-gray-600">{{ $course->description }}</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-user mr-2"></i>
                        {{ $course->professor }}
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-clock mr-2"></i>
                        {{ $course->schedule }}
                    </div>
                    <div class="flex items-center text-sm text-gray-500">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        {{ $course->credits }} créditos
                    </div>
                </div>

                <div class="border-t border-gray-200 pt-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-gray-700">Progreso</span>
                        <span class="text-sm text-gray-500">
                            {{ $course->tasks->where('status', 'completed')->count() }} / {{ $course->tasks->count() }} tareas
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $course->tasks->count() > 0 ? ($course->tasks->where('status', 'completed')->count() / $course->tasks->count() * 100) : 0 }}%"></div>
                    </div>
                </div>

                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('courses.edit', $course) }}" class="text-blue-600 hover:text-blue-900">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('courses.destroy', $course) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de eliminar este curso?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                No hay cursos disponibles
            </div>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    <div class="mt-6">
        {{ $courses->links() }}
    </div>
</div>
@endsection 