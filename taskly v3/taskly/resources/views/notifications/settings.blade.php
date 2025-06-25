@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Encabezado -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Configuración de Notificaciones</h1>
            <p class="text-gray-600 mt-2">Gestiona cómo y cuándo recibir notificaciones</p>
        </div>

        <form action="{{ route('notifications.settings.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Preferencias Generales -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-medium text-gray-800 mb-4">Preferencias Generales</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-gray-700 font-medium">Notificaciones por Email</label>
                            <p class="text-sm text-gray-500">Recibe notificaciones por correo electrónico</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="email_notifications" class="sr-only peer" {{ $settings->email_notifications ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-gray-700 font-medium">Notificaciones Push</label>
                            <p class="text-sm text-gray-500">Recibe notificaciones en el navegador</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="push_notifications" class="sr-only peer" {{ $settings->push_notifications ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between">
                        <div>
                            <label class="text-gray-700 font-medium">Resumen Diario</label>
                            <p class="text-sm text-gray-500">Recibe un resumen diario de tus actividades</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="daily_digest" class="sr-only peer" {{ $settings->daily_digest ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Notificaciones por Tipo -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-lg font-medium text-gray-800 mb-4">Notificaciones por Tipo</h2>
                
                <div class="space-y-6">
                    <!-- Tareas -->
                    <div class="border-b pb-4">
                        <h3 class="text-gray-700 font-medium mb-3">Tareas</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="text-gray-600">Nueva tarea asignada</label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notifications[task_assigned]" class="sr-only peer" {{ $settings->notifications['task_assigned'] ?? true ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="text-gray-600">Tarea próxima a vencer</label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notifications[task_due]" class="sr-only peer" {{ $settings->notifications['task_due'] ?? true ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Proyectos -->
                    <div class="border-b pb-4">
                        <h3 class="text-gray-700 font-medium mb-3">Proyectos</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="text-gray-600">Nuevo proyecto asignado</label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notifications[project_assigned]" class="sr-only peer" {{ $settings->notifications['project_assigned'] ?? true ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="text-gray-600">Actualización de progreso</label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notifications[project_progress]" class="sr-only peer" {{ $settings->notifications['project_progress'] ?? true ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Recordatorios -->
                    <div class="border-b pb-4">
                        <h3 class="text-gray-700 font-medium mb-3">Recordatorios</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="text-gray-600">Nuevo recordatorio</label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notifications[reminder_created]" class="sr-only peer" {{ $settings->notifications['reminder_created'] ?? true ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="text-gray-600">Recordatorio próximo</label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notifications[reminder_due]" class="sr-only peer" {{ $settings->notifications['reminder_due'] ?? true ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Cursos -->
                    <div>
                        <h3 class="text-gray-700 font-medium mb-3">Cursos</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="text-gray-600">Nuevo curso asignado</label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notifications[course_assigned]" class="sr-only peer" {{ $settings->notifications['course_assigned'] ?? true ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center justify-between">
                                <label class="text-gray-600">Actualizaciones del curso</label>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="notifications[course_updates]" class="sr-only peer" {{ $settings->notifications['course_updates'] ?? true ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('notifications.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 