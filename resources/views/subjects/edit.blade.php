@extends('layouts.app')

@section('title', 'Edit Subject')

@section('content')
<div class="max-w-3xl mx-auto animate-slide-in">
    <div class="mb-6">
        <h1 class="text-4xl font-bold mb-2">
            <i class="fas fa-edit mr-2"></i>
            Edit Subject
        </h1>
        <p class="opacity-75">Update subject information and progress weights</p>
    </div>

    <form action="{{ route('subjects.update', $subject) }}" method="POST" class="card">
        @csrf
        @method('PUT')

        <!-- Subject Name -->
        <div class="mb-6">
            <label for="name" class="block mb-2 font-bold text-lg">
                <i class="fas fa-graduation-cap mr-2"></i>
                Subject Name
            </label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                required 
                class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
                placeholder="e.g., Data Structures & Algorithms"
                value="{{ old('name', $subject->name) }}"
            >
        </div>

        <!-- Status -->
        <div class="mb-6">
            <label for="status" class="block mb-2 font-bold text-lg">
                <i class="fas fa-flag mr-2"></i>
                Status
            </label>
            <select 
                id="status" 
                name="status" 
                class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
            >
                <option value="active" {{ old('status', $subject->status) === 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ old('status', $subject->status) === 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="archived" {{ old('status', $subject->status) === 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
        </div>

        <!-- Progress Weights Section -->
        <div class="mb-6">
            <h3 class="font-bold mb-2 text-lg flex items-center">
                <i class="fas fa-sliders-h mr-2"></i>
                Progress Weights
            </h3>
            <p class="text-sm opacity-75 mb-4">
                Adjust how much each component contributes to overall progress
            </p>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="chapters_weight" class="block mb-2 text-sm font-semibold">
                        <i class="fas fa-book mr-1"></i>
                        Chapters Weight
                    </label>
                    <input 
                        type="number" 
                        id="chapters_weight" 
                        name="chapters_weight" 
                        step="0.01" 
                        min="0" 
                        max="1"
                        class="w-full bg-transparent border rounded px-3 py-2"
                        placeholder="0.40"
                        value="{{ old('chapters_weight', $subject->progress_weights['chapters'] ?? 0.40) }}"
                    >
                </div>

                <div>
                    <label for="sections_weight" class="block mb-2 text-sm font-semibold">
                        <i class="fas fa-clipboard-list mr-1"></i>
                        Sections Weight
                    </label>
                    <input 
                        type="number" 
                        id="sections_weight" 
                        name="sections_weight" 
                        step="0.01" 
                        min="0" 
                        max="1"
                        class="w-full bg-transparent border rounded px-3 py-2"
                        placeholder="0.20"
                        value="{{ old('sections_weight', $subject->progress_weights['sections'] ?? 0.20) }}"
                    >
                </div>

                <div>
                    <label for="labs_weight" class="block mb-2 text-sm font-semibold">
                        <i class="fas fa-flask mr-1"></i>
                        Labs Weight
                    </label>
                    <input 
                        type="number" 
                        id="labs_weight" 
                        name="labs_weight" 
                        step="0.01" 
                        min="0" 
                        max="1"
                        class="w-full bg-transparent border rounded px-3 py-2"
                        placeholder="0.20"
                        value="{{ old('labs_weight', $subject->progress_weights['labs'] ?? 0.20) }}"
                    >
                </div>

                <div>
                    <label for="project_weight" class="block mb-2 text-sm font-semibold">
                        <i class="fas fa-project-diagram mr-1"></i>
                        Project Weight
                    </label>
                    <input 
                        type="number" 
                        id="project_weight" 
                        name="project_weight" 
                        step="0.01" 
                        min="0" 
                        max="1"
                        class="w-full bg-transparent border rounded px-3 py-2"
                        placeholder="0.20"
                        value="{{ old('project_weight', $subject->progress_weights['project'] ?? 0.20) }}"
                    >
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-6 border-t" style="border-color: rgba(255, 255, 255, 0.1);">
            <button type="submit" class="btn btn-primary flex items-center">
                <i class="fas fa-save mr-2"></i>
                Save Changes
            </button>
            <a href="{{ route('subjects.show', $subject) }}" class="btn border">
                <i class="fas fa-times mr-2"></i>
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection