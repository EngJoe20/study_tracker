<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Tracker - Track Your Academic Progress</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            box-shadow: 0 0 20px rgba(0, 255, 65, 0.3);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen text-white">
    
    <!-- Navigation -->
    <nav class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="text-4xl">📚</span>
                <h1 class="text-2xl font-bold text-green-400">Study Tracker</h1>
            </div>
            <div class="space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-green-500 hover:bg-green-400 text-gray-900 font-bold px-6 py-2 rounded-lg transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-green-400 hover:text-green-300 font-semibold transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-400 text-gray-900 font-bold px-6 py-2 rounded-lg transition">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="container mx-auto px-4 py-20">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-6xl font-bold mb-6 leading-tight">
                Track Your Study Progress
                <span class="text-green-400">Like a Pro</span>
            </h1>
            <p class="text-xl text-gray-300 mb-10">
                The ultimate academic progress tracker built for students who want to stay organized, 
                track real progress, and achieve their study goals efficiently.
            </p>
            <div class="flex justify-center space-x-4">
                @guest
                    <a href="{{ route('register') }}" class="bg-green-500 hover:bg-green-400 text-gray-900 font-bold px-8 py-4 rounded-lg text-lg glow transition transform hover:scale-105">
                        Start Tracking Free
                    </a>
                    <a href="#features" class="bg-gray-700 hover:bg-gray-600 text-white font-bold px-8 py-4 rounded-lg text-lg transition transform hover:scale-105">
                        Learn More
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="bg-green-500 hover:bg-green-400 text-gray-900 font-bold px-8 py-4 rounded-lg text-lg glow transition transform hover:scale-105">
                        Go to Dashboard
                    </a>
                @endguest
            </div>
        </div>

        <!-- Demo Screenshot/Preview -->
        <div class="mt-16 max-w-5xl mx-auto">
            <div class="bg-gray-800 border-4 border-green-500 rounded-xl p-8 glow">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-900 p-6 rounded-lg border border-green-500">
                        <div class="text-4xl mb-3">📖</div>
                        <h3 class="text-xl font-bold mb-2 text-green-400">Smart Progress</h3>
                        <p class="text-gray-400">Track chapters across multiple lectures with real coverage percentages</p>
                    </div>
                    <div class="bg-gray-900 p-6 rounded-lg border border-purple-500">
                        <div class="text-4xl mb-3">🎓</div>
                        <h3 class="text-xl font-bold mb-2 text-purple-400">Flexible Tracking</h3>
                        <p class="text-gray-400">Lectures, sections, labs, and projects all in one place</p>
                    </div>
                    <div class="bg-gray-900 p-6 rounded-lg border border-blue-500">
                        <div class="text-4xl mb-3">📊</div>
                        <h3 class="text-xl font-bold mb-2 text-blue-400">Weighted Progress</h3>
                        <p class="text-gray-400">Customize how each component affects your overall grade</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div id="features" class="container mx-auto px-4 py-20">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold mb-4">Why Students Love Study Tracker</h2>
            <p class="text-xl text-gray-300">Everything you need to stay on top of your studies</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
            <!-- Feature 1 -->
            <div class="bg-gray-800 bg-opacity-50 p-8 rounded-xl border border-gray-700 hover:border-green-500 transition">
                <div class="text-5xl mb-4">✅</div>
                <h3 class="text-2xl font-bold mb-3 text-green-400">Real-Life Progress</h3>
                <p class="text-gray-300">Not just simple completion flags. Track partial coverage and multi-lecture chapters like in real studying.</p>
            </div>

            <!-- Feature 2 -->
            <div class="bg-gray-800 bg-opacity-50 p-8 rounded-xl border border-gray-700 hover:border-purple-500 transition">
                <div class="text-5xl mb-4">🎯</div>
                <h3 class="text-2xl font-bold mb-3 text-purple-400">Custom Weights</h3>
                <p class="text-gray-300">Define how much chapters, labs, sections, and projects contribute to your final grade.</p>
            </div>

            <!-- Feature 3 -->
            <div class="bg-gray-800 bg-opacity-50 p-8 rounded-xl border border-gray-700 hover:border-blue-500 transition">
                <div class="text-5xl mb-4">🚀</div>
                <h3 class="text-2xl font-bold mb-3 text-blue-400">Project Tracking</h3>
                <p class="text-gray-300">Monitor your project progress separately with deadlines and completion percentages.</p>
            </div>

            <!-- Feature 4 -->
            <div class="bg-gray-800 bg-opacity-50 p-8 rounded-xl border border-gray-700 hover:border-yellow-500 transition">
                <div class="text-5xl mb-4">🎨</div>
                <h3 class="text-2xl font-bold mb-3 text-yellow-400">Themed Interface</h3>
                <p class="text-gray-300">Choose from Programmer, Girls, or Sports themes to match your style.</p>
            </div>

            <!-- Feature 5 -->
            <div class="bg-gray-800 bg-opacity-50 p-8 rounded-xl border border-gray-700 hover:border-red-500 transition">
                <div class="text-5xl mb-4">📅</div>
                <h3 class="text-2xl font-bold mb-3 text-red-400">Timeline View</h3>
                <p class="text-gray-300">See all your lectures, sections, and labs organized by date.</p>
            </div>

            <!-- Feature 6 -->
            <div class="bg-gray-800 bg-opacity-50 p-8 rounded-xl border border-gray-700 hover:border-pink-500 transition">
                <div class="text-5xl mb-4">📈</div>
                <h3 class="text-2xl font-bold mb-3 text-pink-400">Visual Progress</h3>
                <p class="text-gray-300">Beautiful progress bars and statistics to keep you motivated.</p>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="container mx-auto px-4 py-20">
        <div class="bg-gradient-to-r from-green-600 to-green-500 rounded-2xl p-12 text-center glow max-w-4xl mx-auto">
            <h2 class="text-4xl font-bold mb-4 text-gray-900">Ready to Level Up Your Study Game?</h2>
            <p class="text-xl mb-8 text-gray-800">Join students who are achieving their academic goals with Study Tracker</p>
            @guest
                <a href="{{ route('register') }}" class="bg-gray-900 hover:bg-gray-800 text-green-400 font-bold px-10 py-4 rounded-lg text-lg transition transform hover:scale-105 inline-block">
                    Create Free Account →
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="bg-gray-900 hover:bg-gray-800 text-green-400 font-bold px-10 py-4 rounded-lg text-lg transition transform hover:scale-105 inline-block">
                    Go to Dashboard →
                </a>
            @endguest
        </div>
    </div>

    <!-- Footer -->
    <footer class="container mx-auto px-4 py-8 text-center text-gray-400 border-t border-gray-800">
        <p>&copy; {{ date('Y') }} Study Tracker. Built with ❤️ for students.</p>
    </footer>

</body>
</html>