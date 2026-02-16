@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="max-w-2xl mx-auto animate-slide-in">
    <div class="mb-6">
        <h1 class="text-4xl font-bold mb-2">
            <i class="fas fa-edit mr-2"></i>
            Edit Project
        </h1>
        <p class="opacity-75">Update project information and progress</p>
    </div>

    <form action="{{ route('projects.update', $project) }}" method="POST" class="card">
        @csrf
        @method('PUT')

        <!-- Project Name -->
        <div class="mb-6">
            <label for="name" class="block mb-2 font-bold text-lg">
                <i class="fas fa-heading mr-2"></i>
                Project Name
            </label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                required 
                class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
                value="{{ old('name', $project->name) }}"
            >
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label for="description" class="block mb-2 font-bold text-lg">
                <i class="fas fa-align-left mr-2"></i>
                Description (Optional)
            </label>
            <textarea 
                id="description" 
                name="description" 
                rows="4"
                class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
            >{{ old('description', $project->description) }}</textarea>
        </div>

        <!-- Deadline and Progress -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="deadline" class="block mb-2 font-bold">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    Deadline (Optional)
                </label>
                <input 
                    type="date" 
                    id="deadline" 
                    name="deadline" 
                    class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
                    value="{{ old('deadline', $project->deadline?->format('Y-m-d')) }}"
                >
            </div>

            <div>
                <label for="progress" class="block mb-2 font-bold">
                    <i class="fas fa-percentage mr-2"></i>
                    Progress
                </label>
                <input 
                    type="number" 
                    id="progress" 
                    name="progress" 
                    min="0" 
                    max="100"
                    step="0.1"
                    class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
                    value="{{ old('progress', $project->progress) }}"
                >
            </div>
        </div>

        <!-- Current Status Display -->
        <div class="mb-6 p-4 bg-black bg-opacity-20 rounded-lg">
            <h3 class="font-bold mb-3">Current Status</h3>
            <div class="flex items-center justify-between mb-2">
                <span>Progress:</span>
                <span class="font-bold text-2xl">{{ number_format($project->progress, 1) }}%</span>
            </div>
            <div class="progress-bar mb-3">
                <div class="progress-fill btn-primary" style="width: {{ $project->progress }}%"></div>
            </div>
            <div class="flex items-center gap-2">
                <span class="badge {{ $project->status === 'completed' ? 'bg-green-500' : ($project->status === 'in_progress' ? 'bg-yellow-500' : 'bg-gray-500') }} text-white">
                    {{ ucfirst(str_replace('_', ' ', $project->status)) }}
                </span>
                @if($project->deadline)
                    @if($project->deadline->isPast() && $project->status !== 'completed')
                        <span class="badge bg-red-500 text-white">Overdue</span>
                    @elseif($project->deadline->diffInDays() <= 7 && $project->status !== 'completed')
                        <span class="badge bg-yellow-500 text-white">Due in {{ $project->deadline->diffInDays() }} days</span>
                    @endif
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-6 border-t" style="border-color: rgba(255, 255, 255, 0.1);">
            <button type="submit" class="btn btn-primary flex items-center">
                <i class="fas fa-save mr-2"></i>
                Save Changes
            </button>
            <a href="{{ route('subjects.show', $project->subject_id) }}" class="btn border">
                <i class="fas fa-times mr-2"></i>
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection