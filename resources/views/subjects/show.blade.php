@extends('layouts.app')

@section('title', $subject->name)

@section('content')
<div class="animate-slide-in">
    <!-- Subject Header -->
    <div class="card mb-6">
        <div class="flex justify-between items-start mb-4">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <h1 class="text-4xl font-bold">{{ $subject->name }}</h1>
                    <span class="badge {{ $subject->status === 'completed' ? 'bg-green-500' : 'bg-blue-500' }} text-white text-base px-4 py-1">
                        {{ ucfirst($subject->status) }}
                    </span>
                </div>
                <p class="opacity-75">Track your progress across chapters, lectures, and projects</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('subjects.edit', $subject) }}" class="btn border">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this subject? All chapters, lectures, and projects will be removed.')" class="btn border border-red-500 text-red-500 hover:bg-red-500 hover:text-white">
                        <i class="fas fa-trash mr-2"></i>
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <!-- Overall Progress -->
        <div class="bg-black bg-opacity-20 rounded-lg p-6">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-2xl font-bold">
                    <i class="fas fa-chart-line mr-2"></i>
                    Overall Progress
                </h2>
                <div class="text-3xl font-bold">{{ number_format($subject->total_progress, 1) }}%</div>
            </div>
            <div class="progress-bar mb-3" style="height: 32px;">
                <div class="progress-fill btn-primary text-base" style="width: {{ $subject->total_progress }}%">
                    {{ $subject->total_progress >= 10 ? number_format($subject->total_progress, 1) . '%' : '' }}
                </div>
            </div>
            <div class="flex justify-between text-sm opacity-75">
                <span>
                    <i class="fas fa-weight-hanging mr-1"></i>
                    Weights: 
                    Chapters {{ ($subject->progress_weights['chapters'] ?? 0.4) * 100 }}% | 
                    Sections {{ ($subject->progress_weights['sections'] ?? 0.2) * 100 }}% | 
                    Labs {{ ($subject->progress_weights['labs'] ?? 0.2) * 100 }}% | 
                    Project {{ ($subject->progress_weights['project'] ?? 0.2) * 100 }}%
                </span>
                <span>
                    <i class="fas fa-calendar mr-1"></i>
                    Created {{ $subject->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('chapters.create', $subject) }}" class="card text-center hover:scale-105 transition-transform cursor-pointer">
            <div class="text-5xl mb-3">📖</div>
            <div class="font-bold text-lg mb-1">Add Chapter</div>
            <div class="text-sm opacity-75">Create new chapter</div>
        </a>
        
        <a href="{{ route('lectures.create', $subject) }}" class="card text-center hover:scale-105 transition-transform cursor-pointer">
            <div class="text-5xl mb-3">🎓</div>
            <div class="font-bold text-lg mb-1">Add Lecture</div>
            <div class="text-sm opacity-75">Record a new lecture</div>
        </a>
        
        <a href="{{ route('projects.create', $subject) }}" class="card text-center hover:scale-105 transition-transform cursor-pointer">
            <div class="text-5xl mb-3">🚀</div>
            <div class="font-bold text-lg mb-1">Add Project</div>
            <div class="text-sm opacity-75">Create new project</div>
        </a>
        
        <div class="card text-center bg-opacity-50">
            <div class="text-5xl mb-3">📊</div>
            <div class="font-bold text-lg mb-1">Statistics</div>
            <div class="text-sm opacity-75">View detailed stats</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chapters Section -->
        <div class="card">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">
                    <i class="fas fa-book-open mr-2"></i>
                    Chapters ({{ $subject->chapters->count() }})
                </h2>
                <a href="{{ route('chapters.create', $subject) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i>
                    Add
                </a>
            </div>
            
            @forelse($subject->chapters->sortBy('order') as $chapter)
                <div class="border-b py-4 last:border-b-0" style="border-color: rgba(255, 255, 255, 0.1);">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <div class="flex items-center space-x-2 mb-1">
                                <span class="text-sm opacity-50">#{{ $chapter->order }}</span>
                                <h3 class="font-bold text-lg">{{ $chapter->name }}</h3>
                            </div>
                            <span class="badge text-xs {{ $chapter->status === 'completed' ? 'bg-green-500' : ($chapter->status === 'in_progress' ? 'bg-yellow-500' : 'bg-gray-500') }} text-white">
                                {{ ucfirst(str_replace('_', ' ', $chapter->status)) }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('chapters.edit', $chapter) }}" class="text-sm hover:opacity-75">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('chapters.destroy', $chapter) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this chapter?')" class="text-sm text-red-500 hover:opacity-75">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="progress-bar mt-2 mb-1">
                        <div class="progress-fill btn-primary" style="width: {{ $chapter->completion_percentage }}%">
                            {{ $chapter->completion_percentage >= 20 ? number_format($chapter->completion_percentage, 0) . '%' : '' }}
                        </div>
                    </div>
                    <p class="text-xs opacity-75">{{ number_format($chapter->completion_percentage, 1) }}% Complete</p>

                    @if($chapter->lectures->isNotEmpty())
                        <div class="mt-3 p-3 bg-black bg-opacity-20 rounded text-sm">
                            <div class="font-semibold mb-1 opacity-75">
                                <i class="fas fa-chalkboard-teacher mr-1"></i>
                                Covered in {{ $chapter->lectures->count() }} lecture(s):
                            </div>
                            <ul class="space-y-1">
                                @foreach($chapter->lectures as $lecture)
                                    <li class="flex justify-between">
                                        <span>• {{ $lecture->name }}</span>
                                        <span class="font-bold">{{ $lecture->pivot->coverage_percentage }}%</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($chapter->notes)
                        <div class="mt-2 text-sm opacity-75">
                            <i class="fas fa-sticky-note mr-1"></i>
                            {{ Str::limit($chapter->notes, 100) }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-8 opacity-75">
                    <i class="fas fa-book text-4xl mb-3"></i>
                    <p>No chapters yet. <a href="{{ route('chapters.create', $subject) }}" class="underline font-semibold">Add your first chapter</a></p>
                </div>
            @endforelse
        </div>

        <!-- Lectures Section -->
        <div class="card">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">
                    <i class="fas fa-graduation-cap mr-2"></i>
                    Lectures ({{ $subject->lectures->count() }})
                </h2>
                <a href="{{ route('lectures.create', $subject) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i>
                    Add
                </a>
            </div>
            
            @forelse($subject->lectures->sortByDesc('date') as $lecture)
                <div class="border-b py-4 last:border-b-0" style="border-color: rgba(255, 255, 255, 0.1);">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg mb-2">{{ $lecture->name }}</h3>
                            <div class="flex flex-wrap gap-2 items-center text-sm">
                                <span class="badge {{ $lecture->type === 'lecture' ? 'bg-blue-500' : ($lecture->type === 'section' ? 'bg-purple-500' : 'bg-orange-500') }} text-white">
                                    <i class="fas {{ $lecture->type === 'lecture' ? 'fa-chalkboard-teacher' : ($lecture->type === 'section' ? 'fa-users' : 'fa-flask') }} mr-1"></i>
                                    {{ ucfirst($lecture->type) }}
                                </span>
                                @if($lecture->date)
                                    <span class="opacity-75">
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ $lecture->date->format('M d, Y') }}
                                    </span>
                                @endif
                                @if($lecture->duration)
                                    <span class="opacity-75">
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $lecture->duration }} min
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('lectures.edit', $lecture) }}" class="text-sm hover:opacity-75">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('lectures.destroy', $lecture) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this lecture?')" class="text-sm text-red-500 hover:opacity-75">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    @if($lecture->chapters->isNotEmpty())
                        <div class="mt-3 p-3 bg-black bg-opacity-20 rounded text-sm">
                            <div class="font-semibold mb-1 opacity-75">
                                <i class="fas fa-book-open mr-1"></i>
                                Covers:
                            </div>
                            <ul class="space-y-1">
                                @foreach($lecture->chapters as $chapter)
                                    <li class="flex justify-between">
                                        <span>• {{ $chapter->name }}</span>
                                        <span class="font-bold">{{ $chapter->pivot->coverage_percentage }}%</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($lecture->notes)
                        <div class="mt-2 text-sm opacity-75">
                            <i class="fas fa-sticky-note mr-1"></i>
                            {{ Str::limit($lecture->notes, 100) }}
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-8 opacity-75">
                    <i class="fas fa-chalkboard-teacher text-4xl mb-3"></i>
                    <p>No lectures yet. <a href="{{ route('lectures.create', $subject) }}" class="underline font-semibold">Add your first lecture</a></p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Projects Section -->
    @if($subject->project->isNotEmpty())
        <div class="card mt-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold">
                    <i class="fas fa-project-diagram mr-2"></i>
                    Projects ({{ $subject->project->count() }})
                </h2>
                <a href="{{ route('projects.create', $subject) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i>
                    Add
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($subject->project as $project)
                    <div class="border rounded-lg p-4" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-xl mb-2">{{ $project->name }}</h3>
                                <span class="badge text-xs {{ $project->status === 'completed' ? 'bg-green-500' : ($project->status === 'in_progress' ? 'bg-yellow-500' : 'bg-gray-500') }} text-white">
                                    <i class="fas {{ $project->status === 'completed' ? 'fa-check-circle' : ($project->status === 'in_progress' ? 'fa-spinner' : 'fa-pause-circle') }} mr-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                </span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('projects.edit', $project) }}" class="text-sm hover:opacity-75">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this project?')" class="text-sm text-red-500 hover:opacity-75">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        @if($project->description)
                            <p class="text-sm opacity-75 mb-3">{{ $project->description }}</p>
                        @endif

                        @if($project->deadline)
                            <div class="flex items-center text-sm mb-3">
                                <i class="fas fa-calendar-alt mr-2"></i>
                                <span class="opacity-75">Deadline:</span>
                                <span class="font-bold ml-2">{{ $project->deadline->format('M d, Y') }}</span>
                                @if($project->deadline->isPast())
                                    <span class="badge bg-red-500 text-white text-xs ml-2">Overdue</span>
                                @elseif($project->deadline->diffInDays() <= 7)
                                    <span class="badge bg-yellow-500 text-white text-xs ml-2">Due Soon</span>
                                @endif
                            </div>
                        @endif

                        <div class="progress-bar mb-2">
                            <div class="progress-fill btn-primary" style="width: {{ $project->progress }}%">
                                {{ $project->progress >= 20 ? number_format($project->progress, 0) . '%' : '' }}
                            </div>
                        </div>
                        <p class="text-xs opacity-75 mb-3">{{ number_format($project->progress, 1) }}% Complete</p>

                        <!-- Quick Progress Update -->
                        <form action="{{ route('projects.progress', $project) }}" method="POST" class="mt-3">
                            @csrf
                            <label class="block text-sm font-semibold mb-2">
                                <i class="fas fa-sliders-h mr-1"></i>
                                Update Progress
                            </label>
                            <div class="flex gap-2">
                                <input 
                                    type="number" 
                                    name="progress" 
                                    min="0" 
                                    max="100" 
                                    step="0.1"
                                    value="{{ $project->progress }}"
                                    class="flex-1 bg-transparent border rounded px-3 py-2 text-sm"
                                    placeholder="0-100"
                                >
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sync-alt mr-1"></i>
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <div class="card mt-6 text-center py-8">
            <i class="fas fa-project-diagram text-5xl mb-3 opacity-50"></i>
            <p class="mb-4 opacity-75">No projects yet for this subject</p>
            <a href="{{ route('projects.create', $subject) }}" class="btn btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Add Your First Project
            </a>
        </div>
    @endif
</div>
@endsection