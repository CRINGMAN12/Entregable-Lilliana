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
                    <h2 class="text-xl font-semibold text-gray-800">Nueva Tarea</h2>
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
            <div class="max-w-3xl mx-auto">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">Detalles de la Tarea</h2>
                    </div>
                    
                    <div class="p-6">
                        <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data" id="taskForm">
                            @csrf
                            <input type="hidden" name="status" value="pending">
                            
                            <!-- Título de la tarea -->
                            <div class="mb-6">
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título de la tarea *</label>
                                <input type="text" id="title" name="title" required 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                                       placeholder="Ej: Resolver problemas de álgebra">
                            </div>
                            
                            <!-- Descripción -->
                            <div class="mb-6">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                <textarea id="description" name="description" rows="4" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                                          placeholder="Proporciona detalles sobre la tarea..."></textarea>
                            </div>
                            
                            <!-- Materia y Prioridad en fila -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Materia -->
                                <div>
                                    <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">Materia *</label>
                                    @if(count($courses) === 0)
                                        <div class="mb-2 p-2 bg-yellow-100 text-yellow-800 rounded">
                                            No tienes materias registradas. <a href="{{ route('courses.create') }}" class="text-blue-600 underline">Crea una aquí</a>.
                                        </div>
                                    @endif
                                    <select id="course_id" name="course_id" required 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                            @if(count($courses) === 0) disabled @endif>
                                        <option value="">Seleccionar materia</option>
                                        @foreach($courses as $course)
                                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <!-- Prioridad -->
                                <div>
                                    <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Prioridad *</label>
                                    <select id="priority" name="priority" required 
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Seleccionar prioridad</option>
                                        <option value="high">Alta</option>
                                        <option value="medium">Media</option>
                                        <option value="low">Baja</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Fechas -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <!-- Fecha de inicio -->
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de inicio *</label>
                                    <input type="datetime-local" id="start_date" name="start_date" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                
                                <!-- Fecha de vencimiento -->
                                <div>
                                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de vencimiento *</label>
                                    <input type="datetime-local" id="due_date" name="due_date" required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                            </div>
                            
                            <!-- Tipo de tarea -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de tarea</label>
                                <div class="flex flex-wrap gap-2">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="type" value="homework" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300" checked>
                                        <span class="ml-2 text-sm text-gray-700">Tarea</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="type" value="exam" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Examen</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="type" value="project" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Proyecto</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="type" value="reading" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Lectura</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name="type" value="other" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300">
                                        <span class="ml-2 text-sm text-gray-700">Otro</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Subir archivos -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="files">Archivos adjuntos</label>
                                <div class="mt-1 flex items-center">
                                    <label for="files" class="cursor-pointer">
                                        <span class="px-4 py-2 bg-white border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            <i class="fas fa-paperclip mr-2"></i>Seleccionar archivos
                                        </span>
                                        <input id="files" name="files[]" type="file" class="sr-only" multiple>
                                    </label>
                                    <span class="ml-3 text-sm text-gray-500">Formatos: pdf, doc, jpg, png</span>
                                </div>
                                <div id="filePreview" class="mt-2 grid grid-cols-1 gap-2"></div>
                            </div>
                            
                            <!-- Recordatorios -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Recordatorios</label>
                                <div class="space-y-2">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="reminders[]" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">1 día antes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="reminders[]" value="3" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">3 días antes</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="reminders[]" value="7" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <span class="ml-2 text-sm text-gray-700">1 semana antes</span>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Notas adicionales -->
                            <div class="mb-6">
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notas adicionales</label>
                                <textarea id="notes" name="notes" rows="3" 
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                                          placeholder="Puedes agregar notas adicionales aquí..."></textarea>
                            </div>
                            
                            <!-- Botones de acción -->
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('tasks.index') }}" 
                                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancelar
                                </a>
                                <button type="submit" 
                                        class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Guardar Tarea
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <!-- Previsualización de la tarea -->
                <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">Previsualización</h2>
                    </div>
                    <div class="p-6">
                        <div class="task-preview bg-gray-50 rounded-lg p-4">
                            <h3 id="previewTitle" class="text-md font-medium text-gray-900 mb-1">Nombre de la tarea</h3>
                            <p id="previewSubject" class="text-sm text-gray-500 mb-2">Materia: ---</p>
                            <p id="previewDescription" class="text-sm text-gray-600 mb-3">Descripción aparecerá aquí...</p>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="far fa-calendar-alt mr-1"></i>
                                <span id="previewDueDate">Vence: --/--/----</span>
                            </div>
                            <div class="mt-2">
                                <span id="previewPriority" class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Prioridad</span>
                                <span id="previewType" class="ml-2 px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Tipo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<style>
    .task-priority-high {
        border-left: 4px solid #ef4444;
    }

    .task-priority-medium {
        border-left: 4px solid #f59e0b;
    }

    .task-priority-low {
        border-left: 4px solid #10b981;
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

    /* Estilos para el modal */
    .modal-overlay {
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 40;
    }

    .modal-container {
        transform: translateY(0);
        opacity: 1;
        transition: all 0.3s ease;
    }

    .modal-container.hidden {
        opacity: 0;
        transform: translateY(-20px);
    }

    /* Smooth transitions */
    .transition-smooth {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<script>
    // Sidebar toggle functionality
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.classList.toggle('sidebar-open');
    });

    // Update task preview in real-time
    document.getElementById('title').addEventListener('input', function() {
        document.getElementById('previewTitle').textContent = this.value || 'Nombre de la tarea';
    });

    document.getElementById('description').addEventListener('input', function() {
        document.getElementById('previewDescription').textContent = this.value || 'Descripción aparecerá aquí...';
    });

    document.getElementById('course_id').addEventListener('change', function() {
        const subject = this.options[this.selectedIndex].text;
        document.getElementById('previewSubject').textContent = 'Materia: ' + (subject || '---');
    });

    document.getElementById('priority').addEventListener('change', function() {
        const priority = this.options[this.selectedIndex].text;
        const preview = document.getElementById('previewPriority');
        preview.textContent = priority || 'Prioridad';
        
        // Change color based on priority
        preview.className = 'px-2 py-1 text-xs rounded-full';
        if (this.value === 'high') {
            preview.classList.add('bg-red-100', 'text-red-800');
        } else if (this.value === 'medium') {
            preview.classList.add('bg-yellow-100', 'text-yellow-800');
        } else if (this.value === 'low') {
            preview.classList.add('bg-green-100', 'text-green-800');
        } else {
            preview.classList.add('bg-gray-100', 'text-gray-800');
        }
    });

    document.getElementById('due_date').addEventListener('change', function() {
        if (this.value) {
            const date = new Date(this.value);
            const formattedDate = date.toLocaleDateString('es-ES', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
            document.getElementById('previewDueDate').textContent = 'Vence: ' + formattedDate;
        } else {
            document.getElementById('previewDueDate').textContent = 'Vence: --/--/----';
        }
    });

    // Update task type preview
    document.querySelectorAll('input[name="type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const type = this.nextElementSibling.textContent;
            const preview = document.getElementById('previewType');
            preview.textContent = type;
            
            // Change color based on type
            preview.className = 'ml-2 px-2 py-1 text-xs rounded-full';
            if (this.value === 'exam') {
                preview.classList.add('bg-red-100', 'text-red-800');
            } else if (this.value === 'project') {
                preview.classList.add('bg-green-100', 'text-green-800');
            } else if (this.value === 'reading') {
                preview.classList.add('bg-blue-100', 'text-blue-800');
            } else {
                preview.classList.add('bg-gray-100', 'text-gray-800');
            }
        });
    });

    // File upload preview
    document.getElementById('files').addEventListener('change', function() {
        const preview = document.getElementById('filePreview');
        preview.innerHTML = '';
        
        if (this.files.length > 0) {
            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const fileElement = document.createElement('div');
                fileElement.className = 'flex items-center p-2 bg-gray-50 rounded';
                
                let icon;
                if (file.type.includes('image')) {
                    icon = '<i class="fas fa-image mr-2 text-blue-500"></i>';
                } else if (file.type.includes('pdf')) {
                    icon = '<i class="fas fa-file-pdf mr-2 text-red-500"></i>';
                } else if (file.type.includes('word') || file.type.includes('document')) {
                    icon = '<i class="fas fa-file-word mr-2 text-blue-600"></i>';
                } else {
                    icon = '<i class="fas fa-file-alt mr-2 text-gray-500"></i>';
                }
                
                fileElement.innerHTML = `
                    ${icon}
                    <span class="text-sm text-gray-700 truncate flex-1">${file.name}</span>
                    <button type="button" class="text-red-500 hover:text-red-700" data-index="${i}">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                
                preview.appendChild(fileElement);
            }
        }
    });

    // Remove file from preview
    document.getElementById('filePreview').addEventListener('click', function(e) {
        if (e.target.closest('button') || e.target.nodeName === 'I' && e.target.parentNode.nodeName === 'BUTTON') {
            const button = e.target.closest('button') || e.target.parentNode;
            const index = button.getAttribute('data-index');
            
            // Create a new DataTransfer to update the file input
            const dt = new DataTransfer();
            const input = document.getElementById('files');
            
            for (let i = 0; i < input.files.length; i++) {
                if (i != index) {
                    dt.items.add(input.files[i]);
                }
            }
            
            input.files = dt.files;
            
            // Trigger a new change event to update the preview
            const event = new Event('change');
            input.dispatchEvent(event);
        }
    });
</script>
@endsection 