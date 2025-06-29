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
                    <h2 class="text-xl font-semibold text-gray-800">Nuevo Proyecto</h2>
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
            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-lg shadow p-6 border border-gray-200 overflow-hidden">
                    <!-- Wizard Steps -->
                    <div class="mb-8">
                        <ol class="flex items-center w-full">
                            <li class="step-item flex w-full items-center active" id="step1">
                                <div class="flex items-center">
                                    <div class="step flex items-center justify-center w-8 h-8 rounded-full border-2 border-indigo-600 bg-indigo-600 text-white">
                                        <span class="step-number">1</span>
                                        <i class="fas fa-check step-completed hidden"></i>
                                    </div>
                                    <div class="ml-2 step-title hidden sm:block text-sm font-medium text-indigo-600">Información básica</div>
                                </div>
                                <div class="w-full h-0.5 mx-2 bg-gray-200"></div>
                            </li>
                            <li class="step-item flex w-full items-center" id="step2">
                                <div class="flex items-center">
                                    <div class="step flex items-center justify-center w-8 h-8 rounded-full border-2 border-gray-300 text-gray-500">
                                        <span class="step-number">2</span>
                                        <i class="fas fa-check step-completed hidden"></i>
                                    </div>
                                    <div class="ml-2 step-title hidden sm:block text-sm font-medium text-gray-500">Detalles</div>
                                </div>
                                <div class="w-full h-0.5 mx-2 bg-gray-200"></div>
                            </li>
                            <li class="step-item flex items-center" id="step3">
                                <div class="flex items-center">
                                    <div class="step flex items-center justify-center w-8 h-8 rounded-full border-2 border-gray-300 text-gray-500">
                                        <span class="step-number">3</span>
                                        <i class="fas fa-check step-completed hidden"></i>
                                    </div>
                                    <div class="ml-2 step-title hidden sm:block text-sm font-medium text-gray-500">Revisión</div>
                                </div>
                            </li>
                        </ol>
                    </div>
                    <form id="projectForm" action="{{ route('projects.store') }}" method="POST">
                        @csrf
                        <!-- Step 1: Basic Information -->
                        <div class="step-content" id="step-content-1">
                            <div class="mb-6">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Proyecto <span class="text-red-500">*</span></label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ej. Sistema de gestión escolar">
                                @error('title')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-6">
                                <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">Curso/Materia <span class="text-red-500">*</span></label>
                                <select id="course_id" name="course_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="" disabled selected>Selecciona un curso</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_id')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Prioridad <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <input type="radio" id="priorityLow" name="priority" value="Baja" class="hidden peer" required {{ old('priority') == 'Baja' ? 'checked' : '' }}>
                                        <label for="priorityLow" class="block p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 hover:bg-gray-50">
                                            <div class="flex items-center justify-between">
                                                <h3 class="font-medium text-gray-900">Baja</h3>
                                                <i class="fas fa-check-circle text-green-500 hidden peer-checked:inline"></i>
                                            </div>
                                            <p class="text-sm text-gray-500 mt-1">Sin prisa, puedes tomarte tu tiempo</p>
                                        </label>
                                    </div>
                                    <div>
                                        <input type="radio" id="priorityMedium" name="priority" value="Media" class="hidden peer" {{ old('priority') == 'Media' ? 'checked' : '' }}>
                                        <label for="priorityMedium" class="block p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-yellow-500 peer-checked:bg-yellow-50 hover:bg-gray-50">
                                            <div class="flex items-center justify-between">
                                                <h3 class="font-medium text-gray-900">Media</h3>
                                                <i class="fas fa-check-circle text-yellow-500 hidden peer-checked:inline"></i>
                                            </div>
                                            <p class="text-sm text-gray-500 mt-1">Importante pero no urgente</p>
                                        </label>
                                    </div>
                                    <div>
                                        <input type="radio" id="priorityHigh" name="priority" value="Alta" class="hidden peer" {{ old('priority') == 'Alta' ? 'checked' : '' }}>
                                        <label for="priorityHigh" class="block p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-red-500 peer-checked:bg-red-50 hover:bg-gray-50">
                                            <div class="flex items-center justify-between">
                                                <h3 class="font-medium text-gray-900">Alta</h3>
                                                <i class="fas fa-check-circle text-red-500 hidden peer-checked:inline"></i>
                                            </div>
                                            <p class="text-sm text-gray-500 mt-1">Urgente y muy importante</p>
                                        </label>
                                    </div>
                                </div>
                                @error('priority')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="button" class="next-step-btn px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Siguiente <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Step 2: Details -->
                        <div class="step-content hidden" id="step-content-2">
                            <div class="mb-6">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                <textarea id="description" name="description" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                                @error('description')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-6">
                                <label for="tags" class="block text-sm font-medium text-gray-700 mb-1">Etiquetas</label>
                                <input type="text" id="tags" name="tags" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Ej. Investigación, Presentación" value="{{ old('tags') }}">
                                <span class="text-xs text-gray-400">Separadas por coma</span>
                            </div>
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fechas</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="start_date" class="block text-xs text-gray-500 mb-1">Fecha de inicio</label>
                                        <input type="date" id="start_date" name="start_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('start_date') }}">
                                        @error('start_date')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                    </div>
                                    <div>
                                        <label for="due_date" class="block text-xs text-gray-500 mb-1">Fecha de entrega</label>
                                        <input type="date" id="due_date" name="due_date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('due_date') }}">
                                        @error('due_date')<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <button type="button" class="prev-step-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <i class="fas fa-arrow-left mr-2"></i> Atrás
                                </button>
                                <button type="button" class="next-step-btn px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Siguiente <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                        <!-- Step 3: Review -->
                        <div class="step-content hidden" id="step-content-3">
                            <div class="mb-6">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Revisa la información de tu proyecto</h3>
                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <h4 class="font-medium text-gray-800 mb-2">Información básica</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-500">Nombre del proyecto</p>
                                            <p class="font-medium" id="review-title">-</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Curso/Materia</p>
                                            <p class="font-medium" id="review-course">-</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Prioridad</p>
                                            <p class="font-medium" id="review-priority">-</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <h4 class="font-medium text-gray-800 mb-2">Detalles</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="md:col-span-2">
                                            <p class="text-sm text-gray-500">Descripción</p>
                                            <div class="prose max-w-none" id="review-description">
                                                <p class="text-gray-500 italic">No se proporcionó descripción</p>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Fechas</p>
                                            <p class="font-medium" id="review-dates">-</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">Etiquetas</p>
                                            <div class="flex flex-wrap gap-1" id="review-tags">
                                                <span class="text-gray-500 italic">No hay etiquetas</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <button type="button" class="prev-step-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <i class="fas fa-arrow-left mr-2"></i> Atrás
                                </button>
                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <i class="fas fa-check-circle mr-2"></i> Crear Proyecto
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
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
@endsection 