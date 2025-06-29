@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Encabezado -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Configuración de Notificaciones</h1>
            <p class="text-gray-600 mt-2">Gestiona tus preferencias de notificación</p>
        </div>

        <!-- Grid de Contenido -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Preferencias de Notificación -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-800 mb-4">Preferencias de Notificación</h2>
                        
                        <form id="notificationForm" class="space-y-6">
                            <!-- Notificaciones por Email -->
                            <div class="border-b pb-6">
                                <h3 class="text-sm font-medium text-gray-800 mb-4">Notificaciones por Email</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Recordatorios de Tareas</p>
                                            <p class="text-xs text-gray-500">Recibe notificaciones sobre tareas próximas a vencer</p>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="email_task_reminders" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Actualizaciones de Proyectos</p>
                                            <p class="text-xs text-gray-500">Notificaciones sobre cambios en proyectos</p>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="email_project_updates" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Menciones</p>
                                            <p class="text-xs text-gray-500">Notificaciones cuando alguien te menciona</p>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="email_mentions" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notificaciones Push -->
                            <div class="border-b pb-6">
                                <h3 class="text-sm font-medium text-gray-800 mb-4">Notificaciones Push</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Habilitar Notificaciones Push</p>
                                            <p class="text-xs text-gray-500">Recibe notificaciones en tiempo real</p>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="enable_push" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Sonido</p>
                                            <p class="text-xs text-gray-500">Reproducir sonido al recibir notificaciones</p>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="push_sound" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Resumen Diario -->
                            <div class="border-b pb-6">
                                <h3 class="text-sm font-medium text-gray-800 mb-4">Resumen Diario</h3>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Habilitar Resumen Diario</p>
                                            <p class="text-xs text-gray-500">Recibe un resumen de tus actividades diarias</p>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="enable_daily_summary" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Hora de Envío</label>
                                        <select name="daily_summary_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                            <option value="18:00">6:00 PM</option>
                                            <option value="19:00">7:00 PM</option>
                                            <option value="20:00">8:00 PM</option>
                                            <option value="21:00">9:00 PM</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Recordatorios -->
                            <div>
                                <h3 class="text-sm font-medium text-gray-800 mb-4">Recordatorios</h3>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Tiempo de Anticipación</label>
                                        <select name="reminder_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                                            <option value="15">15 minutos antes</option>
                                            <option value="30">30 minutos antes</option>
                                            <option value="60">1 hora antes</option>
                                            <option value="1440">1 día antes</option>
                                        </select>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-800">Recordatorios Recurrentes</p>
                                            <p class="text-xs text-gray-500">Enviar recordatorios hasta que la tarea se complete</p>
                                        </div>
                                        <div class="flex items-center">
                                            <input type="checkbox" name="recurring_reminders" checked class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Botones de Acción -->
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="resetForm()" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-lg">
                                    Restablecer
                                </button>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Panel Lateral -->
            <div class="lg:col-span-1">
                <!-- Estado de Notificaciones -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Estado de Notificaciones</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Notificaciones Push</span>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $notifications->push_enabled ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $notifications->push_enabled ? 'Habilitadas' : 'Deshabilitadas' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Notificaciones por Email</span>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $notifications->email_enabled ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $notifications->email_enabled ? 'Habilitadas' : 'Deshabilitadas' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Resumen Diario</span>
                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $notifications->daily_summary_enabled ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $notifications->daily_summary_enabled ? 'Habilitado' : 'Deshabilitado' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Consejos -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Consejos</h2>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-bell text-blue-500 mt-1"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Personaliza tus notificaciones</p>
                                <p class="text-xs text-gray-500">Ajusta las preferencias según tus necesidades</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-clock text-blue-500 mt-1"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Configura los recordatorios</p>
                                <p class="text-xs text-gray-500">Elige el momento adecuado para recibir notificaciones</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-envelope text-blue-500 mt-1"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Revisa tu bandeja de entrada</p>
                                <p class="text-xs text-gray-500">Mantén tu correo organizado para no perder notificaciones importantes</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function resetForm() {
    if (confirm('¿Estás seguro de que deseas restablecer todas las preferencias?')) {
        document.getElementById('notificationForm').reset();
    }
}

// Manejo del formulario de notificaciones
document.getElementById('notificationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    // Implementar lógica para guardar preferencias
});

// Manejo de notificaciones push
document.querySelector('input[name="enable_push"]').addEventListener('change', function(e) {
    if (e.target.checked) {
        // Solicitar permiso para notificaciones push
        if (Notification.permission !== 'granted') {
            Notification.requestPermission();
        }
    }
});
</script>
@endpush
@endsection 