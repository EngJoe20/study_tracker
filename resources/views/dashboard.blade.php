@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold mb-4">📊 Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="card p-6">
            <h3 class="text-sm opacity-75 mb-2">Total Subjects</h3>
            <p class="text-3xl font-bold">{{ $stats['total_subjects'] }}</p>
        </div>
        
        <div class="card p-6">
            <h3 class="text-sm opacity-75 mb-2">Active Subjects</h3>
            <p class="text-3xl font-bold">{{ $stats['active_subjects'] }}</p>
        </div>
        
        <div class="card p-6">
            <h3 class="text-sm opacity-75 mb-2">Completed Subjects</h3>
            <p class="text-3xl font-bold">{{ $stats['completed_subjects'] }}</p>
        </div>
        
        <div class="card p-6">
            <h3 class="text-sm opacity-75 mb-2">Average Progress</h3>
            <p class="text-3xl font-bold">{{ number_format($stats['average_progress'], 1) }}%</p>
        </div>
    </div>

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Your Subjects</h2>
        <a href="{{ route('subjects.create') }}" class="btn-primary px-4 py-2 rounded">+ New Subject</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($subjects as $subject)
            <a href="{{ route('subjects.show', $subject) }}" class="card p-6 hover:opacity-80 transition">
                <h3 class="text-xl font-bold mb-3">{{ $subject->name }}</h3>
                
                <div class="mb-4">
                    <div class="flex justify-between mb-1">
                        <span class="text-sm">Overall Progress</span>
                        <span class="text-sm font-bold">{{ number_format($subject->total_progress, 1) }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill btn-primary" style="width: {{ $subject->total_progress }}%"></div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <span class="opacity-75">Chapters:</span>
                        <span class="font-bold">{{ $subject->chapters->count() }}</span>
                    </div>
                    <div>
                        <span class="opacity-75">Lectures:</span>
                        <span class="font-bold">{{ $subject->lectures->count() }}</span>
                    </div>
                </div>

                <div class="mt-3">
                    <span class="text-xs px-2 py-1 rounded {{ $subject->status === 'completed' ? 'bg-green-500' : 'bg-yellow-500' }}">
                        {{ ucfirst($subject->status) }}
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-3 card p-8 text-center">
                <p class="mb-4">No subjects yet. Start by creating your first subject!</p>
                <a href="{{ route('subjects.create') }}" class="btn-primary px-6 py-2 rounded inline-block">Create Subject</a>
            </div>
        @endforelse
    </div>
</div>
@endsection