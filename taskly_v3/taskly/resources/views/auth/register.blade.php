<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly | Registro de Estudiante</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #6B73FF 0%, #000DFF 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .input-focus:focus {
            box-shadow: 0 0 0 2px rgba(107, 115, 255, 0.5);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row">
        <!-- Presentation Section -->
        <div class="md:w-1/2 gradient-bg text-white p-10 flex flex-col justify-center">
            <div class="text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold mb-4">Bienvenido a <span class="block">Taskly</span></h1>
                <p class="text-lg opacity-90 mb-6">Tu asistente personal para organizar tareas, proyectos y recordatorios académicos.</p>
                
                <div class="space-y-4 mb-8">
                    <div class="flex items-start">
                        <div class="bg-white bg-opacity-20 p-2 rounded-full mr-3 mt-1">
                            <i class="fas fa-tasks text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold">Gestión de Tareas</h3>
                            <p class="text-sm opacity-80">Organiza tus tareas por prioridad y fecha límite.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-white bg-opacity-20 p-2 rounded-full mr-3 mt-1">
                            <i class="fas fa-project-diagram text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold">Proyectos Académicos</h3>
                            <p class="text-sm opacity-80">Divide tus proyectos en etapas manejables.</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-white bg-opacity-20 p-2 rounded-full mr-3 mt-1">
                            <i class="fas fa-bell text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold">Recordatorios Inteligentes</h3>
                            <p class="text-sm opacity-80">Nunca más olvides una fecha importante.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center md:text-left mt-auto">
                <p class="text-sm opacity-80">¿Ya tienes una cuenta?</p>
                <a href="{{ route('login') }}" class="inline-block mt-2 px-6 py-2 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full font-medium transition-all">Iniciar Sesión</a>
            </div>
        </div>
        
        <!-- Registration Form -->
        <div class="md:w-1/2 p-10">
            <div class="text-center md:text-left mb-8">
                <h2 class="text-2xl font-bold gradient-text">Crear Cuenta</h2>
                <p class="text-gray-500 mt-1">Comienza a organizar tu vida académica hoy mismo.</p>
            </div>
            
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <div class="relative">
                            <input type="text" id="name" name="name" required 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none input-focus transition-all @error('name') border-red-500 @enderror"
                                   placeholder="Tus nombres" value="{{ old('name') }}">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                        </div>
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="lastname" class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                        <div class="relative">
                            <input type="text" id="lastname" name="lastname" required 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none input-focus transition-all @error('lastname') border-red-500 @enderror"
                                   placeholder="Tus apellidos" value="{{ old('lastname') }}">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                        </div>
                        @error('lastname')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                    <div class="relative">
                        <input type="email" id="email" name="email" required 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none input-focus transition-all @error('email') border-red-500 @enderror"
                               placeholder="tu@universidad.edu" value="{{ old('email') }}">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="institution" class="block text-sm font-medium text-gray-700 mb-1">Institución Educativa</label>
                    <div class="relative">
                        <input type="text" id="institution" name="institution" required 
                               class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none input-focus transition-all @error('institution') border-red-500 @enderror"
                               placeholder="Tu universidad o escuela" value="{{ old('institution') }}">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-university text-gray-400"></i>
                        </div>
                    </div>
                    @error('institution')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="career" class="block text-sm font-medium text-gray-700 mb-1">Carrera</label>
                        <div class="relative">
                            <select id="career" name="career" required 
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none input-focus transition-all appearance-none @error('career') border-red-500 @enderror">
                                <option value="" disabled {{ old('career') ? '' : 'selected' }}>Selecciona tu carrera</option>
                                <option value="ingenieria" {{ old('career') == 'ingenieria' ? 'selected' : '' }}>Ingeniería</option>
                                <option value="medicina" {{ old('career') == 'medicina' ? 'selected' : '' }}>Medicina</option>
                                <option value="derecho" {{ old('career') == 'derecho' ? 'selected' : '' }}>Derecho</option>
                                <option value="administracion" {{ old('career') == 'administracion' ? 'selected' : '' }}>Administración</option>
                                <option value="otro" {{ old('career') == 'otro' ? 'selected' : '' }}>Otra</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-graduation-cap text-gray-400"></i>
                            </div>
                        </div>
                        @error('career')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="semester" class="block text-sm font-medium text-gray-700 mb-1">Semestre</label>
                        <div class="relative">
                            <select id="semester" name="semester" required 
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none input-focus transition-all appearance-none @error('semester') border-red-500 @enderror">
                                <option value="" disabled {{ old('semester') ? '' : 'selected' }}>Selecciona tu semestre</option>
                                @for ($i = 1; $i <= 9; $i++)
                                    <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>{{ $i }}° Semestre</option>
                                @endfor
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-calendar-alt text-gray-400"></i>
                            </div>
                        </div>
                        @error('semester')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" required 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none input-focus transition-all @error('password') border-red-500 @enderror"
                                   placeholder="Mínimo 8 caracteres">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-eye-slash text-gray-400 cursor-pointer toggle-password" onclick="togglePassword('password', this)"></i>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i> La contraseña debe tener al menos 8 caracteres
                        </div>
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation" required 
                                   class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none input-focus transition-all"
                                   placeholder="Repite tu contraseña">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <i class="fas fa-eye-slash text-gray-400 cursor-pointer toggle-password" onclick="togglePassword('password_confirmation', this)"></i>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required 
                               class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="text-gray-700">
                            Acepto los <a href="#" class="text-blue-600 hover:underline">Términos de Servicio</a> y 
                            <a href="#" class="text-blue-600 hover:underline">Política de Privacidad</a>
                        </label>
                    </div>
                </div>
                
                <button type="submit" 
                        class="w-full gradient-bg text-white py-3 px-4 rounded-lg font-semibold hover:opacity-90 transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Crear Cuenta <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>
            
            <div class="mt-8">
                <h3 class="text-center text-sm text-gray-500 mb-3">O regístrate con</h3>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('auth.google') }}" class="p-2 border border-gray-300 rounded-full hover:bg-gray-50 transition-colors">
                        <i class="fab fa-google text-red-500"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Toggle password visibility
        function togglePassword(fieldId, icon) {
            const field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
                icon.classList.replace("fa-eye-slash", "fa-eye");
            } else {
                field.type = "password";
                icon.classList.replace("fa-eye", "fa-eye-slash");
            }
        }
    </script>
</body>
</html>
