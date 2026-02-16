<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Study Tracker</title>
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
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }
        .animate-pulse-slow {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md animate-slide-up">
        <!-- Logo and Title -->
        <div class="text-center mb-8">
            <div class="inline-block bg-gray-800 bg-opacity-50 rounded-full p-4 mb-4 glow animate-pulse-slow">
                <span class="text-6xl">🔑</span>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Reset Password</h1>
            <p class="text-green-400 text-lg">Create a new secure password</p>
        </div>

        <!-- Reset Password Card -->
        <div class="bg-gray-800 bg-opacity-90 backdrop-blur-sm rounded-2xl p-8 border border-green-500 border-opacity-30 glow">
            
            <!-- Info Message -->
            <div class="mb-6 p-4 bg-blue-500 bg-opacity-20 border border-blue-500 rounded-lg text-blue-400 text-sm">
                <i class="fas fa-shield-alt mr-2"></i>
                Choose a strong password to keep your account secure.
            </div>

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

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token (Hidden) -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email (Read-only) -->
                <div class="mb-5">
                    <label for="email" class="block text-green-400 font-semibold mb-2">
                        <i class="fas fa-envelope mr-2"></i>
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $request->email) }}"
                        required 
                        autofocus
                        autocomplete="username"
                        readonly
                        class="w-full bg-gray-900 bg-opacity-50 border border-gray-600 rounded-lg px-4 py-3 text-gray-400 cursor-not-allowed"
                    >
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-lock mr-1"></i>
                        Email cannot be changed during password reset
                    </p>
                </div>

                <!-- New Password -->
                <div class="mb-5">
                    <label for="password" class="block text-green-400 font-semibold mb-2">
                        <i class="fas fa-key mr-2"></i>
                        New Password
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
                            placeholder="Enter a strong password"
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
                    <p class="text-xs text-gray-400 mt-1" id="strengthText">Password strength will be shown here</p>

                    <!-- Password Requirements -->
                    <div class="mt-3 p-3 bg-gray-900 bg-opacity-50 rounded text-xs">
                        <p class="text-gray-400 mb-2 font-semibold">
                            <i class="fas fa-info-circle mr-1"></i>
                            Password must contain:
                        </p>
                        <ul class="space-y-1 text-gray-500">
                            <li id="req-length" class="flex items-center">
                                <i class="fas fa-circle text-xs mr-2"></i>
                                At least 8 characters
                            </li>
                            <li id="req-letter" class="flex items-center">
                                <i class="fas fa-circle text-xs mr-2"></i>
                                Uppercase and lowercase letters
                            </li>
                            <li id="req-number" class="flex items-center">
                                <i class="fas fa-circle text-xs mr-2"></i>
                                At least one number
                            </li>
                            <li id="req-special" class="flex items-center">
                                <i class="fas fa-circle text-xs mr-2"></i>
                                Special character (recommended)
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Confirm New Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-green-400 font-semibold mb-2">
                        <i class="fas fa-lock mr-2"></i>
                        Confirm New Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            required
                            autocomplete="new-password"
                            oninput="checkPasswordMatch()"
                            class="w-full bg-gray-900 bg-opacity-50 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 input-glow transition"
                            placeholder="Re-enter your new password"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword('password_confirmation', 'toggleIcon2')"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-green-400 transition"
                        >
                            <i class="fas fa-eye" id="toggleIcon2"></i>
                        </button>
                    </div>
                    <p class="text-xs mt-1" id="matchText"></p>
                </div>

                <!-- Reset Button -->
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-gray-900 font-bold py-3 rounded-lg transition transform hover:scale-105 hover:shadow-xl"
                >
                    <i class="fas fa-check-circle mr-2"></i>
                    Reset Password
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

        <!-- Security Notice -->
        <div class="mt-6 text-center text-sm text-gray-400">
            <i class="fas fa-shield-alt mr-1"></i>
            Your password will be encrypted and stored securely
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
                strengthText.textContent = 'Password strength will be shown here';
                strengthText.className = 'text-xs text-gray-400 mt-1';
                updateRequirements(password);
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
            const texts = ['Weak - Try adding more characters', 'Fair - Add numbers and symbols', 'Good - Almost there!', 'Strong - Excellent password!'];
            const textColors = ['text-red-400', 'text-orange-400', 'text-yellow-400', 'text-green-400'];

            for (let i = 0; i < strength; i++) {
                strengthBars[i].style.backgroundColor = colors[strength - 1];
            }

            strengthText.textContent = texts[strength - 1];
            strengthText.className = 'text-xs mt-1 ' + textColors[strength - 1];

            // Update requirements
            updateRequirements(password);
            
            // Check match when typing new password
            checkPasswordMatch();
        }

        function updateRequirements(password) {
            const reqLength = document.getElementById('req-length');
            const reqLetter = document.getElementById('req-letter');
            const reqNumber = document.getElementById('req-number');
            const reqSpecial = document.getElementById('req-special');

            // Length
            if (password.length >= 8) {
                reqLength.classList.add('text-green-400');
                reqLength.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                reqLength.classList.remove('text-green-400');
                reqLength.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }

            // Letters
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
                reqLetter.classList.add('text-green-400');
                reqLetter.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                reqLetter.classList.remove('text-green-400');
                reqLetter.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }

            // Number
            if (/[0-9]/.test(password)) {
                reqNumber.classList.add('text-green-400');
                reqNumber.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                reqNumber.classList.remove('text-green-400');
                reqNumber.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }

            // Special
            if (/[^A-Za-z0-9]/.test(password)) {
                reqSpecial.classList.add('text-green-400');
                reqSpecial.querySelector('i').classList.replace('fa-circle', 'fa-check-circle');
            } else {
                reqSpecial.classList.remove('text-green-400');
                reqSpecial.querySelector('i').classList.replace('fa-check-circle', 'fa-circle');
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            const matchText = document.getElementById('matchText');

            if (confirmation.length === 0) {
                matchText.textContent = '';
                return;
            }

            if (password === confirmation) {
                matchText.textContent = '✓ Passwords match';
                matchText.className = 'text-xs mt-1 text-green-400';
            } else {
                matchText.textContent = '✗ Passwords do not match';
                matchText.className = 'text-xs mt-1 text-red-400';
            }
        }
    </script>
</body>
</html>