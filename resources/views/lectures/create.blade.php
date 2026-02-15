@extends('layouts.app')

@section('title', 'Add Lecture')

@section('content')
<div class="max-w-3xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Add Lecture to {{ $subject->name }}</h1>

    <form action="{{ route('lectures.store', $subject) }}" method="POST" class="card p-6">
        @csrf

        <div class="mb-4">
            <label for="name" class="block mb-2 font-bold">Lecture Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                required 
                class="w-full bg-transparent border rounded px-4 py-2"
                placeholder="e.g., Introduction to Binary Trees"
                value="{{ old('name') }}"
            >
        </div>

        <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
                <label for="type" class="block mb-2 font-bold">Type</label>
                <select id="type" name="type" required class="w-full bg-transparent border rounded px-4 py-2">
                    <option value="lecture" {{ old('type') === 'lecture' ? 'selected' : '' }}>Lecture</option>
                    <option value="section" {{ old('type') === 'section' ? 'selected' : '' }}>Section</option>
                    <option value="lab" {{ old('type') === 'lab' ? 'selected' : '' }}>Lab</option>
                </select>
            </div>

            <div>
                <label for="date" class="block mb-2 font-bold">Date</label>
                <input 
                    type="date" 
                    id="date" 
                    name="date" 
                    class="w-full bg-transparent border rounded px-4 py-2"
                    value="{{ old('date') }}"
                >
            </div>

            <div>
                <label for="duration" class="block mb-2 font-bold">Duration (min)</label>
                <input 
                    type="number" 
                    id="duration" 
                    name="duration" 
                    min="0"
                    class="w-full bg-transparent border rounded px-4 py-2"
                    placeholder="90"
                    value="{{ old('duration') }}"
                >
            </div>
        </div>

        <div class="mb-4">
            <label for="notes" class="block mb-2 font-bold">Notes (Optional)</label>
            <textarea 
                id="notes" 
                name="notes" 
                rows="3"
                class="w-full bg-transparent border rounded px-4 py-2"
                placeholder="Additional notes about this lecture..."
            >{{ old('notes') }}</textarea>
        </div>

        <div class="mb-6">
            <h3 class="font-bold mb-3">Chapters Covered</h3>
            <p class="text-sm opacity-75 mb-4">Select which chapters this lecture covers and specify the coverage percentage for each</p>
            
            <div id="chapters-container" class="space-y-3">
                @foreach($chapters as $index => $chapter)
                    <div class="border rounded p-3 flex items-center gap-3">
                        <input 
                            type="checkbox" 
                            id="chapter_{{ $chapter->id }}" 
                            name="chapters[{{ $index }}][id]" 
                            value="{{ $chapter->id }}"
                            class="w-5 h-5"
                            onchange="toggleCoverageInput(this, {{ $chapter->id }})"
                        >
                        <label for="chapter_{{ $chapter->id }}" class="flex-1 font-bold">
                            {{ $chapter->name }}
                            <span class="text-sm opacity-75 ml-2">(Currently {{ number_format($chapter->completion_percentage, 1) }}% complete)</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input 
                                type="number" 
                                id="coverage_{{ $chapter->id }}"
                                name="chapters[{{ $index }}][coverage]" 
                                min="0" 
                                max="100"
                                step="0.1"
                                disabled
                                class="w-24 bg-transparent border rounded px-3 py-1 text-sm"
                                placeholder="0"
                            >
                            <span class="text-sm">%</span>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($chapters->isEmpty())
                <p class="text-center opacity-75 py-4">No chapters available. <a href="{{ route('chapters.create', $subject) }}" class="underline">Create a chapter first</a></p>
            @endif
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-primary px-6 py-2 rounded">Add Lecture</button>
            <a href="{{ route('subjects.show', $subject) }}" class="border px-6 py-2 rounded hover:opacity-75">Cancel</a>
        </div>
    </form>
</div>

<script>
function toggleCoverageInput(checkbox, chapterId) {
    const coverageInput = document.getElementById(`coverage_${chapterId}`);
    coverageInput.disabled = !checkbox.checked;
    if (!checkbox.checked) {
        coverageInput.value = '';
    }
}
</script>
@endsection