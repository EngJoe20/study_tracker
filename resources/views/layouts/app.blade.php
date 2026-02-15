<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Study Tracker - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Programmer Theme (Default)
                        'prog-bg': '#1a1a2e',
                        'prog-card': '#16213e',
                        'prog-accent': '#0f3460',
                        'prog-primary': '#00ff41',
                        'prog-secondary': '#9d4edd',
                        
                        // Girls Theme
                        'girls-bg': '#fff0f6',
                        'girls-card': '#ffe6f0',
                        'girls-accent': '#ff69b4',
                        'girls-primary': '#ff1493',
                        'girls-secondary': '#ffc0cb',
                        
                        // Sports Theme
                        'sports-bg': '#1a2634',
                        'sports-card': '#2d3e50',
                        'sports-accent': '#ff6b35',
                        'sports-primary': '#f7931e',
                        'sports-secondary': '#004e89',
                    }
                }
            }
        }
    </script>
    <style>
        /* Programmer Theme */
        .theme-programmer {
            background-color: #1a1a2e;
            color: #00ff41;
        }
        .theme-programmer .card {
            background-color: #16213e;
            border: 1px solid #0f3460;
        }
        .theme-programmer .btn-primary {
            background-color: #00ff41;
            color: #1a1a2e;
        }
        .theme-programmer .btn-primary:hover {
            background-color: #00cc33;
        }

        /* Girls Theme */
        .theme-girls {
            background-color: #fff0f6;
            color: #ff1493;
        }
        .theme-girls .card {
            background-color: #ffe6f0;
            border: 2px solid #ff69b4;
        }
        .theme-girls .btn-primary {
            background-color: #ff1493;
            color: white;
        }
        .theme-girls .btn-primary:hover {
            background-color: #ff69b4;
        }

        /* Sports Theme */
        .theme-sports {
            background-color: #1a2634;
            color: #f7931e;
        }
        .theme-sports .card {
            background-color: #2d3e50;
            border: 2px solid #ff6b35;
        }
        .theme-sports .btn-primary {
            background-color: #f7931e;
            color: #1a2634;
        }
        .theme-sports .btn-primary:hover {
            background-color: #ff6b35;
        }

        /* Progress Bar */
        .progress-bar {
            height: 20px;
            border-radius: 10px;
            overflow: hidden;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .progress-fill {
            height: 100%;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body class="theme-{{ auth()->user()->theme ?? 'programmer' }}">
    <nav class="card p-4 mb-6">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold">📚 Study Tracker</a>
            </div>
            <div class="flex gap-4 items-center">
                <a href="{{ route('dashboard') }}" class="hover:underline">Dashboard</a>
                <a href="{{ route('subjects.index') }}" class="hover:underline">Subjects</a>
                
                <!-- Theme Selector -->
                <form action="{{ route('theme.update') }}" method="POST" class="inline">
                    @csrf
                    <select name="theme" onchange="this.form.submit()" class="bg-transparent border rounded px-2 py-1">
                        <option value="programmer" {{ auth()->user()->theme === 'programmer' ? 'selected' : '' }}>🖥️ Programmer</option>
                        <option value="girls" {{ auth()->user()->theme === 'girls' ? 'selected' : '' }}>👧 Girls</option>
                        <option value="sports" {{ auth()->user()->theme === 'sports' ? 'selected' : '' }}>⚽ Sports</option>
                    </select>
                </form>

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4">
        @if(session('success'))
            <div class="card p-4 mb-4 border-green-500">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="card p-4 mb-4 border-red-500">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>