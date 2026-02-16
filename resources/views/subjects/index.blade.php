@extends('layouts.app')

@section('title', 'All Subjects')

@section('content')
<div class="animate-slide-in">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold mb-2">
                <i class="fas fa-book mr-2"></i>
                All Subjects
            </h1>
            <p class="opacity-75">Manage all your academic subjects in one place</p>
        </div>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>
            New Subject
        </a>
    </div>

    <!-- Filter Options -->
    <div class="card mb-6">
        <div class="flex space-x-4">
            <button class="btn btn-primary">
                <i class="fas fa-list mr-2"></i>
                All ({{ $subjects->count() }})
            </button>
            <button class="btn border">
                <i class="fas fa-fire mr-2"></i>
                Active ({{ $subjects->where('status', 'active')->count() }})
            </button>
            <button class="btn border">
                <i class="fas fa-check mr-2"></i>
                Completed ({{ $subjects->where('status', 'completed')->count() }})
            </button>
        </div>
    </div>

    <!-- Subjects List -->
    <div class="space-y-4">
        @forelse($subjects as $subject)
            <div class="card">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-4 mb-3">
                            <h3 class="text-2xl font-bold">{{ $subject->name }}</h3>
                            <span class="badge {{ $subject->status === 'completed' ? 'bg-green-500' : 'bg-blue-500' }} text-white">
                                {{ ucfirst($subject->status) }}
                            </span>
                        </div>
                        
                        <!-- Progress Bar -->
                        <div class="mb-3 max-w-md">
                            <div class="flex justify-between mb-1 text-sm">
                                <span>Progress</span>
                                <span class="font-bold">{{ number_format($subject->total_progress, 1) }}%</span>
                            </div>
                            <div class="progress-bar">
                                <div class="progress-fill btn-primary" style="width: {{ $subject->total_progress }}%"></div>
                            </div>
                        </div>

                        <!-- Quick Stats -->
                        <div class="flex space-x-6 text-sm">
                            <span><i class="fas fa-book-open mr-1"></i> {{ $subject->chapters->count() }} Chapters</span>
                            <span><i class="fas fa-chalkboard-teacher mr-1"></i> {{ $subject->lectures->count() }} Lectures</span>
                            <span><i class="fas fa-project-diagram mr-1"></i> {{ $subject->project->count() }} Projects</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <a href="{{ route('subjects.show', $subject) }}" class="btn btn-primary">
                            <i class="fas fa-eye mr-1"></i>
                            View
                        </a>
                        <a href="{{ route('subjects.edit', $subject) }}" class="btn border">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="card text-center py-12">
                <i class="fas fa-inbox text-6xl mb-4 opacity-50"></i>
                <p class="text-xl mb-4">No subjects found</p>
                <a href="{{ route('subjects.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Create Subject
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection