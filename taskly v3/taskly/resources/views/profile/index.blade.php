@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Encabezado -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Mi Perfil</h1>
            <p class="text-gray-600 mt-2">Gestiona tu información personal y preferencias</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Información Personal -->
            <div class="md:col-span-2 space-y-6">
                <!-- Tarjeta de Perfil -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover">
                            <button onclick="document.getElementById('photo-input').click()" class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700">
                                <i class="fas fa-camera"></i>
                            </button>
                            <input type="file" id="photo-input" class="hidden" accept="image/*">
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <p class="text-sm text-gray-500 mt-1">Miembro desde {{ $user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Información de Contacto</h3>
                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="tel" name="phone" value="{{ $user->phone }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ubicación</label>
                            <input type="text" name="location" value="{{ $user->location }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Cambiar Contraseña -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Cambiar Contraseña</h3>
                    <form action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contraseña Actual</label>
                            <input type="password" name="current_password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                            <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                Actualizar Contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Estadísticas -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Estadísticas</h3>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Tareas Completadas</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $stats['completed_tasks'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Proyectos Activos</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $stats['active_projects'] }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Cursos Inscritos</p>
                            <p class="text-2xl font-semibold text-gray-800">{{ $stats['enrolled_courses'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Enlaces Rápidos -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Enlaces Rápidos</h3>
                    <div class="space-y-2">
                        <a href="{{ route('notifications.settings') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-bell w-5"></i>
                            <span class="ml-2">Configuración de Notificaciones</span>
                        </a>
                        <a href="{{ route('reports.index') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chart-bar w-5"></i>
                            <span class="ml-2">Mis Reportes</span>
                        </a>
                        <a href="{{ route('help.index') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-question-circle w-5"></i>
                            <span class="ml-2">Ayuda y Soporte</span>
                        </a>
                    </div>
                </div>

                <!-- Sesiones Activas -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-medium text-gray-800 mb-4">Sesiones Activas</h3>
                    <div class="space-y-4">
                        @foreach($sessions as $session)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $session->device }}</p>
                                <p class="text-xs text-gray-500">{{ $session->last_activity }}</p>
                            </div>
                            @if($session->current)
                            <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                Actual
                            </span>
                            @else
                            <button onclick="logoutSession('{{ $session->id }}')" class="text-red-600 hover:text-red-800">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function logoutSession(sessionId) {
    if (confirm('¿Estás seguro de cerrar esta sesión?')) {
        fetch(`/profile/sessions/${sessionId}`, {
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

// Manejo de la foto de perfil
document.getElementById('photo-input').addEventListener('change', function(e) {
    if (e.target.files && e.target.files[0]) {
        const formData = new FormData();
        formData.append('photo', e.target.files[0]);

        fetch('/profile/photo', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        }).then(response => {
            if (response.ok) {
                window.location.reload();
            }
        });
    }
});
</script>
@endpush
@endsection 