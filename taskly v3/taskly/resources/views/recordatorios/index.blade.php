<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly - Recordatorios</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@600&display=swap');

        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            color: #fff;
            display: flex;
            margin: 0;
        }

        /* Sidebar */
        .sidebar {
            background: #4b3f72;
            width: 220px;
            min-height: 100vh;
            padding-top: 2rem;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1.5rem;
            box-shadow: 2px 0 10px rgba(0,0,0,0.3);
            z-index: 100;
        }

        .sidebar .logo {
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 2px;
            color: #fff;
            margin-bottom: 2rem;
        }

        .sidebar a {
            text-decoration: none;
            color: #ddd;
            font-weight: 600;
            width: 100%;
            padding: 0.8rem 1.2rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar a:hover, .sidebar a.active {
            background: #fff;
            color: #4b3f72;
            font-weight: 700;
        }

        .sidebar a i {
            font-size: 1.4rem;
        }

        /* Main content */
        .main-content {
            margin-left: 220px;
            padding: 3rem 3rem 3rem 2rem;
            flex-grow: 1;
            overflow-x: hidden;
        }

        /* Header recordatorios */
        .header-recordatorios {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .header-recordatorios h2 {
            margin: 0;
            font-weight: 700;
        }

        .btn-custom {
            background: #fff;
            color: #4b3f72;
            font-weight: 700;
            border-radius: 50px;
            padding: 0.6rem 1.8rem;
            border: none;
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.6);
            transition: background-color 0.3s ease, color 0.3s ease;
            white-space: nowrap;
        }

        .btn-custom:hover {
            background: #e6e6e6;
            color: #3a2f55;
        }

        /* Cards recordatorios */
        .reminder-card {
            border-left: 5px solid #0d6efd;
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            color: #fff;
            transition: transform 0.2s ease;
        }

        .reminder-card:hover {
            transform: scale(1.03);
            background: rgba(255, 255, 255, 0.2);
        }

        .reminder-card .card-body {
            padding: 1.25rem 1.5rem;
        }

        /* Tarjeticas Tareas y Proyectos */
        .section-title {
            margin-top: 3rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            font-size: 1.8rem;
            border-bottom: 3px solid #fff;
            padding-bottom: 0.25rem;
            max-width: max-content;
        }

        .task-card, .project-card {
            background: rgba(255, 255, 255, 0.15);
            padding: 1rem 1.5rem;
            border-radius: 15px;
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
            margin-bottom: 1.25rem;
            transition: background-color 0.3s ease, transform 0.2s ease;
            color: #fff;
        }

        .task-card:hover, .project-card:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-5px);
        }

        .task-card h5, .project-card h5 {
            font-weight: 700;
            margin-bottom: 0.4rem;
        }

        .task-card p, .project-card p {
            opacity: 0.9;
            margin-bottom: 0.5rem;
        }

        .task-card small, .project-card small {
            opacity: 0.7;
            font-style: italic;
            font-size: 0.9rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
                flex-direction: row;
                padding: 0.5rem;
                justify-content: space-around;
                box-shadow: none;
            }

            .sidebar a {
                padding: 0.5rem 0.8rem;
                font-size: 0.9rem;
                border-radius: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 2rem 1rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .btn-custom {
                padding: 0.5rem 1.2rem;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">Taskly</div>

        <a href="{{ route('dashboard') }}">
            <i class="bi bi-house-door-fill"></i>Inicio
        </a>
        <a href="{{ route('tasks.index') }}">
            <i class="bi bi-journal-check"></i> Tareas
        </a>
        <a href="{{ route('projects.index') }}">
            <i class="bi bi-kanban"></i> Proyectos
        </a>
        <a href="{{ route('reminders.index') }}" class="active">
            <i class="bi bi-bell-fill"></i> Recordatorios
        </a>
        <a href="{{ route('calendar') }}">
            <i class="bi bi-calendar3"></i> Calendario
        </a>
        <a href="{{ route('settings') }}">
            <i class="bi bi-gear"></i> Configuración
        </a>
        <a href="{{ route('grades') }}">
            <i class="bi bi-star-half"></i> Calificación
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </a>
        </form>
    </div>

    <div class="main-content">
        <div class="header-recordatorios">
            <h2>Recordatorios</h2>
            <a href="{{ route('reminders.create') }}" class="btn-custom">
                <i class="bi bi-plus me-2"></i>Agregar Recordatorio
            </a>
        </div>

        <div class="row g-4">
            @foreach($reminders as $reminder)
            <div class="col-md-6 col-lg-4">
                <div class="card reminder-card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $reminder->title }}</h5>
                        <p class="card-text">Fecha límite: {{ $reminder->due_date->format('d \d\e F') }}</p>
                        <span class="badge bg-{{ $reminder->priority_color }}">
                            {{ $reminder->priority_text }} prioridad
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Sección Tareas -->
        <h2 class="section-title">Tareas</h2>
        @foreach($tasks as $task)
        <div class="task-card">
            <h5>{{ $task->title }}</h5>
            <p>{{ $task->description }}</p>
            <small>Fecha de entrega: {{ $task->due_date->format('Y-m-d') }}</small>
        </div>
        @endforeach

        <!-- Sección Proyectos -->
        <h2 class="section-title">Proyectos</h2>
        @foreach($projects as $project)
        <div class="project-card">
            <h5>{{ $project->title }}</h5>
            <p>{{ $project->description }}</p>
            <small>Fecha de entrega: {{ $project->due_date->format('Y-m-d') }}</small>
        </div>
        @endforeach
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('sidebar-open');
        });
    </script>
</body>
</html> 