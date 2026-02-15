@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Edit Project</h1>

    <form action="{{ route('projects.update', $project) }}" method="POST" class="card p-6">
        @csrf
        @method('PUT')

        <input type="hidden" name="subject_id" value="{{ $project->subject_id ?? old('subject_id') }}">

        <div class="mb-4">
            <label for="name" class="block mb-2 font-bold">Project Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                required 
                class="w-full bg-transparent border rounded px-4 py-2"
                value="{{ old('name', $project->name) }}"
            >
        </div>

        <div class="mb-4">
            <label for="deadline" class="block mb-2 font-bold">Deadline</label>
            <input 
                type="date" 
                id="deadline" 
                name="deadline" 
                class="w-full bg-transparent border rounded px-4 py-2"
                value="{{ old('deadline', optional($project->deadline)->format('Y-m-d')) }}"
            >
        </div>

        <div class="mb-4">
            <label for="progress" class="block mb-2 font-bold">Progress (%)</label>
            <input 
                type="number" 
                id="progress" 
                name="progress" 
                min="0" 
                max="100" 
                step="0.01"
                class="w-full bg-transparent border rounded px-4 py-2"
                value="{{ old('progress', $project->progress) }}"
            >
        </div>

        <div class="mb-4">
            <label for="status" class="block mb-2 font-bold">Status</label>
            <select id="status" name="status" class="w-full bg-transparent border rounded px-4 py-2">
                <option value="not_started" {{ old('status', $project->status) == 'not_started' ? 'selected' : '' }}>Not Started</option>
                <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>

        <div class="mb-6">
            <label for="description" class="block mb-2 font-bold">Description</label>
            <textarea 
                id="description" 
                name="description" 
                rows="4"
                class="w-full bg-transparent border rounded px-4 py-2"
            >{{ old('description', $project->description) }}</textarea>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-primary px-6 py-2 rounded">Update Project</button>
            <a href="{{ route('subjects.show', $project->subject_id) }}" class="border px-6 py-2 rounded hover:opacity-75">Cancel</a>
        </div>
    </form>
</div>
@endsection
