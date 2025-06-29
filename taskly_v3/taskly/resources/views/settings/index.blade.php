@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <!-- Encabezado -->
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Configuración de la Aplicación</h1>
            <p class="text-gray-600 mt-2">Gestiona la configuración general de Taskly</p>
        </div>

        <!-- Grid de Configuración -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Configuración General -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <i class="fas fa-cog text-blue-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-medium text-gray-800 ml-4">General</h2>
                </div>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('settings.general') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Información de la Aplicación
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.appearance') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Apariencia
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.localization') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Localización
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Configuración de Usuarios -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <i class="fas fa-users text-green-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-medium text-gray-800 ml-4">Usuarios</h2>
                </div>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('settings.users') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Gestión de Usuarios
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.roles') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Roles y Permisos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.invitations') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Invitaciones
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Configuración de Notificaciones -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <i class="fas fa-bell text-purple-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-medium text-gray-800 ml-4">Notificaciones</h2>
                </div>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('settings.notifications') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Configuración de Notificaciones
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.email') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Plantillas de Email
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Configuración de Integración -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <i class="fas fa-plug text-yellow-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-medium text-gray-800 ml-4">Integración</h2>
                </div>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('settings.integrations') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Servicios Externos
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.api') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            API y Webhooks
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Configuración de Seguridad -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-red-100 rounded-lg">
                        <i class="fas fa-shield-alt text-red-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-medium text-gray-800 ml-4">Seguridad</h2>
                </div>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('settings.security') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Configuración de Seguridad
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.backup') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Copias de Seguridad
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Configuración de Facturación -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-4">
                    <div class="p-3 bg-indigo-100 rounded-lg">
                        <i class="fas fa-credit-card text-indigo-600 text-xl"></i>
                    </div>
                    <h2 class="text-lg font-medium text-gray-800 ml-4">Facturación</h2>
                </div>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('settings.billing') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Planes y Suscripciones
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('settings.payment') }}" class="flex items-center text-gray-600 hover:text-blue-600">
                            <i class="fas fa-chevron-right text-sm mr-2"></i>
                            Métodos de Pago
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Estado del Sistema -->
        <div class="mt-8 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-medium text-gray-800 mb-4">Estado del Sistema</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <i class="fas fa-server text-green-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Estado del Servidor</p>
                            <p class="text-lg font-medium text-gray-800">Operativo</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-database text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Base de Datos</p>
                            <p class="text-lg font-medium text-gray-800">Conectada</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <i class="fas fa-envelope text-purple-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Servicio de Email</p>
                            <p class="text-lg font-medium text-gray-800">Activo</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm text-gray-600">Última Actualización</p>
                            <p class="text-lg font-medium text-gray-800">{{ now()->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 