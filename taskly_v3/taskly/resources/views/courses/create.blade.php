@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Nuevo Curso</h1>
        <form action="{{ route('courses.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6">
            @csrf
            <!-- Nombre -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="name" id="name" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            </div>
            <!-- Código -->
            <div class="mb-4">
                <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Código</label>
                <input type="text" name="code" id="code" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            </div>
            <!-- Profesor -->
            <div class="mb-4">
                <label for="professor" class="block text-sm font-medium text-gray-700 mb-1">Profesor</label>
                <input type="text" name="professor" id="professor" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            </div>
            <!-- Horario -->
            <div class="mb-4">
                <label for="schedule" class="block text-sm font-medium text-gray-700 mb-1">Horario</label>
                <input type="text" name="schedule" id="schedule" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            </div>
            <!-- Créditos -->
            <div class="mb-4">
                <label for="credits" class="block text-sm font-medium text-gray-700 mb-1">Créditos</label>
                <input type="number" name="credits" id="credits" min="1" max="10" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            </div>
            <!-- Descripción -->
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" id="description" rows="3" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200"></textarea>
            </div>
            <!-- Color -->
            <div class="mb-4">
                <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                <input type="color" name="color" id="color" value="#3B82F6" class="w-16 h-10 rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200">
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar Curso</button>
        </form>
    </div>
</div>
@endsection 