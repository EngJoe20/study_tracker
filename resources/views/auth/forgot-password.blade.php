<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Study Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .gradient-bg {
            background: linear-gradient(-45deg, #1a1a2e, #16213e, #0f3460, #533483);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        .glow {
            box-shadow: 0 0 30px rgba(0, 255, 65, 0.3);
        }
        .input-glow:focus {
            box-shadow: 0 0 20px rgba(0, 255, 65, 0.2);
            border-color: #00ff41;
        }
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md animate-slide-up">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="inline-block bg-gray-800 bg-opacity-50 rounded-full p-4 mb-4 glow">
                <span class="text-6xl">🔐</span>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Forgot Password?</h1>
            <p class="text-green-400">No worries, we'll send you reset instructions</p>
        </div>

        <!-- Reset Card -->
        <div class="bg-gray-800 bg-opacity-90 backdrop-blur-sm rounded-2xl p-8 border border-green-500 border-opacity-30 glow">
            
            <!-- Info Message -->
            <div class="mb-6 p-4 bg-blue-500 bg-opacity-20 border border-blue-500 rounded-lg text-blue-400 text-sm">
                <i class="fas fa-info-circle mr-2"></i>
                Enter your email address and we'll send you a link to reset your password.
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 p-4 bg-green-500 bg-opacity-20 border border-green-500 rounded-lg text-green-400 text-sm">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('status') }}
                </div>
            @endif

            <!-- Errors -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-500 bg-opacity-20 border border-red-500 rounded-lg text-red-400 text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-green-400 font-semibold mb-2">
                        <i class="fas fa-envelope mr-2"></i>
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
                        class="w-full bg-gray-900 bg-opacity-50 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 input-glow transition"
                        placeholder="your.email@example.com"
                    >
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-gray-900 font-bold py-3 rounded-lg transition transform hover:scale-105 hover:shadow-xl"
                >
                    <i class="fas fa-paper-plane mr-2"></i>
                    Send Reset Link
                </button>
            </form>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-gray-400 hover:text-green-400 transition inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Login
                </a>
            </div>
        </div>
    </div>

</body>
</html>