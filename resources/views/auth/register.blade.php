<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Study Tracker</title>
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
        .strength-bar {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md animate-slide-up">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="inline-block bg-gray-800 bg-opacity-50 rounded-full p-4 mb-4 glow">
                <span class="text-6xl">📚</span>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Join Study Tracker</h1>
            <p class="text-green-400 text-lg">Start tracking your academic success</p>
        </div>

        <!-- Register Card -->
        <div class="bg-gray-800 bg-opacity-90 backdrop-blur-sm rounded-2xl p-8 border border-green-500 border-opacity-30 glow">
            <h2 class="text-2xl font-bold text-green-400 mb-6 text-center">
                <i class="fas fa-user-plus mr-2"></i>
                Create Account
            </h2>

            <!-- Errors -->
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-500 bg-opacity-20 border border-red-500 rounded-lg text-red-400 text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-5">
                    <label for="name" class="block text-green-400 font-semibold mb-2">
                        <i class="fas fa-user mr-2"></i>
                        Full Name
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        required 
                        autofocus
                        autocomplete="name"
                        class="w-full bg-gray-900 bg-opacity-50 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 input-glow transition"
                        placeholder="John Doe"
                    >
                </div>

                <!-- Email -->
                <div class="mb-5">
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
                        autocomplete="username"
                        class="w-full bg-gray-900 bg-opacity-50 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 input-glow transition"
                        placeholder="your.email@example.com"
                    >
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label for="password" class="block text-green-400 font-semibold mb-2">
                        <i class="fas fa-lock mr-2"></i>
                        Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            required
                            autocomplete="new-password"
                            oninput="checkPasswordStrength()"
                            class="w-full bg-gray-900 bg-opacity-50 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 input-glow transition"
                            placeholder="Create a strong password"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password', 'toggleIcon1')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-green-400 transition"
                        >
                            <i class="fas fa-eye" id="toggleIcon1"></i>
                        </button>
                    </div>
                    <!-- Password Strength Indicator -->
                    <div class="mt-2 flex gap-1">
                        <div class="strength-bar flex-1 bg-gray-700" id="strength1"></div>
                        <div class="strength-bar flex-1 bg-gray-700" id="strength2"></div>
                        <div class="strength-bar flex-1 bg-gray-700" id="strength3"></div>
                        <div class="strength-bar flex-1 bg-gray-700" id="strength4"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1" id="strengthText">Enter password to see strength</p>
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-green-400 font-semibold mb-2">
                        <i class="fas fa-lock mr-2"></i>
                        Confirm Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required
                            autocomplete="new-password"
                            class="w-full bg-gray-900 bg-opacity-50 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 input-glow transition"
                            placeholder="Re-enter your password"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password_confirmation', 'toggleIcon2')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-green-400 transition"
                        >
                            <i class="fas fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                </div>

                <!-- Register Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-gray-900 font-bold py-3 rounded-lg transition transform hover:scale-105 hover:shadow-xl"
                >
                    <i class="fas fa-rocket mr-2"></i>
                    Create Account
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-gray-400">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-green-400 hover:text-green-300 font-semibold transition">
                        Sign in here
                        <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </p>
            </div>
        </div>

        <!-- Back to Home -->
        <div class="text-center mt-6">
            <a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition">
                <i class="fas fa-home mr-2"></i>
                Back to Home
            </a>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBars = [
                document.getElementById('strength1'),
                document.getElementById('strength2'),
                document.getElementById('strength3'),
                document.getElementById('strength4')
            ];
            const strengthText = document.getElementById('strengthText');

            // Reset
            strengthBars.forEach(bar => {
                bar.style.backgroundColor = '#374151';
            });

            if (password.length === 0) {
                strengthText.textContent = 'Enter password to see strength';
                strengthText.className = 'text-xs text-gray-400 mt-1';
                return;
            }

            let strength = 0;

            // Length check
            if (password.length >= 8) strength++;
            if (password.length >= 12) strength++;

            // Complexity checks
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;

            // Cap at 4
            strength = Math.min(strength, 4);

            // Update bars
            const colors = ['#ef4444', '#f59e0b', '#eab308', '#22c55e'];
            const texts = ['Weak', 'Fair', 'Good', 'Strong'];
            const textColors = ['text-red-400', 'text-orange-400', 'text-yellow-400', 'text-green-400'];

            for (let i = 0; i < strength; i++) {
                strengthBars[i].style.backgroundColor = colors[strength - 1];
            }

            strengthText.textContent = texts[strength - 1] + ' password';
            strengthText.className = 'text-xs mt-1 ' + textColors[strength - 1];
        }
    </script>
</body>
</html>