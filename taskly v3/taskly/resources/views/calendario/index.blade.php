<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly - Calendario</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales/es.js'></script>
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

        .calendar-day:hover {
            background-color: #f3f4f6;
            transform: scale(1.02);
        }

        .calendar-day.today {
            background-color: #e0e7ff;
            border: 2px solid var(--primary);
        }

        .event-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 4px;
        }

        .fc-event {
            cursor: pointer;
            border-radius: 4px;
            padding: 2px 4px;
            margin-bottom: 2px;
            font-size: 0.85rem;
        }

        .fc-daygrid-event {
            white-space: normal;
        }

        /* Estilos personalizados para FullCalendar */
        .fc .fc-toolbar-title {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .fc .fc-button-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .fc .fc-button-primary:hover {
            background-color: #4338ca;
            border-color: #4338ca;
        }

        .fc .fc-button-primary:disabled {
            background-color: #a5b4fc;
            border-color: #a5b4fc;
        }

        .fc .fc-day-today {
            background-color: #e0e7ff !important;
        }

        .fc-event-task {
            border-left: 4px solid var(--primary);
        }

        .fc-event-project {
            border-left: 4px solid var(--secondary);
        }

        .fc-event-exam {
            border-left: 4px solid var(--danger);
        }

        .fc-event-reminder {
            border-left: 4px solid var(--warning);
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
                                <a href="{{ route('projects.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md text-gray-600 hover:bg-gray-50">
                                    <i class="fas fa-project-diagram mr-3 text-gray-500"></i> Proyectos
                                </a>
                            </li>
                            <li class="mb-1">
                                <a href="{{ route('calendar') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md bg-indigo-50 text-indigo-700">
                                    <i class="fas fa-calendar-alt mr-3 text-indigo-500"></i> Calendario
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
                <a href="{{ route('profile') }}" class="flex items-center hover:bg-gray-50 p-2 rounded-md transition-colors">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full mr-2">
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500">Estudiante</p>
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
                        <h2 class="text-xl font-semibold text-gray-800">Calendario Académico</h2>
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button class="p-1 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-bell"></i>
                                <span class="absolute top-0 right-0 w-2 h-2 rounded-full bg-red-500"></span>
                            </button>
                        </div>
                        <div class="relative">
                            <input type="text" placeholder="Buscar eventos..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <!-- Calendar Navigation -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                    <div class="flex items-center mb-4 md:mb-0">
                        <button id="prevMonth" class="p-2 rounded-full hover:bg-gray-100 mr-2">
                            <i class="fas fa-chevron-left text-gray-600"></i>
                        </button>
                        <h3 class="text-xl font-semibold text-gray-800" id="currentMonthYear">Mayo 2023</h3>
                        <button id="nextMonth" class="p-2 rounded-full hover:bg-gray-100 ml-2">
                            <i class="fas fa-chevron-right text-gray-600"></i>
                        </button>
                        <button id="todayBtn" class="ml-4 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Hoy
                        </button>
                    </div>

                    <div class="flex items-center space-x-2">
                        <button id="dayView" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Día
                        </button>
                        <button id="weekView" class="px-4 py-2 bg-white border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Semana
                        </button>
                        <button id="monthView" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Mes
                        </button>
                        <button id="addEventBtn" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-plus mr-1"></i> Nuevo Evento
                        </button>
                    </div>
                </div>

                <!-- Calendar -->
                <div id="calendar" class="bg-white rounded-lg shadow overflow-hidden"></div>
            </main>
        </div>
    </div>

    <!-- Modal para crear/editar evento -->
    <div id="eventModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">Nuevo Evento</h3>
                <form id="eventForm">
                    <div class="mb-4">
                        <label for="eventTitle" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                        <input type="text" id="eventTitle" name="title" required 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    
                    <div class="mb-4">
                        <label for="eventType" class="block text-sm font-medium text-gray-700 mb-1">Tipo *</label>
                        <select id="eventType" name="type" required 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="task">Tarea</option>
                            <option value="project">Proyecto</option>
                            <option value="exam">Examen</option>
                            <option value="reminder">Recordatorio</option>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="eventStart" class="block text-sm font-medium text-gray-700 mb-1">Inicio *</label>
                            <input type="datetime-local" id="eventStart" name="start" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label for="eventEnd" class="block text-sm font-medium text-gray-700 mb-1">Fin *</label>
                            <input type="datetime-local" id="eventEnd" name="end" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="eventDescription" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                        <textarea id="eventDescription" name="description" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEventModal()" 
                                class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-50">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('sidebar-open');
        });

        // Initialize FullCalendar
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: '',
                    center: '',
                    right: ''
                },
                events: [
                    @foreach($events as $event)
                    {
                        id: '{{ $event->id }}',
                        title: '{{ $event->title }}',
                        start: '{{ $event->start_date }}',
                        end: '{{ $event->end_date }}',
                        description: '{{ $event->description }}',
                        type: '{{ $event->type }}',
                        className: 'fc-event-{{ $event->type }}'
                    },
                    @endforeach
                ],
                eventClick: function(info) {
                    showEventModal(info.event);
                },
                dateClick: function(info) {
                    showEventModal(null, info.date);
                }
            });
            calendar.render();

            // Calendar navigation
            document.getElementById('prevMonth').addEventListener('click', function() {
                calendar.prev();
                updateMonthYear();
            });

            document.getElementById('nextMonth').addEventListener('click', function() {
                calendar.next();
                updateMonthYear();
            });

            document.getElementById('todayBtn').addEventListener('click', function() {
                calendar.today();
                updateMonthYear();
            });

            // View switching
            document.getElementById('dayView').addEventListener('click', function() {
                calendar.changeView('timeGridDay');
                updateActiveViewButton(this);
            });

            document.getElementById('weekView').addEventListener('click', function() {
                calendar.changeView('timeGridWeek');
                updateActiveViewButton(this);
            });

            document.getElementById('monthView').addEventListener('click', function() {
                calendar.changeView('dayGridMonth');
                updateActiveViewButton(this);
            });

            // Add event button
            document.getElementById('addEventBtn').addEventListener('click', function() {
                showEventModal();
            });

            // Update month and year display
            function updateMonthYear() {
                const date = calendar.getDate();
                const options = { month: 'long', year: 'numeric' };
                document.getElementById('currentMonthYear').textContent = date.toLocaleDateString('es-ES', options);
            }

            // Update active view button
            function updateActiveViewButton(activeButton) {
                const buttons = document.querySelectorAll('#dayView, #weekView, #monthView');
                buttons.forEach(button => {
                    button.classList.remove('bg-indigo-600', 'text-white');
                    button.classList.add('bg-white', 'text-gray-700', 'border');
                });
                activeButton.classList.remove('bg-white', 'text-gray-700', 'border');
                activeButton.classList.add('bg-indigo-600', 'text-white');
            }

            // Event modal functions
            function showEventModal(event = null, date = null) {
                const modal = document.getElementById('eventModal');
                const form = document.getElementById('eventForm');
                const title = document.getElementById('modalTitle');

                if (event) {
                    title.textContent = 'Editar Evento';
                    document.getElementById('eventTitle').value = event.title;
                    document.getElementById('eventType').value = event.extendedProps.type;
                    document.getElementById('eventStart').value = event.start.toISOString().slice(0, 16);
                    document.getElementById('eventEnd').value = event.end.toISOString().slice(0, 16);
                    document.getElementById('eventDescription').value = event.extendedProps.description;
                    form.dataset.eventId = event.id;
                } else {
                    title.textContent = 'Nuevo Evento';
                    form.reset();
                    if (date) {
                        document.getElementById('eventStart').value = date.toISOString().slice(0, 16);
                        const endDate = new Date(date);
                        endDate.setHours(endDate.getHours() + 1);
                        document.getElementById('eventEnd').value = endDate.toISOString().slice(0, 16);
                    }
                    delete form.dataset.eventId;
                }

                modal.classList.remove('hidden');
            }

            function closeEventModal() {
                document.getElementById('eventModal').classList.add('hidden');
            }

            // Handle form submission
            document.getElementById('eventForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                const eventId = this.dataset.eventId;

                fetch(`/calendar/events${eventId ? '/' + eventId : ''}`, {
                    method: eventId ? 'PUT' : 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        calendar.refetchEvents();
                        closeEventModal();
                    } else {
                        alert('Error al guardar el evento');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al guardar el evento');
                });
            });
        });
    </script>
</body>
</html> 