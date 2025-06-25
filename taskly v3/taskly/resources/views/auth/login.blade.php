<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taskly | Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-study {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.3);
        }
        .shake {
            animation: shake 0.5s;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-5px); }
            40%, 80% { transform: translateX(5px); }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-4xl flex flex-col md:flex-row rounded-xl overflow-hidden shadow-2xl">
        <!-- Left Side - Branding -->
        <div class="bg-study text-white p-10 flex flex-col justify-center items-center md:w-1/2">
            <div class="text-center">
                <div class="flex justify-center mb-6">
                    <div class="bg-white bg-opacity-20 rounded-full p-4">
                        <i class="fas fa-tasks text-4xl"></i>
                    </div>
                </div>
                <h1 class="text-3xl font-bold mb-2">Taskly</h1>
                <p class="opacity-90 mb-6">El asistente perfecto para organizar tus estudios</p>
                
                <div class="space-y-4 text-left">
                    <div class="flex items-center">
                        <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                            <i class="fas fa-book text-sm"></i>
                        </div>
                        <span>Administra tus proyectos universitarios</span>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                            <i class="fas fa-calendar-check text-sm"></i>
                        </div>
                        <span>Organiza tus tareas y deadlines</span>
                    </div>
                    <div class="flex items-center">
                        <div class="bg-white bg-opacity-20 rounded-full p-2 mr-3">
                            <i class="fas fa-bell text-sm"></i>
                        </div>
                        <span>Recordatorios inteligentes</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Right Side - Login Form -->
        <div class="bg-white p-10 md:w-1/2 flex flex-col justify-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Iniciar Sesión</h2>
            <p class="text-gray-600 mb-8">Ingresa a tu cuenta para administrar tus proyectos</p>
            
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Correo Universitario</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="email" name="email" required 
                            class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 input-focus transition duration-300 @error('email') border-red-500 @enderror"
                            placeholder="tucorreo@universidad.edu" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password" required 
                            class="pl-10 w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-indigo-500 input-focus transition duration-300 @error('password') border-red-500 @enderror"
                            placeholder="••••••••">
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="far fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Recuérdame</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500">
                            ¿Olvidaste tu contraseña?
                        </a>
                    @endif
                </div>
                
                <div>
                    <button type="submit" 
                        class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-medium py-3 px-4 rounded-lg shadow-md transition duration-300 transform hover:scale-105">
                        Iniciar Sesión
                    </button>
                </div>
                
                <div class="text-center text-sm">
                    <p class="text-gray-600">¿Nuevo en Taskly? 
                        <a href="{{ route('register') }}" class="text-indigo-600 font-medium hover:text-indigo-500">Regístrate aquí</a>
                    </p>
                </div>
            </form>
            
            <div class="mt-8 border-t border-gray-200 pt-6">
                <p class="text-xs text-gray-500 text-center">Al iniciar sesión aceptas nuestros 
                    <a href="#" class="text-indigo-600 hover:underline">Términos de servicio</a> y 
                    <a href="#" class="text-indigo-600 hover:underline">Política de privacidad</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            
            // Toggle password visibility
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="far fa-eye text-gray-400 hover:text-gray-600 cursor-pointer"></i>' 
                                                    : '<i class="far fa-eye-slash text-gray-400 hover:text-gray-600 cursor-pointer"></i>';
            });
        });
    </script>
</body>
</html>
