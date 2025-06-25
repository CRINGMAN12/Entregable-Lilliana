@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Encabezado -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Configuración General</h1>
            <p class="text-gray-600 mt-2">Gestiona la información básica de la aplicación</p>
        </div>

        <!-- Formulario de Configuración -->
        <div class="bg-white rounded-lg shadow-md">
            <form action="{{ route('settings.general.update') }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <!-- Información de la Aplicación -->
                <div class="mb-8">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Información de la Aplicación</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nombre de la Aplicación</label>
                            <input type="text" name="app_name" value="{{ config('app.name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">URL de la Aplicación</label>
                            <input type="url" name="app_url" value="{{ config('app.url') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                    </div>
                </div>

                <!-- Configuración de Contacto -->
                <div class="mb-8">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Información de Contacto</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email de Soporte</label>
                            <input type="email" name="support_email" value="{{ config('app.support_email') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teléfono de Soporte</label>
                            <input type="tel" name="support_phone" value="{{ config('app.support_phone') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                    </div>
                </div>

                <!-- Configuración de Registro -->
                <div class="mb-8">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Configuración de Registro</h2>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="allow_registration" value="1" {{ config('app.allow_registration') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-700">
                                Permitir registro de nuevos usuarios
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" name="require_email_verification" value="1" {{ config('app.require_email_verification') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-700">
                                Requerir verificación de email
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Configuración de Sesión -->
                <div class="mb-8">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Configuración de Sesión</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tiempo de Sesión (minutos)</label>
                            <input type="number" name="session_lifetime" value="{{ config('session.lifetime') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tiempo de Recordar Sesión (días)</label>
                            <input type="number" name="remember_lifetime" value="{{ config('session.remember_lifetime') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
                        </div>
                    </div>
                </div>

                <!-- Configuración de Mantenimiento -->
                <div class="mb-8">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">Modo Mantenimiento</h2>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <input type="checkbox" name="maintenance_mode" value="1" {{ app()->isDownForMaintenance() ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-700">
                                Activar modo mantenimiento
                            </label>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Mensaje de Mantenimiento</label>
                            <textarea name="maintenance_message" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">{{ config('app.maintenance_message') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('settings.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-6 py-2 rounded-lg">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Toggle de modo mantenimiento
document.querySelector('input[name="maintenance_mode"]').addEventListener('change', function(e) {
    if (e.target.checked) {
        if (!confirm('¿Estás seguro de que deseas activar el modo mantenimiento? Esto hará que la aplicación no esté disponible para los usuarios.')) {
            e.target.checked = false;
        }
    }
});
</script>
@endpush
@endsection 