@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="animate-slide-in">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold mb-2">
                <i class="fas fa-chart-line mr-2"></i>
                Dashboard
            </h1>
            <p class="opacity-75">Welcome back, {{ auth()->user()->name }}! Here's your progress overview.</p>
        </div>
        <a href="{{ route('subjects.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>
            New Subject
        </a>
    </div>
    
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="card stat-card">
            <i class="fas fa-book text-4xl mb-3 opacity-75"></i>
            <div class="stat-value">{{ $stats['total_subjects'] }}</div>
            <div class="stat-label">Total Subjects</div>
        </div>
        
        <div class="card stat-card">
            <i class="fas fa-fire text-4xl mb-3 opacity-75"></i>
            <div class="stat-value">{{ $stats['active_subjects'] }}</div>
            <div class="stat-label">Active Subjects</div>
        </div>
        
        <div class="card stat-card">
            <i class="fas fa-check-circle text-4xl mb-3 opacity-75"></i>
            <div class="stat-value">{{ $stats['completed_subjects'] }}</div>
            <div class="stat-label">Completed</div>
        </div>
        
        <div class="card stat-card">
            <i class="fas fa-trophy text-4xl mb-3 opacity-75"></i>
            <div class="stat-value">{{ number_format($stats['average_progress'], 1) }}%</div>
            <div class="stat-label">Average Progress</div>
        </div>
    </div>

    <!-- Subjects Section -->
    <div class="mb-4">
        <h2 class="text-2xl font-bold mb-6">
            <i class="fas fa-graduation-cap mr-2"></i>
            Your Subjects
        </h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($subjects as $subject)
            <a href="{{ route('subjects.show', $subject) }}" class="card hover:scale-105 transition-transform">
                <!-- Subject Header -->
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-xl font-bold flex-1">{{ $subject->name }}</h3>
                    <span class="badge {{ $subject->status === 'completed' ? 'bg-green-500' : ($subject->status === 'active' ? 'bg-blue-500' : 'bg-gray-500') }} text-white ml-2">
                        {{ ucfirst($subject->status) }}
                    </span>
                </div>
                
                <!-- Overall Progress -->
                <div class="mb-4">
                    <div class="flex justify-between mb-2">
                        <span class="text-sm font-semibold">Overall Progress</span>
                        <span class="text-sm font-bold">{{ number_format($subject->total_progress, 1) }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill btn-primary" style="width: {{ $subject->total_progress }}%">
                            {{ $subject->total_progress >= 20 ? number_format($subject->total_progress, 0) . '%' : '' }}
                        </div>
                    </div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-3 gap-3 text-center text-sm border-t pt-3" style="border-color: rgba(255, 255, 255, 0.1);">
                    <div>
                        <div class="text-2xl font-bold">{{ $subject->chapters->count() }}</div>
                        <div class="opacity-75">Chapters</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $subject->lectures->count() }}</div>
                        <div class="opacity-75">Lectures</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold">{{ $subject->project->count() }}</div>
                        <div class="opacity-75">Projects</div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-3 card text-center py-12">
                <i class="fas fa-book-open text-6xl mb-4 opacity-50"></i>
                <p class="text-xl mb-4">No subjects yet. Start by creating your first subject!</p>
                <a href="{{ route('subjects.create') }}" class="btn btn-primary inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i>
                    Create Your First Subject
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection