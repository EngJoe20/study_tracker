@extends('layouts.app')

@section('title', 'Edit Lecture')

@section('content')
<div class="max-w-4xl mx-auto animate-slide-in">
    <div class="mb-6">
        <h1 class="text-4xl font-bold mb-2">
            <i class="fas fa-edit mr-2"></i>
            Edit Lecture
        </h1>
        <p class="opacity-75">Update lecture information and chapter coverage</p>
    </div>

    <form action="{{ route('lectures.update', $lecture) }}" method="POST" class="card">
        @csrf
        @method('PUT')

        <!-- Lecture Basic Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="md:col-span-2">
                <label for="name" class="block mb-2 font-bold text-lg">
                    <i class="fas fa-heading mr-2"></i>
                    Lecture Title
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    required 
                    class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
                    value="{{ old('name', $lecture->name) }}"
                >
            </div>

            <div>
                <label for="type" class="block mb-2 font-bold">
                    <i class="fas fa-tag mr-2"></i>
                    Type
                </label>
                <select 
                    id="type" 
                    name="type" 
                    required 
                    class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
                >
                    <option value="lecture" {{ old('type', $lecture->type) === 'lecture' ? 'selected' : '' }}>🎓 Lecture</option>
                    <option value="section" {{ old('type', $lecture->type) === 'section' ? 'selected' : '' }}>👥 Section</option>
                    <option value="lab" {{ old('type', $lecture->type) === 'lab' ? 'selected' : '' }}>🔬 Lab</option>
                </select>
            </div>

            <div>
                <label for="date" class="block mb-2 font-bold">
                    <i class="fas fa-calendar mr-2"></i>
                    Date
                </label>
                <input 
                    type="date" 
                    id="date" 
                    name="date" 
                    class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
                    value="{{ old('date', $lecture->date?->format('Y-m-d')) }}"
                >
            </div>

            <div class="md:col-span-2">
                <label for="duration" class="block mb-2 font-bold">
                    <i class="fas fa-clock mr-2"></i>
                    Duration (minutes)
                </label>
                <input 
                    type="number" 
                    id="duration" 
                    name="duration" 
                    min="0"
                    class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
                    value="{{ old('duration', $lecture->duration) }}"
                >
            </div>
        </div>

        <!-- Notes -->
        <div class="mb-6">
            <label for="notes" class="block mb-2 font-bold text-lg">
                <i class="fas fa-sticky-note mr-2"></i>
                Notes (Optional)
            </label>
            <textarea 
                id="notes" 
                name="notes" 
                rows="3"
                class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
            >{{ old('notes', $lecture->notes) }}</textarea>
        </div>

        <!-- Chapters Coverage -->
        <div class="mb-6">
            <h3 class="font-bold mb-3 text-lg flex items-center">
                <i class="fas fa-book-open mr-2"></i>
                Chapters Covered
            </h3>
            <p class="text-sm opacity-75 mb-4">
                Update which chapters this lecture covers and their coverage percentages
            </p>
            
            <div id="chapters-container" class="space-y-3">
                @foreach($chapters as $index => $chapter)
                    @php
                        $currentCoverage = $lecture->chapters->firstWhere('id', $chapter->id);
                        $isChecked = $currentCoverage !== null;
                        $coverageValue = $currentCoverage?->pivot->coverage_percentage ?? '';
                    @endphp
                    <div class="border rounded-lg p-4 hover:bg-black hover:bg-opacity-10 transition" style="border-color: rgba(255, 255, 255, 0.2);">
                        <div class="flex items-center gap-4">
                            <input 
                                type="checkbox" 
                                id="chapter_{{ $chapter->id }}" 
                                name="chapters[{{ $index }}][id]" 
                                value="{{ $chapter->id }}"
                                class="w-5 h-5 cursor-pointer"
                                onchange="toggleCoverageInput(this, {{ $chapter->id }})"
                                {{ $isChecked ? 'checked' : '' }}
                            >
                            <label for="chapter_{{ $chapter->id }}" class="flex-1 cursor-pointer">
                                <div class="font-bold">{{ $chapter->name }}</div>
                                <div class="text-sm opacity-75 mt-1">
                                    Currently {{ number_format($chapter->completion_percentage, 1) }}% complete overall
                                </div>
                            </label>
                            <div class="flex items-center gap-2">
                                <input 
                                    type="number" 
                                    id="coverage_{{ $chapter->id }}"
                                    name="chapters[{{ $index }}][coverage]" 
                                    min="0" 
                                    max="100"
                                    step="0.1"
                                    {{ $isChecked ? '' : 'disabled' }}
                                    class="w-28 bg-transparent border rounded px-3 py-2 text-center"
                                    placeholder="0.0"
                                    value="{{ $coverageValue }}"
                                >
                                <span class="font-bold">%</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-6 border-t" style="border-color: rgba(255, 255, 255, 0.1);">
            <button type="submit" class="btn btn-primary flex items-center">
                <i class="fas fa-save mr-2"></i>
                Save Changes
            </button>
            <a href="{{ route('subjects.show', $lecture->subject_id) }}" class="btn border">
                <i class="fas fa-times mr-2"></i>
                Cancel
            </a>
        </div>
    </form>
</div>

<script>
function toggleCoverageInput(checkbox, chapterId) {
    const coverageInput = document.getElementById(`coverage_${chapterId}`);
    coverageInput.disabled = !checkbox.checked;
    if (!checkbox.checked) {
        coverageInput.value = '';
    } else {
        coverageInput.focus();
    }
}
</script>
@endsection