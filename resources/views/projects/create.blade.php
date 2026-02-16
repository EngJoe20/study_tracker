@extends('layouts.app')

@section('title', 'Add Project')

@section('content')
<div class="max-w-2xl mx-auto animate-slide-in">
    <div class="mb-6">
        <h1 class="text-4xl font-bold mb-2">
            <i class="fas fa-rocket mr-2"></i>
            Add Project
        </h1>
        <p class="opacity-75">Create a new project for <strong>{{ $subject->name }}</strong></p>
    </div>

    <form action="{{ route('projects.store', $subject) }}" method="POST" class="card">
        @csrf

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
                placeholder="e.g., E-Commerce Website"
                value="{{ old('name') }}"
                autofocus
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
                placeholder="Describe your project objectives and requirements..."
            >{{ old('description') }}</textarea>
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
                    value="{{ old('deadline') }}"
                >
            </div>

            <div>
                <label for="progress" class="block mb-2 font-bold">
                    <i class="fas fa-percentage mr-2"></i>
                    Initial Progress
                </label>
                <input 
                    type="number" 
                    id="progress" 
                    name="progress" 
                    min="0" 
                    max="100"
                    step="0.1"
                    class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
                    placeholder="0"
                    value="{{ old('progress', 0) }}"
                >
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-6 border-t" style="border-color: rgba(255, 255, 255, 0.1);">
            <button type="submit" class="btn btn-primary flex items-center">
                <i class="fas fa-check mr-2"></i>
                Create Project
            </button>
            <a href="{{ route('subjects.show', $subject) }}" class="btn border">
                <i class="fas fa-times mr-2"></i>
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection