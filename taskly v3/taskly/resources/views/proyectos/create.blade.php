<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly - Crear Proyecto</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
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
        
        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Estilos para el editor de descripción */
        .editor-toolbar {
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem 0.375rem 0 0;
            background-color: #f9fafb;
            padding: 0.5rem;
        }
        
        .editor-content {
            border: 1px solid #e5e7eb;
            border-top: none;
            border-radius: 0 0 0.375rem 0.375rem;
            min-height: 150px;
            padding: 1rem;
        }
        
        .editor-content:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 1px var(--primary);
        }
        
        /* Estilos para los checkboxes personalizados */
        .custom-checkbox input:checked ~ .checkmark {
            @apply bg-indigo-600 border-indigo-600;
        }
        
        .custom-checkbox input:checked ~ .checkmark:after {
            display: block;
        }
        
        .custom-checkbox .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            left: 5px;
            top: 0px;
            width: 4px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
        
        /* Efectos de hover para los pasos del wizard */
        .step-item:hover:not(.active):not(.completed) .step {
            @apply bg-indigo-100 border-indigo-200;
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
                                    <i class="fas fa-tachometer-alt mr-3 text-gray-500"></i> Dashboard
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="{{ route('tasks.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                    <i class="fas fa-tasks mr-3 text-gray-500"></i> Tareas
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="{{ route('projects.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md bg-indigo-50 text-indigo-700">
                                    <i class="fas fa-project-diagram mr-3 text-indigo-500"></i> Proyectos
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="{{ route('calendar') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
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
                                    <span class="w-2 h-2 mr-3 rounded-full bg-{{ $course->color }}-500"></span> {{ $course->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Etiquetas</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                            <span class="px-2 py-1 text-xs rounded-full bg-{{ $tag->color }}-100 text-{{ $tag->color }}-800">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </nav>
            </div>
            
            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full mr-2">
                    <div>
                        <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->role }}</p>
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
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('projects.index') }}" class="text-indigo-600 hover:text-indigo-800">
                                <i class="fas fa-project-diagram"></i>
                            </a>
                            <span class="text-gray-400">/</span>
                            <h2 class="text-xl font-semibold text-gray-800">Nuevo Proyecto</h2>
                        </div>
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

                    <!-- Form -->
                    <form action="{{ route('projects.store') }}" method="POST" id="projectForm">
                        @csrf
                        
                        <!-- Step 1: Basic Information -->
                        <div class="step-content" id="step1Content">
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900">Información Básica</h3>
                                </div>
                                
                                <div class="p-6">
                                    <!-- Título del proyecto -->
                                    <div class="mb-6">
                                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título del proyecto *</label>
                                        <input type="text" id="title" name="title" required 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror" 
                                               placeholder="Ej: Sistema de Gestión de Tareas"
                                               value="{{ old('title') }}">
                                        @error('title')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Descripción -->
                                    <div class="mb-6">
                                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                                        <div class="editor-toolbar">
                                            <button type="button" class="p-1 text-gray-500 hover:text-gray-700">
                                                <i class="fas fa-bold"></i>
                                            </button>
                                            <button type="button" class="p-1 text-gray-500 hover:text-gray-700">
                                                <i class="fas fa-italic"></i>
                                            </button>
                                            <button type="button" class="p-1 text-gray-500 hover:text-gray-700">
                                                <i class="fas fa-list-ul"></i>
                                            </button>
                                        </div>
                                        <textarea id="description" name="description" rows="4" 
                                                  class="editor-content w-full focus:outline-none @error('description') border-red-500 @enderror" 
                                                  placeholder="Describe el propósito y objetivos del proyecto...">{{ old('description') }}</textarea>
                                        @error('description')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Materia -->
                                    <div class="mb-6">
                                        <label for="course_id" class="block text-sm font-medium text-gray-700 mb-1">Materia *</label>
                                        <select id="course_id" name="course_id" required 
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('course_id') border-red-500 @enderror">
                                            <option value="">Seleccionar materia</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                                    {{ $course->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('course_id')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex justify-end">
                                <button type="button" onclick="nextStep(1)" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Siguiente <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Step 2: Details -->
                        <div class="step-content hidden" id="step2Content">
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900">Detalles del Proyecto</h3>
                                </div>
                                
                                <div class="p-6">
                                    <!-- Fechas -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                        <!-- Fecha de inicio -->
                                        <div>
                                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de inicio *</label>
                                            <input type="datetime-local" id="start_date" name="start_date" required 
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('start_date') border-red-500 @enderror"
                                                   value="{{ old('start_date') }}">
                                            @error('start_date')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        
                                        <!-- Fecha de entrega -->
                                        <div>
                                            <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Fecha de entrega *</label>
                                            <input type="datetime-local" id="due_date" name="due_date" required 
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('due_date') border-red-500 @enderror"
                                                   value="{{ old('due_date') }}">
                                            @error('due_date')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <!-- Prioridad -->
                                    <div class="mb-6">
                                        <label for="priority" class="block text-sm font-medium text-gray-700 mb-1">Prioridad *</label>
                                        <select id="priority" name="priority" required 
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 @error('priority') border-red-500 @enderror">
                                            <option value="">Seleccionar prioridad</option>
                                            <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Alta</option>
                                            <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Media</option>
                                            <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Baja</option>
                                        </select>
                                        @error('priority')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <!-- Etiquetas -->
                                    <div class="mb-6">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Etiquetas</label>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($tags as $tag)
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                                       class="form-checkbox h-4 w-4 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500"
                                                       {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                                <span class="ml-2 text-sm text-gray-700">{{ $tag->name }}</span>
                                            </label>
                                            @endforeach
                                        </div>
                                        @error('tags')
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex justify-between">
                                <button type="button" onclick="prevStep(2)" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-arrow-left mr-2"></i> Anterior
                                </button>
                                <button type="button" onclick="nextStep(2)" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Siguiente <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Step 3: Review -->
                        <div class="step-content hidden" id="step3Content">
                            <div class="bg-white rounded-lg shadow overflow-hidden">
                                <div class="px-6 py-4 border-b border-gray-200">
                                    <h3 class="text-lg font-medium text-gray-900">Revisión del Proyecto</h3>
                                </div>
                                
                                <div class="p-6">
                                    <div class="space-y-6">
                                        <!-- Información básica -->
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 mb-2">Información Básica</h4>
                                            <div class="bg-gray-50 rounded-lg p-4">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">Título</p>
                                                        <p class="text-base font-medium text-gray-900" id="reviewTitle"></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-500">Materia</p>
                                                        <p class="text-base font-medium text-gray-900" id="reviewCourse"></p>
                                                    </div>
                                                </div>
                                                <div class="mt-4">
                                                    <p class="text-sm text-gray-500">Descripción</p>
                                                    <p class="text-base text-gray-900" id="reviewDescription"></p>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Detalles -->
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500 mb-2">Detalles</h4>
                                            <div class="bg-gray-50 rounded-lg p-4">
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">Fecha de inicio</p>
                                                        <p class="text-base font-medium text-gray-900" id="reviewStartDate"></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-500">Fecha de entrega</p>
                                                        <p class="text-base font-medium text-gray-900" id="reviewDueDate"></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-500">Prioridad</p>
                                                        <p class="text-base font-medium text-gray-900" id="reviewPriority"></p>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-500">Etiquetas</p>
                                                        <div class="flex flex-wrap gap-2" id="reviewTags"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 flex justify-between">
                                <button type="button" onclick="prevStep(3)" class="px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-arrow-left mr-2"></i> Anterior
                                </button>
                                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Crear Proyecto <i class="fas fa-check ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('sidebar-open');
        });

        // Wizard navigation
        function nextStep(currentStep) {
            // Hide current step
            document.getElementById(`step${currentStep}Content`).classList.add('hidden');
            
            // Show next step
            document.getElementById(`step${currentStep + 1}Content`).classList.remove('hidden');
            
            // Update step indicators
            document.getElementById(`step${currentStep}`).classList.remove('active');
            document.getElementById(`step${currentStep + 1}`).classList.add('active');
            
            // If moving to review step, update review content
            if (currentStep === 2) {
                updateReviewContent();
            }
        }
        
        function prevStep(currentStep) {
            // Hide current step
            document.getElementById(`step${currentStep}Content`).classList.add('hidden');
            
            // Show previous step
            document.getElementById(`step${currentStep - 1}Content`).classList.remove('hidden');
            
            // Update step indicators
            document.getElementById(`step${currentStep}`).classList.remove('active');
            document.getElementById(`step${currentStep - 1}`).classList.add('active');
        }
        
        function updateReviewContent() {
            // Update basic information
            document.getElementById('reviewTitle').textContent = document.getElementById('title').value;
            document.getElementById('reviewCourse').textContent = document.getElementById('course_id').options[document.getElementById('course_id').selectedIndex].text;
            document.getElementById('reviewDescription').textContent = document.getElementById('description').value;
            
            // Update details
            document.getElementById('reviewStartDate').textContent = new Date(document.getElementById('start_date').value).toLocaleString();
            document.getElementById('reviewDueDate').textContent = new Date(document.getElementById('due_date').value).toLocaleString();
            document.getElementById('reviewPriority').textContent = document.getElementById('priority').options[document.getElementById('priority').selectedIndex].text;
            
            // Update tags
            const tagsContainer = document.getElementById('reviewTags');
            tagsContainer.innerHTML = '';
            document.querySelectorAll('input[name="tags[]"]:checked').forEach(checkbox => {
                const tag = document.createElement('span');
                tag.className = 'px-2 py-1 text-xs rounded-full bg-indigo-100 text-indigo-800';
                tag.textContent = checkbox.nextElementSibling.textContent;
                tagsContainer.appendChild(tag);
            });
        }

        // Form validation
        document.getElementById('projectForm').addEventListener('submit', function(e) {
            const startDate = new Date(document.getElementById('start_date').value);
            const dueDate = new Date(document.getElementById('due_date').value);

            if (startDate >= dueDate) {
                e.preventDefault();
                alert('La fecha de inicio debe ser anterior a la fecha de entrega');
            }
        });
    </script>
</body>
</html> 