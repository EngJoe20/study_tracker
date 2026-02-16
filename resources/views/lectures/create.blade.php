@extends('layouts.app')

@section('title', 'Add Lecture')

@section('content')
<div class="max-w-4xl mx-auto animate-slide-in">
    <div class="mb-6">
        <h1 class="text-4xl font-bold mb-2">
            <i class="fas fa-chalkboard-teacher mr-2"></i>
            Add Lecture
        </h1>
        <p class="opacity-75">Record a new lecture for <strong>{{ $subject->name }}</strong></p>
    </div>

    <form action="{{ route('lectures.store', $subject) }}" method="POST" class="card">
        @csrf

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
                    placeholder="e.g., Introduction to Binary Search Trees"
                    value="{{ old('name') }}"
                    autofocus
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
                    <option value="lecture" {{ old('type') === 'lecture' ? 'selected' : '' }}>🎓 Lecture</option>
                    <option value="section" {{ old('type') === 'section' ? 'selected' : '' }}>👥 Section</option>
                    <option value="lab" {{ old('type') === 'lab' ? 'selected' : '' }}>🔬 Lab</option>
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
                    value="{{ old('date', date('Y-m-d')) }}"
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
                    placeholder="90"
                    value="{{ old('duration') }}"
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
                placeholder="Any additional notes about this lecture..."
            >{{ old('notes') }}</textarea>
        </div>

        <!-- Chapters Coverage -->
        <div class="mb-6">
            <h3 class="font-bold mb-3 text-lg flex items-center">
                <i class="fas fa-book-open mr-2"></i>
                Chapters Covered
            </h3>
            <p class="text-sm opacity-75 mb-4">
                Select which chapters this lecture covers and specify the coverage percentage for each.
                <strong>Total coverage can exceed 100%</strong> if multiple lectures cover the same chapter.
            </p>
            
            @if($chapters->isNotEmpty())
                <div id="chapters-container" class="space-y-3">
                    @foreach($chapters as $index => $chapter)
                        <div class="border rounded-lg p-4 hover:bg-black hover:bg-opacity-10 transition" style="border-color: rgba(255, 255, 255, 0.2);">
                            <div class="flex items-center gap-4">
                                <input 
                                    type="checkbox" 
                                    id="chapter_{{ $chapter->id }}" 
                                    name="chapters[{{ $index }}][id]" 
                                    value="{{ $chapter->id }}"
                                    class="w-5 h-5 cursor-pointer"
                                    onchange="toggleCoverageInput(this, {{ $chapter->id }})"
                                    {{ old("chapters.$index.id") == $chapter->id ? 'checked' : '' }}
                                >
                                <label for="chapter_{{ $chapter->id }}" class="flex-1 cursor-pointer">
                                    <div class="font-bold">{{ $chapter->name }}</div>
                                    <div class="text-sm opacity-75 mt-1">
                                        <span class="badge text-xs {{ $chapter->status === 'completed' ? 'bg-green-500' : ($chapter->status === 'in_progress' ? 'bg-yellow-500' : 'bg-gray-500') }} text-white">
                                            {{ ucfirst(str_replace('_', ' ', $chapter->status)) }}
                                        </span>
                                        <span class="ml-2">Currently {{ number_format($chapter->completion_percentage, 1) }}% complete</span>
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
                                        {{ old("chapters.$index.id") == $chapter->id ? '' : 'disabled' }}
                                        class="w-28 bg-transparent border rounded px-3 py-2 text-center"
                                        placeholder="0.0"
                                        value="{{ old("chapters.$index.coverage") }}"
                                    >
                                    <span class="font-bold">%</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 border rounded-lg" style="border-color: rgba(255, 255, 255, 0.2);">
                    <i class="fas fa-book text-4xl mb-3 opacity-50"></i>
                    <p class="opacity-75 mb-3">No chapters available for this subject.</p>
                    <a href="{{ route('chapters.create', $subject) }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i>
                        Create a Chapter First
                    </a>
                </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-6 border-t" style="border-color: rgba(255, 255, 255, 0.1);">
            <button type="submit" class="btn btn-primary flex items-center">
                <i class="fas fa-check mr-2"></i>
                Add Lecture
            </button>
            <a href="{{ route('subjects.show', $subject) }}" class="btn border">
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