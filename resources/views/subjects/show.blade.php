@extends('layouts.app')

@section('title', $subject->name)

@section('content')
<div>
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-bold">{{ $subject->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('subjects.edit', $subject) }}" class="border px-4 py-2 rounded hover:opacity-75">Edit</a>
            <form action="{{ route('subjects.destroy', $subject) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure?')" class="border border-red-500 px-4 py-2 rounded hover:bg-red-500">Delete</button>
            </form>
        </div>
    </div>

    <!-- Overall Progress -->
    <div class="card p-6 mb-6">
        <h2 class="text-2xl font-bold mb-4">Overall Progress</h2>
        <div class="progress-bar mb-2" style="height: 30px;">
            <div class="progress-fill btn-primary flex items-center justify-center font-bold" style="width: {{ $subject->total_progress }}%">
                {{ number_format($subject->total_progress, 1) }}%
            </div>
        </div>
        <p class="text-sm opacity-75">
            Weights: 
            Chapters {{ ($subject->progress_weights['chapters'] ?? 0.4) * 100 }}% | 
            Sections {{ ($subject->progress_weights['sections'] ?? 0.2) * 100 }}% | 
            Labs {{ ($subject->progress_weights['labs'] ?? 0.2) * 100 }}% | 
            Project {{ ($subject->progress_weights['project'] ?? 0.2) * 100 }}%
        </p>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <a href="{{ route('chapters.create', $subject) }}" class="card p-4 text-center hover:opacity-75">
            <div class="text-3xl mb-2">📖</div>
            <div class="font-bold">Add Chapter</div>
        </a>
        
        <a href="{{ route('lectures.create', $subject) }}" class="card p-4 text-center hover:opacity-75">
            <div class="text-3xl mb-2">🎓</div>
            <div class="font-bold">Add Lecture</div>
        </a>
        
        <a href="{{ route('projects.create', $subject) }}" class="card p-4 text-center hover:opacity-75">
            <div class="text-3xl mb-2">🚀</div>
            <div class="font-bold">Add Project</div>
        </a>
        
        <div class="card p-4 text-center">
            <div class="text-3xl mb-2">📊</div>
            <div class="font-bold">Statistics</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Chapters Section -->
        <div class="card p-6">
            <h2 class="text-2xl font-bold mb-4">📚 Chapters ({{ $subject->chapters->count() }})</h2>
            
            @forelse($subject->chapters->sortBy('order') as $chapter)
                <div class="border-b py-4 last:border-b-0">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <h3 class="font-bold">{{ $chapter->name }}</h3>
                            <span class="text-xs px-2 py-1 rounded {{ $chapter->status === 'completed' ? 'bg-green-500' : ($chapter->status === 'in_progress' ? 'bg-yellow-500' : 'bg-gray-500') }}">
                                {{ ucfirst(str_replace('_', ' ', $chapter->status)) }}
                            </span>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('chapters.edit', $chapter) }}" class="text-sm hover:underline">Edit</a>
                            <form action="{{ route('chapters.destroy', $chapter) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this chapter?')" class="text-sm text-red-500 hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="progress-bar mt-2">
                        <div class="progress-fill btn-primary" style="width: {{ $chapter->completion_percentage }}%"></div>
                    </div>
                    <p class="text-xs mt-1">{{ number_format($chapter->completion_percentage, 1) }}% Complete</p>

                    @if($chapter->lectures->isNotEmpty())
                        <div class="mt-2 text-sm opacity-75">
                            <span>Covered in {{ $chapter->lectures->count() }} lecture(s):</span>
                            <ul class="ml-4 mt-1">
                                @foreach($chapter->lectures as $lecture)
                                    <li>• {{ $lecture->name }} ({{ $lecture->pivot->coverage_percentage }}%)</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-center opacity-75 py-8">No chapters yet. <a href="{{ route('chapters.create', $subject) }}" class="underline">Add one</a></p>
            @endforelse
        </div>

        <!-- Lectures Section -->
        <div class="card p-6">
            <h2 class="text-2xl font-bold mb-4">🎓 Lectures ({{ $subject->lectures->count() }})</h2>
            
            @forelse($subject->lectures->sortByDesc('date') as $lecture)
                <div class="border-b py-4 last:border-b-0">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex-1">
                            <h3 class="font-bold">{{ $lecture->name }}</h3>
                            <div class="flex gap-2 items-center text-sm mt-1">
                                <span class="px-2 py-1 rounded text-xs {{ $lecture->type === 'lecture' ? 'bg-blue-500' : ($lecture->type === 'section' ? 'bg-purple-500' : 'bg-orange-500') }}">
                                    {{ ucfirst($lecture->type) }}
                                </span>
                                @if($lecture->date)
                                    <span class="opacity-75">{{ $lecture->date->format('M d, Y') }}</span>
                                @endif
                                @if($lecture->duration)
                                    <span class="opacity-75">{{ $lecture->duration }} min</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('lectures.edit', $lecture) }}" class="text-sm hover:underline">Edit</a>
                            <form action="{{ route('lectures.destroy', $lecture) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this lecture?')" class="text-sm text-red-500 hover:underline">Delete</button>
                            </form>
                        </div>
                    </div>

                    @if($lecture->chapters->isNotEmpty())
                        <div class="mt-2 text-sm opacity-75">
                            <span>Covers:</span>
                            <ul class="ml-4 mt-1">
                                @foreach($lecture->chapters as $chapter)
                                    <li>• {{ $chapter->name }} ({{ $chapter->pivot->coverage_percentage }}%)</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-center opacity-75 py-8">No lectures yet. <a href="{{ route('lectures.create', $subject) }}" class="underline">Add one</a></p>
            @endforelse
        </div>
    </div>

    <!-- Projects Section -->
    @if($subject->project->isNotEmpty())
        <div class="card p-6 mt-6">
            <h2 class="text-2xl font-bold mb-4">🚀 Projects ({{ $subject->project->count() }})</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($subject->project as $project)
                    <div class="border rounded p-4">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-lg">{{ $project->name }}</h3>
                                <span class="text-xs px-2 py-1 rounded {{ $project->status === 'completed' ? 'bg-green-500' : ($project->status === 'in_progress' ? 'bg-yellow-500' : 'bg-gray-500') }}">
                                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                                </span>
                            </div>
                            <div class="flex gap-2">
                                <a href="{{ route('projects.edit', $project) }}" class="text-sm hover:underline">Edit</a>
                            </div>
                        </div>

                        @if($project->description)
                            <p class="text-sm opacity-75 mb-3">{{ $project->description }}</p>
                        @endif

                        @if($project->deadline)
                            <p class="text-sm mb-3">
                                <span class="opacity-75">Deadline:</span> 
                                <span class="font-bold">{{ $project->deadline->format('M d, Y') }}</span>
                            </p>
                        @endif

                        <div class="progress-bar mb-2">
                            <div class="progress-fill btn-primary" style="width: {{ $project->progress }}%"></div>
                        </div>
                        <p class="text-xs">{{ number_format($project->progress, 1) }}% Complete</p>

                        <!-- Quick Progress Update -->
                        <form action="{{ route('projects.progress', $project) }}" method="POST" class="mt-3">
                            @csrf
                            <div class="flex gap-2">
                                <input 
                                    type="number" 
                                    name="progress" 
                                    min="0" 
                                    max="100" 
                                    value="{{ $project->progress }}"
                                    class="flex-1 bg-transparent border rounded px-3 py-1 text-sm"
                                >
                                <button type="submit" class="btn-primary px-4 py-1 rounded text-sm">Update</button>
                            </div>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection