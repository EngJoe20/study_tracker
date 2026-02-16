<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Study Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Programmer Theme */
        .theme-programmer {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
            color: #00ff41;
        }
        .theme-programmer .card {
            background: linear-gradient(135deg, #16213e 0%, #0f3460 100%);
            border: 1px solid rgba(0, 255, 65, 0.2);
        }
        .theme-programmer .card:hover {
            border-color: rgba(0, 255, 65, 0.4);
            box-shadow: 0 4px 20px rgba(0, 255, 65, 0.1);
        }
        .theme-programmer .btn-primary {
            background: linear-gradient(135deg, #00ff41 0%, #00cc33 100%);
            color: #1a1a2e;
            font-weight: 700;
        }
        .theme-programmer .btn-primary:hover {
            background: linear-gradient(135deg, #00cc33 0%, #00aa2a 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 255, 65, 0.3);
        }
        .theme-programmer .nav-link:hover {
            color: #9d4edd;
        }

        /* Girls Theme */
        .theme-girls {
            background: linear-gradient(135deg, #fff0f6 0%, #ffe6f0 100%);
            color: #d91b5c;
        }
        .theme-girls .card {
            background: linear-gradient(135deg, #ffe6f0 0%, #ffd5e5 100%);
            border: 2px solid #ff69b4;
        }
        .theme-girls .card:hover {
            border-color: #ff1493;
            box-shadow: 0 4px 20px rgba(255, 20, 147, 0.2);
        }
        .theme-girls .btn-primary {
            background: linear-gradient(135deg, #ff1493 0%, #ff69b4 100%);
            color: white;
            font-weight: 700;
        }
        .theme-girls .btn-primary:hover {
            background: linear-gradient(135deg, #d91b5c 0%, #ff1493 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 20, 147, 0.4);
        }

        /* Sports Theme */
        .theme-sports {
            background: linear-gradient(135deg, #1a2634 0%, #2d3e50 100%);
            color: #f7931e;
        }
        .theme-sports .card {
            background: linear-gradient(135deg, #2d3e50 0%, #3d4e60 100%);
            border: 2px solid #ff6b35;
        }
        .theme-sports .card:hover {
            border-color: #f7931e;
            box-shadow: 0 4px 20px rgba(247, 147, 30, 0.2);
        }
        .theme-sports .btn-primary {
            background: linear-gradient(135deg, #f7931e 0%, #ff6b35 100%);
            color: #1a2634;
            font-weight: 700;
        }
        .theme-sports .btn-primary:hover {
            background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(247, 147, 30, 0.4);
        }

        /* Common Styles */
        .progress-bar {
            height: 24px;
            border-radius: 12px;
            overflow: hidden;
            background-color: rgba(255, 255, 255, 0.1);
            position: relative;
        }
        .progress-fill {
            height: 100%;
            transition: width 0.5s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .btn {
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
            display: inline-block;
            cursor: pointer;
        }
        .card {
            transition: all 0.3s;
            border-radius: 12px;
            padding: 20px;
        }
        .stat-card {
            text-align: center;
        }
        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1;
        }
        .stat-label {
            font-size: 0.875rem;
            opacity: 0.75;
            margin-top: 8px;
        }
        
        /* Animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-slide-in {
            animation: slideIn 0.4s ease-out;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.1);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="theme-{{ auth()->user()->theme ?? 'programmer' }} min-h-screen">
    
    <!-- Navigation -->
    <nav class="card mb-6 sticky top-0 z-50" style="border-radius: 0;">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 hover:opacity-80 transition">
                    <span class="text-3xl">📚</span>
                    <span class="text-2xl font-bold">Study Tracker</span>
                </a>
            </div>
            
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('dashboard') }}" class="nav-link hover:opacity-75 transition {{ request()->routeIs('dashboard') ? 'font-bold' : '' }}">
                    <i class="fas fa-home mr-1"></i> Dashboard
                </a>
                <a href="{{ route('subjects.index') }}" class="nav-link hover:opacity-75 transition {{ request()->routeIs('subjects.*') ? 'font-bold' : '' }}">
                    <i class="fas fa-book mr-1"></i> Subjects
                </a>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Theme Selector -->
                <form action="{{ route('theme.update') }}" method="POST" class="inline">
                    @csrf
                    <select name="theme" onchange="this.form.submit()" class="bg-transparent border rounded px-3 py-2 cursor-pointer">
                        <option value="programmer" {{ auth()->user()->theme === 'programmer' ? 'selected' : '' }}>🖥️ Programmer</option>
                        <option value="girls" {{ auth()->user()->theme === 'girls' ? 'selected' : '' }}>👧 Girls</option>
                        <option value="sports" {{ auth()->user()->theme === 'sports' ? 'selected' : '' }}>⚽ Sports</option>
                    </select>
                </form>

                <!-- User Menu -->
                <div class="relative group">
                    <button class="flex items-center space-x-2 hover:opacity-75 transition">
                        <i class="fas fa-user-circle text-2xl"></i>
                        <span class="hidden md:inline">{{ auth()->user()->name }}</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 card opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                        <a href="#" class="block px-4 py-2 hover:opacity-75">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 hover:opacity-75">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 pb-8">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="card mb-6 border-green-500 bg-green-500 bg-opacity-20 animate-slide-in">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-2xl mr-3"></i>
                        <span class="font-semibold">{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="hover:opacity-75">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="card mb-6 border-red-500 bg-red-500 bg-opacity-20 animate-slide-in">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-2xl mr-3"></i>
                        <span class="font-semibold">{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="hover:opacity-75">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="card mb-6 border-red-500 bg-red-500 bg-opacity-20 animate-slide-in">
                <div class="flex items-start">
                    <i class="fas fa-exclamation-triangle text-2xl mr-3 mt-1"></i>
                    <div class="flex-1">
                        <p class="font-semibold mb-2">Please fix the following errors:</p>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="container mx-auto px-4 py-6 text-center opacity-75 text-sm">
        <p>&copy; {{ date('Y') }} Study Tracker. Made with ❤️ for students.</p>
    </footer>

</body>
</html>