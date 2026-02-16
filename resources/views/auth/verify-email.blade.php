<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email - Study Tracker</title>
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
        .animate-slide-up {
            animation: slideUp 0.6s ease-out;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-md animate-slide-up">
        <div class="text-center mb-8">
            <div class="inline-block bg-gray-800 bg-opacity-50 rounded-full p-4 mb-4 glow">
                <span class="text-6xl">📧</span>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Verify Your Email</h1>
            <p class="text-green-400">One more step to get started</p>
        </div>

        <div class="bg-gray-800 bg-opacity-90 backdrop-blur-sm rounded-2xl p-8 border border-green-500 border-opacity-30 glow">
            
            <div class="mb-6 p-4 bg-blue-500 bg-opacity-20 border border-blue-500 rounded-lg text-blue-400 text-sm">
                <i class="fas fa-info-circle mr-2"></i>
                Thanks for signing up! Before getting started, please verify your email address by clicking the link we just sent you.
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-6 p-4 bg-green-500 bg-opacity-20 border border-green-500 rounded-lg text-green-400 text-sm">
                    <i class="fas fa-check-circle mr-2"></i>
                    A new verification link has been sent to your email address.
                </div>
            @endif

            <div class="flex flex-col gap-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-gray-900 font-bold py-3 rounded-lg transition transform hover:scale-105 hover:shadow-xl"
                    >
                        <i class="fas fa-paper-plane mr-2"></i>
                        Resend Verification Email
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button 
                        type="submit" 
                        class="w-full border border-gray-600 hover:border-red-500 text-gray-300 hover:text-red-400 font-semibold py-3 rounded-lg transition"
                    >
                        <i class="fas fa-sign-out-alt mr-2"></i>
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>