<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly - Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
        }

        /* Config Panel Styles */
        #configPanel {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            width: 400px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            z-index: 100;
            overflow-y: auto;
        }
        
        .config-panel-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .config-panel-body {
            padding: 1.5rem;
        }
        
        .config-section {
            margin-bottom: 2rem;
        }
        
        .config-section h3 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: #111827;
        }
        
        .config-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 26px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e5e7eb;
            transition: .4s;
            border-radius: 34px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: #4f46e5;
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(26px);
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
                <a href="{{ route('profile.edit') }}" class="flex items-center hover:bg-gray-50 p-2 rounded-md transition-colors">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full mr-2">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Estudiante</p>
                        <a href="#" id="configBtn" class="flex items-center text-sm text-gray-500 hover:text-gray-700 mt-2">
                            <i class="fas fa-cog mr-2"></i> Configuración
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="flex items-center text-sm text-gray-500 hover:text-gray-700">
                                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar sesión
                            </button>
                        </form>
                    </div>
                </a>
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
    
    <!-- Config Panel -->
    <div id="configPanel" class="bg-white">
        <div class="config-panel-header">
            <h2 class="text-xl font-bold">Configuración</h2>
            <button id="closeConfigPanel" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="config-panel-body">
            <div class="config-section">
                <h3>Preferencias de la Aplicación</h3>
                
                <div class="config-item">
                    <span>Modo Oscuro</span>
                    <label class="toggle-switch">
                        <input type="checkbox">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                
                <div class="config-item">
                    <span>Notificaciones</span>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                
                <div class="config-item">
                    <span>Recordatorios</span>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
            
            <div class="config-section">
                <h3>Preferencias de Notificaciones</h3>
                
                <div class="flex items-center justify-between mb-4">
                    <span>Sonido de notificaciones</span>
                    <select class="border rounded px-3 py-1 text-sm">
                        <option>Predeterminado</option>
                        <option>Ninguno</option>
                        <option>Personalizado</option>
                    </select>
                </div>
                
                <div class="flex items-center justify-between">
                    <span>Frecuencia de recordatorios</span>
                    <select class="border rounded px-3 py-1 text-sm">
                        <option>30 minutos antes</option>
                        <option>1 hora antes</option>
                        <option>2 horas antes</option>
                        <option>1 día antes</option>
                    </select>
                </div>
            </div>
            
            <div class="config-section">
                <h3>Privacidad</h3>
                <button class="w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium text-gray-700 mb-2">
                    Exportar mis datos
                </button>
                <button class="w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium text-gray-700">
                    Eliminar mi cuenta
                </button>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('sidebar-open');
        });

        // Toggle config panel
        const configBtn = document.getElementById('configBtn');
        const closeConfigPanel = document.getElementById('closeConfigPanel');
        const configPanel = document.getElementById('configPanel');
        
        configBtn.addEventListener('click', (e) => {
            e.preventDefault();
            configPanel.style.display = 'block';
        });
        
        closeConfigPanel.addEventListener('click', () => {
            configPanel.style.display = 'none';
        });
        
        // Close config panel when clicking outside
        document.addEventListener('click', (e) => {
            if (!configBtn.contains(e.target) && !configPanel.contains(e.target)) {
                configPanel.style.display = 'none';
            }
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly - Administrador de Tareas para Estudiantes</title>
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
        
        /* Notifications dropdown styles */
        .notifications-dropdown {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            width: 320px;
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            z-index: 50;
        }
        
        .notifications-dropdown.open {
            display: block;
            animation: fadeIn 0.2s ease-out;
        }
        
        .notification-item.unread {
            background-color: #f5f3ff;
        }
        
        /* User dropdown styles */
        #userMenu {
            transition: all 0.3s ease;
            z-index: 20;
        }
        
        /* Config Panel Styles */
        #configPanel {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            width: 400px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            z-index: 100;
            overflow-y: auto;
        }
        
        .config-panel-header {
            padding: 1.5rem;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .config-panel-body {
            padding: 1.5rem;
        }
        
        .config-section {
            margin-bottom: 2rem;
        }
        
        .config-section h3 {
            font-weight: 600;
            margin-bottom: 1rem;
            color: #111827;
        }
        
        .config-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 52px;
            height: 26px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #e5e7eb;
            transition: .4s;
            border-radius: 34px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: #4f46e5;
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(26px);
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
                                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md bg-indigo-50 text-indigo-700">
                                    <i class="fas fa-tachometer-alt mr-3 text-indigo-500"></i> Dashboard
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="tareas/lista.html" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                    <i class="fas fa-tasks mr-3 text-gray-500"></i> Tareas
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="proyectos/lista.html" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                    <i class="fas fa-project-diagram mr-3 text-gray-500"></i> Proyectos
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="calendario/calendario.html" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                    <i class="fas fa-calendar-alt mr-3 text-gray-500"></i> Calendario
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Mis Cursos</h3>
                        <ul>
                            <li class="mb-1">
                                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                    <span class="w-2 h-2 mr-3 rounded-full bg-green-500"></span> Matemáticas
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                    <span class="w-2 h-2 mr-3 rounded-full bg-blue-500"></span> Física
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                    <span class="w-2 h-2 mr-3 rounded-full bg-purple-500"></span> Programación
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                    <span class="w-2 h-2 mr-3 rounded-full bg-yellow-500"></span> Historia
                                </a>
                            </li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Etiquetas</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Examen</span>
                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Tarea</span>
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Proyecto</span>
                            <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">Lectura</span>
                        </div>
                    </div>
                </nav>
            </div>
            
            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="User" class="w-8 h-8 rounded-full mr-2">
                        <div>
                            <p class="text-sm font-medium">Ana Martínez</p>
                            <p class="text-xs text-gray-500">Estudiante</p>
                        </div>
                    </div>
                    <button id="userMenuBtn" class="text-gray-400 hover:text-gray-500">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>
                </div>
                <!-- User Dropdown Menu -->
                <div id="userMenu" class="hidden mt-2 w-full bg-white rounded-md shadow-lg py-1 border border-gray-200">
                    <a href="#" id="configBtn" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fas fa-cog mr-2"></i>Configuración</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"><i class="fas fa-sign-out-alt mr-2"></i>Cerrar sesión</a>
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
                        <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button id="notificationsBtn" class="p-1 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-bell"></i>
                                <span class="absolute top-0 right-0 w-2 h-2 rounded-full bg-red-500"></span>
                            </button>
                            
                            <!-- Notifications Dropdown -->
                            <div id="notificationsDropdown" class="notifications-dropdown">
                                <div class="p-4 border-b border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <h3 class="text-lg font-medium text-gray-900">Notificaciones</h3>
                                        <button class="text-sm text-indigo-600 hover:text-indigo-800">Marcar todas como leídas</button>
                                    </div>
                                </div>
                                <div class="divide-y divide-gray-200 max-h-96 overflow-y-auto">
                                    <!-- Notification Item -->
                                    <div class="notification-item unread p-4 hover:bg-gray-50 cursor-pointer">
                                        <div class="flex">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                                                    <i class="fas fa-exclamation-circle"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">Tarea pendiente</p>
                                                <p class="text-sm text-gray-500 truncate">Tienes una tarea de Matemáticas que vence mañana</p>
                                                <p class="text-xs text-gray-400 mt-1">Hoy, 10:30 AM</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Notification Item -->
                                    <div class="notification-item unread p-4 hover:bg-gray-50 cursor-pointer">
                                        <div class="flex">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                                    <i class="fas fa-check-circle"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">Proyecto calificado</p>
                                                <p class="text-sm text-gray-500 truncate">Tu proyecto de Programación ha sido calificado: 9.5</p>
                                                <p class="text-xs text-gray-400 mt-1">Ayer, 4:15 PM</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Notification Item -->
                                    <div class="notification-item p-4 hover:bg-gray-50 cursor-pointer">
                                        <div class="flex">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-600">
                                                    <i class="fas fa-calendar-day"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">Recordatorio de examen</p>
                                                <p class="text-sm text-gray-500 truncate">Examen de Física programado para mañana</p>
                                                <p class="text-xs text-gray-400 mt-1">Ayer, 9:00 AM</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Notification Item -->
                                    <div class="notification-item p-4 hover:bg-gray-50 cursor-pointer">
                                        <div class="flex">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                                    <i class="fas fa-comment-alt"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">Nuevo mensaje</p>
                                                <p class="text-sm text-gray-500 truncate">El profesor de Historia ha publicado un nuevo anuncio</p>
                                                <p class="text-xs text-gray-400 mt-1">2 días atrás</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Notification Item -->
                                    <div class="notification-item p-4 hover:bg-gray-50 cursor-pointer">
                                        <div class="flex">
                                            <div class="flex-shrink-0 mr-3">
                                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                                    <i class="fas fa-users"></i>
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">Invitación a grupo</p>
                                                <p class="text-sm text-gray-500 truncate">Has sido invitado al grupo de estudio de Álgebra</p>
                                                <p class="text-xs text-gray-400 mt-1">3 días atrás</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-3 border-t border-gray-200 text-center">
                                    <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Ver todas las notificaciones</a>
                                </div>
                            </div>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Tareas pendientes</p>
                                <p class="text-2xl font-bold mt-1">8</p>
                            </div>
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                                <i class="fas fa-tasks"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Proyectos activos</p>
                                <p class="text-2xl font-bold mt-1">3</p>
                            </div>
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Próximos exámenes</p>
                                <p class="text-2xl font-bold mt-1">2</p>
                            </div>
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Promedio general</p>
                                <p class="text-2xl font-bold mt-1">8.7</p>
                            </div>
                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Tasks and Projects -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Tasks Section -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">Mis Tareas</h3>
                                <button id="addTaskBtn" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <a href="tareas/crear.html"><i class="fas fa-plus mr-1"></i> Nueva Tarea</a>
                                </button>
                            </div>
                            
                            <!-- Task Filters -->
                            <div class="px-6 py-3 border-b border-gray-200 bg-gray-50">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <select class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option>Todas las materias</option>
                                            <option>Matemáticas</option>
                                            <option>Física</option>
                                            <option>Programación</option>
                                        </select>
                                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs"></i>
                                    </div>
                                    
                                    <div class="relative">
                                        <select class="appearance-none bg-white border border-gray-300 rounded-md pl-3 pr-8 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option>Todas las prioridades</option>
                                            <option>Alta</option>
                                            <option>Media</option>
                                            <option>Baja</option>
                                        </select>
                                        <i class="fas fa-chevron-down absolute right-3 top-3 text-gray-400 text-xs"></i>
                                    </div>
                                    
                                    <button class="px-3 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        <i class="fas fa-filter mr-1"></i> Filtrar
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Task List -->
                            <div class="divide-y divide-gray-200">
                                <!-- Task Item -->
                                <div class="task-item p-6 hover:bg-gray-50 transition-all duration-200 ease-in-out task-priority-high">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5 mt-1">
                                                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3">
                                                <div class="flex items-center">
                                                    <p class="text-sm font-medium text-gray-900">Resolver problemas de álgebra</p>
                                                    <span class="ml-2 px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Examen</span>
                                                </div>
                                                <p class="text-sm text-gray-500 mt-1">Capítulo 4 - Páginas 120-135</p>
                                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    <span>Vence: 15/05/2023</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button class="text-gray-400 hover:text-indigo-600">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button class="text-gray-400 hover:text-red-600">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Task Item -->
                                <div class="task-item p-6 hover:bg-gray-50 transition-all duration-200 ease-in-out task-priority-medium">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5 mt-1">
                                                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            </div>
                                            <div class="ml-3">
                                                <div class="flex items-center">
                                                    <p class="text-sm font-medium text-gray-900">Investigación sobre física cuántica</p>
                                                    <span class="ml-2 px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Proyecto</span>
                                                </div>
                                                <p class="text-sm text-gray-500 mt-1">Mínimo 10 páginas con referencias</p>
                                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    <span>Vence: 20/05/2023</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button class="text-gray-400 hover:text-indigo-600">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button class="text-gray-400 hover:text-red-600">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Task Item -->
                                <div class="task-item p-6 hover:bg-gray-50 transition-all duration-200 ease-in-out task-priority-low">
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-start">
                                            <div class="flex items-center h-5 mt-1">
                                                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" checked>
                                            </div>
                                            <div class="ml-3">
                                                <div class="flex items-center">
                                                    <p class="text-sm font-medium text-gray-900 line-through">Leer capítulo de historia</p>
                                                    <span class="ml-2 px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">Lectura</span>
                                                </div>
                                                <p class="text-sm text-gray-500 mt-1">Revolución Industrial - Capítulo 7</p>
                                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                                    <i class="far fa-calendar-alt mr-1"></i>
                                                    <span class="line-through">Vencía: 10/05/2023</span>
                                                    <span class="ml-2 text-green-600">Completada</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button class="text-gray-400 hover:text-indigo-600">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <button class="text-gray-400 hover:text-red-600">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Projects Section -->
                    <div>
                        <div class="bg-white rounded-lg shadow overflow-hidden">
                            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">Mis Proyectos</h3>
                                <button id="addProjectBtn" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <a href="proyectos/crear_proyectos.html"><i class="fas fa-plus mr-1"></i> Nuevo Proyecto</a>
                                </button>
                            </div>
                            
                            <!-- Project List -->
                            <div class="divide-y divide-gray-200">
                                <!-- Project Item -->
                                <div class="p-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-md font-medium text-gray-900">Sistema de gestión escolar</h4>
                                            <p class="text-sm text-gray-500 mt-1">Programación Avanzada</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full bg-purple-100 text-purple-800">En progreso</span>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <div class="flex justify-between text-sm text-gray-500 mb-1">
                                            <span>Progreso</span>
                                            <span>65%</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 65%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 flex justify-between text-sm">
                                        <div class="text-gray-500">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            <span>Vence: 25/05/2023</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button class="text-gray-400 hover:text-indigo-600">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            <button class="text-gray-400 hover:text-indigo-600">
                                                <i class="far fa-edit"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Project Item -->
                                <div class="p-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-md font-medium text-gray-901">Maqueta de sistema solar</h4>
                                            <p class="text-sm text-gray-500 mt-1">Física</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <div class="flex justify-between text-sm text-gray-500 mb-1">
                                            <span>Progreso</span>
                                            <span>15%</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 15%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 flex justify-between text-sm">
                                        <div class="text-gray-500">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            <span>Vence: 30/05/2023</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button class="text-gray-400 hover:text-indigo-600">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            <button class="text-gray-400 hover:text-indigo-600">
                                                <i class="far fa-edit"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Project Item -->
                                <div class="p-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="text-md font-medium text-gray-902">Análisis histórico</h4>
                                            <p class="text-sm text-gray-500 mt-1">Historia Contemporánea</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completado</span>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <div class="flex justify-between text-sm text-gray-500 mb-1">
                                            <span>Progreso</span>
                                            <span>100%</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: 100%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 flex justify-between text-sm">
                                        <div class="text-gray-500">
                                            <i class="far fa-calendar-alt mr-1"></i>
                                            <span>Venció: 05/05/2023</span>
                                        </div>
                                        <div class="flex space-x-2">
                                            <button class="text-gray-400 hover:text-indigo-600">
                                                <i class="far fa-eye"></i>
                                            </button>
                                            <button class="text-gray-400 hover:text-indigo-600">
                                                <i class="far fa-edit"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Upcoming Exams -->
                        <div class="bg-white rounded-lg shadow overflow-hidden mt-6">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Próximos Exámenes</h3>
                            </div>
                            
                            <div class="divide-y divide-gray-200">
                                <div class="p-6">
                                    <div class="flex justify-between">
                                        <div>
                                            <h4 class="text-md font-medium text-gray-900">Matemáticas</h4>
                                            <p class="text-sm text-gray-500 mt-1">Álgebra lineal</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Crítico</span>
                                    </div>
                                    <div class="mt-4 text-sm text-gray-500">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        <span>18/05/2023 - 10:00 AM</span>
                                    </div>
                                </div>
                                
                                <div class="p-6">
                                    <div class="flex justify-between">
                                        <div>
                                            <h4 class="text-md font-medium text-gray-900">Física</h4>
                                            <p class="text-sm text-gray-500 mt-1">Termodinámica</p>
                                        </div>
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Importante</span>
                                    </div>
                                    <div class="mt-4 text-sm text-gray-500">
                                        <i class="far fa-calendar-alt mr-1"></i>
                                        <span>22/05/2023 - 08:00 AM</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Config Panel -->
    <div id="configPanel" class="bg-white">
        <div class="config-panel-header">
            <h2 class="text-xl font-bold">Configuración</h2>
            <button id="closeConfigPanel" class="text-gray-500 hover:text-gray-700">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="config-panel-body">
            <div class="config-section">
                <h3>Preferencias de la Aplicación</h3>
                
                <div class="config-item">
                    <span>Modo Oscuro</span>
                    <label class="toggle-switch">
                        <input type="checkbox">
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                
                <div class="config-item">
                    <span>Notificaciones</span>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
                
                <div class="config-item">
                    <span>Recordatorios</span>
                    <label class="toggle-switch">
                        <input type="checkbox" checked>
                        <span class="toggle-slider"></span>
                    </label>
                </div>
            </div>
            
            <div class="config-section">
                <h3>Preferencias de Notificaciones</h3>
                
                <div class="flex items-center justify-between mb-4">
                    <span>Sonido de notificaciones</span>
                    <select class="border rounded px-3 py-1 text-sm">
                        <option>Predeterminado</option>
                        <option>Ninguno</option>
                        <option>Personalizado</option>
                    </select>
                </div>
                
                <div class="flex items-center justify-between">
                    <span>Frecuencia de recordatorios</span>
                    <select class="border rounded px-3 py-1 text-sm">
                        <option>30 minutos antes</option>
                        <option>1 hora antes</option>
                        <option>2 horas antes</option>
                        <option>1 día antes</option>
                    </select>
                </div>
            </div>
            
            <div class="config-section">
                <h3>Privacidad</h3>
                <button class="w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium text-gray-700 mb-2">
                    Exportar mis datos
                </button>
                <button class="w-full py-2 px-4 bg-gray-100 hover:bg-gray-200 rounded text-sm font-medium text-gray-700">
                    Eliminar mi cuenta
                </button>
            </div>
        </div>
    </div>
    
    <!-- JavaScript for functionality -->
    <script>
        // Toggle notifications dropdown
        const notificationsBtn = document.getElementById('notificationsBtn');
        const notificationsDropdown = document.getElementById('notificationsDropdown');
        
        notificationsBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            notificationsDropdown.classList.toggle('open');
            
            // Clear notification badge when dropdown is opened
            const badge = notificationsBtn.querySelector('span');
            if (notificationsDropdown.classList.contains('open')) {
                badge.classList.add('hidden');
            } else {
                badge.classList.remove('hidden');
            }
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!notificationsBtn.contains(e.target) && !notificationsDropdown.contains(e.target)) {
                notificationsDropdown.classList.remove('open');
            }
        });
        
        // Mark notifications as read when clicking on them
        document.querySelectorAll('.notification-item').forEach(item => {
            item.addEventListener('click', () => {
                item.classList.remove('unread');
            });
        });

        // Toggle user menu
        const userMenuBtn = document.getElementById('userMenuBtn');
        const userMenu = document.getElementById('userMenu');
        
        userMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenu.classList.toggle('hidden');
        });
        
        // Close user menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!userMenuBtn.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
        
        // Toggle sidebar on mobile
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebar = document.querySelector('.sidebar');
        
        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('sidebar-open');
        });

        // Toggle config panel
        const configBtn = document.getElementById('configBtn');
        const closeConfigPanel = document.getElementById('closeConfigPanel');
        const configPanel = document.getElementById('configPanel');
        
        configBtn.addEventListener('click', (e) => {
            e.preventDefault();
            userMenu.classList.add('hidden');
            configPanel.style.display = 'block';
        });
        
        closeConfigPanel.addEventListener('click', () => {
            configPanel.style.display = 'none';
        });
        
        // Close config panel when clicking outside
        document.addEventListener('click', (e) => {
            if (!configBtn.contains(e.target) && !configPanel.contains(e.target)) {
                configPanel.style.display = 'none';
            }
        });
    </script>
</body>
</html>