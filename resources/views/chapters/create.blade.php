@extends('layouts.app')

@section('title', 'Add Chapter')

@section('content')
<div class="max-w-2xl mx-auto animate-slide-in">
    <div class="mb-6">
        <h1 class="text-4xl font-bold mb-2">
            <i class="fas fa-book-medical mr-2"></i>
            Add Chapter
        </h1>
        <p class="opacity-75">Add a new chapter to <strong>{{ $subject->name }}</strong></p>
    </div>

    <form action="{{ route('chapters.store', $subject) }}" method="POST" class="card">
        @csrf

        <!-- Chapter Name -->
        <div class="mb-6">
            <label for="name" class="block mb-2 font-bold text-lg">
                <i class="fas fa-heading mr-2"></i>
                Chapter Name
            </label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                required 
                class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
                placeholder="e.g., Binary Search Trees"
                value="{{ old('name') }}"
                autofocus
            >
        </div>

        <!-- Order -->
        <div class="mb-6">
            <label for="order" class="block mb-2 font-bold text-lg">
                <i class="fas fa-sort-numeric-down mr-2"></i>
                Order / Chapter Number
            </label>
            <input 
                type="number" 
                id="order" 
                name="order" 
                min="0"
                class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
                placeholder="e.g., 1, 2, 3..."
                value="{{ old('order', $subject->chapters->count() + 1) }}"
            >
            <p class="text-sm opacity-75 mt-1">The order in which this chapter appears</p>
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
                rows="4"
                class="w-full bg-transparent border rounded-lg px-4 py-3 focus:outline-none focus:ring-2"
                placeholder="Any additional notes about this chapter..."
            >{{ old('notes') }}</textarea>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 pt-6 border-t" style="border-color: rgba(255, 255, 255, 0.1);">
            <button type="submit" class="btn btn-primary flex items-center">
                <i class="fas fa-check mr-2"></i>
                Add Chapter
            </button>
            <a href="{{ route('subjects.show', $subject) }}" class="btn border">
                <i class="fas fa-times mr-2"></i>
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection