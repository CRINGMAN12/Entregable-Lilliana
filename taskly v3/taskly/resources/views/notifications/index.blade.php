@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Encabezado -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Notificaciones</h1>
            <div class="flex space-x-2">
                <button onclick="markAllAsRead()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-check-double mr-2"></i>
                    Marcar todas como leídas
                </button>
                <button onclick="clearAll()" class="bg-red-100 hover:bg-red-200 text-red-700 px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-trash mr-2"></i>
                    Limpiar todas
                </button>
            </div>
        </div>

        <!-- Filtros -->
        <div class="bg-white rounded-lg shadow-md p-4 mb-6">
            <form action="{{ route('notifications.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                    <select name="type" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        <option value="">Todos los tipos</option>
                        <option value="task" {{ request('type') === 'task' ? 'selected' : '' }}>Tareas</option>
                        <option value="project" {{ request('type') === 'project' ? 'selected' : '' }}>Proyectos</option>
                        <option value="reminder" {{ request('type') === 'reminder' ? 'selected' : '' }}>Recordatorios</option>
                        <option value="course" {{ request('type') === 'course' ? 'selected' : '' }}>Cursos</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="read" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        <option value="">Todos</option>
                        <option value="0" {{ request('read') === '0' ? 'selected' : '' }}>No leídas</option>
                        <option value="1" {{ request('read') === '1' ? 'selected' : '' }}>Leídas</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                    <select name="date" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        <option value="">Todas las fechas</option>
                        <option value="today" {{ request('date') === 'today' ? 'selected' : '' }}>Hoy</option>
                        <option value="week" {{ request('date') === 'week' ? 'selected' : '' }}>Esta semana</option>
                        <option value="month" {{ request('date') === 'month' ? 'selected' : '' }}>Este mes</option>
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

        <!-- Lista de Notificaciones -->
        <div class="space-y-4">
            @forelse($notifications as $notification)
            <div class="bg-white rounded-lg shadow-md p-4 {{ $notification->read_at ? 'opacity-75' : '' }}">
                <div class="flex items-start">
                    <!-- Icono -->
                    <div class="flex-shrink-0">
                        <span class="w-10 h-10 rounded-full flex items-center justify-center" style="background-color: {{ $notification->data['color'] }}20">
                            <i class="{{ $notification->data['icon'] }} text-lg" style="color: {{ $notification->data['color'] }}"></i>
                        </span>
                    </div>

                    <!-- Contenido -->
                    <div class="ml-4 flex-1">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-gray-800">{{ $notification->data['message'] }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if(!$notification->read_at)
                                <button onclick="markAsRead('{{ $notification->id }}')" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-check"></i>
                                </button>
                                @endif
                                <button onclick="deleteNotification('{{ $notification->id }}')" class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Acciones -->
                        @if(isset($notification->data['action_url']))
                        <div class="mt-3">
                            <a href="{{ $notification->data['action_url'] }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                {{ $notification->data['action_text'] ?? 'Ver detalles' }}
                                <i class="fas fa-arrow-right ml-1"></i>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-lg shadow-md p-6 text-center">
                <div class="text-gray-400 mb-4">
                    <i class="fas fa-bell text-4xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-800 mb-2">No hay notificaciones</h3>
                <p class="text-gray-600">
                    {{ request()->hasAny(['type', 'read', 'date']) ? 'Intenta con otros filtros' : 'Tus notificaciones aparecerán aquí' }}
                </p>
            </div>
            @endforelse
        </div>

        <!-- Paginación -->
        @if($notifications->hasPages())
        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function markAsRead(id) {
    fetch(`/notifications/${id}/mark-as-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    }).then(response => {
        if (response.ok) {
            window.location.reload();
        }
    });
}

function markAllAsRead() {
    if (confirm('¿Estás seguro de marcar todas las notificaciones como leídas?')) {
        fetch('/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }
}

function deleteNotification(id) {
    if (confirm('¿Estás seguro de eliminar esta notificación?')) {
        fetch(`/notifications/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }
}

function clearAll() {
    if (confirm('¿Estás seguro de eliminar todas las notificaciones?')) {
        fetch('/notifications/clear-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }
}
</script>
@endpush
@endsection 