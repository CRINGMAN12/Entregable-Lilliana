@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Encabezado -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Seguridad</h1>
            <p class="text-gray-600 mt-2">Gestiona la seguridad de tu cuenta y sesiones</p>
        </div>

        <!-- Grid de Contenido -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Autenticación -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Autenticación</h2>
                        
                        <!-- Contraseña -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-800">Contraseña</h3>
                                    <p class="text-sm text-gray-500">Última actualización: {{ $user->password_updated_at->diffForHumans() }}</p>
                                </div>
                                <button onclick="showChangePasswordModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                    Cambiar Contraseña
                                </button>
                            </div>
                        </div>

                        <!-- Autenticación de Dos Factores -->
                        <div class="mb-6">
                            <div class="flex justify-between items-center mb-4">
                                <div>
                                    <h3 class="text-sm font-medium text-gray-800">Autenticación de Dos Factores</h3>
                                    <p class="text-sm text-gray-500">Añade una capa extra de seguridad a tu cuenta</p>
                                </div>
                                <button onclick="toggle2FA()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                    {{ $user->two_factor_enabled ? 'Desactivar 2FA' : 'Activar 2FA' }}
                                </button>
                            </div>
                        </div>

                        <!-- Métodos de Acceso -->
                        <div class="mb-6">
                            <h3 class="text-sm font-medium text-gray-800 mb-4">Métodos de Acceso</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Correo Electrónico</p>
                                            <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                </div>
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-mobile-alt text-gray-400"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Teléfono Móvil</p>
                                            <p class="text-xs text-gray-500">{{ $user->phone ?? 'No configurado' }}</p>
                                        </div>
                                    </div>
                                    <button onclick="updatePhone()" class="text-blue-600 hover:text-blue-800">
                                        {{ $user->phone ? 'Actualizar' : 'Añadir' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sesiones Activas -->
                <div class="mt-6 bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-medium text-gray-800">Sesiones Activas</h2>
                            <button onclick="logoutAllSessions()" class="text-red-600 hover:text-red-800">
                                Cerrar Todas las Sesiones
                            </button>
                        </div>
                        <div class="space-y-4">
                            @foreach($sessions as $session)
                                <div class="flex items-center justify-between p-4 border rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-{{ $session->device_type === 'mobile' ? 'mobile-alt' : 'desktop' }} text-gray-400"></i>
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">
                                                {{ $session->device_type === 'mobile' ? 'Dispositivo Móvil' : 'Navegador Web' }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $session->ip_address }} - {{ $session->last_activity->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                    @if($session->is_current)
                                        <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800">
                                            Sesión Actual
                                        </span>
                                    @else
                                        <button onclick="logoutSession({{ $session->id }})" class="text-red-600 hover:text-red-800">
                                            Cerrar Sesión
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel Lateral -->
            <div class="lg:col-span-1">
                <!-- Actividad Reciente -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Actividad Reciente</h2>
                    <div class="space-y-4">
                        @foreach($activities as $activity)
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-{{ $activity->icon }} text-gray-400"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-800">{{ $activity->description }}</p>
                                    <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Consejos de Seguridad -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Consejos de Seguridad</h2>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-shield-alt text-blue-500 mt-1"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Usa una contraseña fuerte</p>
                                <p class="text-xs text-gray-500">Combina letras, números y símbolos</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-lock text-blue-500 mt-1"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Activa la autenticación de dos factores</p>
                                <p class="text-xs text-gray-500">Añade una capa extra de seguridad</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-eye-slash text-blue-500 mt-1"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-800">No compartas tus credenciales</p>
                                <p class="text-xs text-gray-500">Mantén tu información segura</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Cambio de Contraseña -->
<div id="passwordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900">Cambiar Contraseña</h3>
            <form id="passwordForm" class="mt-4">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Contraseña Actual</label>
                    <input type="password" name="current_password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nueva Contraseña</label>
                    <input type="password" name="new_password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Confirmar Nueva Contraseña</label>
                    <input type="password" name="new_password_confirmation" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closePasswordModal()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Cambiar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showChangePasswordModal() {
    document.getElementById('passwordModal').classList.remove('hidden');
}

function closePasswordModal() {
    document.getElementById('passwordModal').classList.add('hidden');
}

function toggle2FA() {
    // Implementar lógica para activar/desactivar 2FA
}

function updatePhone() {
    // Implementar lógica para actualizar teléfono
}

function logoutSession(sessionId) {
    if (confirm('¿Estás seguro de que deseas cerrar esta sesión?')) {
        // Implementar lógica para cerrar sesión
    }
}

function logoutAllSessions() {
    if (confirm('¿Estás seguro de que deseas cerrar todas las sesiones excepto la actual?')) {
        // Implementar lógica para cerrar todas las sesiones
    }
}

// Manejo del formulario de cambio de contraseña
document.getElementById('passwordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Implementar lógica para cambiar contraseña
    closePasswordModal();
});
</script>
@endpush
@endsection 