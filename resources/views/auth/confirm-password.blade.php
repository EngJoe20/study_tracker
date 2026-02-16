<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password - Study Tracker</title>
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
        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md animate-slide-up">
        <div class="text-center mb-8">
            <div class="inline-block bg-gray-800 bg-opacity-50 rounded-full p-4 mb-4 glow">
                <span class="text-6xl">🔒</span>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Confirm Password</h1>
            <p class="text-green-400">Secure area - verification required</p>
        </div>

        <div class="bg-gray-800 bg-opacity-90 backdrop-blur-sm rounded-2xl p-8 border border-green-500 border-opacity-30 glow">
            
            <div class="mb-6 p-4 bg-yellow-500 bg-opacity-20 border border-yellow-500 rounded-lg text-yellow-400 text-sm">
                <i class="fas fa-shield-alt mr-2"></i>
                This is a secure area. Please confirm your password before continuing.
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-500 bg-opacity-20 border border-red-500 rounded-lg text-red-400 text-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="mb-6">
                    <label for="password" class="block text-green-400 font-semibold mb-2">
                        <i class="fas fa-lock mr-2"></i>
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        required
                        autocomplete="current-password"
                        class="w-full bg-gray-900 bg-opacity-50 border border-gray-600 rounded-lg px-4 py-3 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-500 input-glow transition"
                        placeholder="Enter your password"
                    >
                </div>

                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-gray-900 font-bold py-3 rounded-lg transition transform hover:scale-105 hover:shadow-xl"
                >
                    <i class="fas fa-check mr-2"></i>
                    Confirm
                </button>
            </form>
        </div>
    </div>

</body>
</html>