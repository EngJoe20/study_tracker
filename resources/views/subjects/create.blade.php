@extends('layouts.app')

@section('title', 'Create Subject')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Create New Subject</h1>

    <form action="{{ route('subjects.store') }}" method="POST" class="card p-6">
        @csrf

        <div class="mb-4">
            <label for="name" class="block mb-2 font-bold">Subject Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                required 
                class="w-full bg-transparent border rounded px-4 py-2"
                placeholder="e.g., Data Structures & Algorithms"
                value="{{ old('name') }}"
            >
        </div>

        <div class="mb-6">
            <h3 class="font-bold mb-3">Progress Weights (Optional)</h3>
            <p class="text-sm opacity-75 mb-4">Define how much each component contributes to overall progress. Leave empty for default (40% chapters, 20% sections, 20% labs, 20% project)</p>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="chapters_weight" class="block mb-1 text-sm">Chapters Weight</label>
                    <input 
                        type="number" 
                        id="chapters_weight" 
                        name="chapters_weight" 
                        step="0.01" 
                        min="0" 
                        max="1"
                        class="w-full bg-transparent border rounded px-3 py-2"
                        placeholder="0.40"
                        value="{{ old('chapters_weight') }}"
                    >
                </div>

                <div>
                    <label for="sections_weight" class="block mb-1 text-sm">Sections Weight</label>
                    <input 
                        type="number" 
                        id="sections_weight" 
                        name="sections_weight" 
                        step="0.01" 
                        min="0" 
                        max="1"
                        class="w-full bg-transparent border rounded px-3 py-2"
                        placeholder="0.20"
                        value="{{ old('sections_weight') }}"
                    >
                </div>

                <div>
                    <label for="labs_weight" class="block mb-1 text-sm">Labs Weight</label>
                    <input 
                        type="number" 
                        id="labs_weight" 
                        name="labs_weight" 
                        step="0.01" 
                        min="0" 
                        max="1"
                        class="w-full bg-transparent border rounded px-3 py-2"
                        placeholder="0.20"
                        value="{{ old('labs_weight') }}"
                    >
                </div>

                <div>
                    <label for="project_weight" class="block mb-1 text-sm">Project Weight</label>
                    <input 
                        type="number" 
                        id="project_weight" 
                        name="project_weight" 
                        step="0.01" 
                        min="0" 
                        max="1"
                        class="w-full bg-transparent border rounded px-3 py-2"
                        placeholder="0.20"
                        value="{{ old('project_weight') }}"
                    >
                </div>
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-primary px-6 py-2 rounded">Create Subject</button>
            <a href="{{ route('subjects.index') }}" class="border px-6 py-2 rounded hover:opacity-75">Cancel</a>
        </div>
    </form>
</div>
@endsection