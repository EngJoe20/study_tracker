@extends('layouts.app')

@section('title', 'Edit Chapter')

@section('content')
<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold mb-6">Edit Chapter</h1>

    <form action="{{ route('chapters.update', $chapter) }}" method="POST" class="card p-6">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block mb-2 font-bold">Chapter Name</label>
            <input 
                type="text" 
                id="name" 
                name="name" 
                required 
                class="w-full bg-transparent border rounded px-4 py-2"
                value="{{ old('name', $chapter->name) }}"
            >
        </div>

        <div class="mb-4">
            <label for="order" class="block mb-2 font-bold">Order</label>
            <input 
                type="number" 
                id="order" 
                name="order" 
                min="0"
                class="w-full bg-transparent border rounded px-4 py-2"
                value="{{ old('order', $chapter->order) }}"
            >
        </div>

        <div class="mb-6">
            <label for="notes" class="block mb-2 font-bold">Notes</label>
            <textarea 
                id="notes" 
                name="notes" 
                rows="4"
                class="w-full bg-transparent border rounded px-4 py-2"
            >{{ old('notes', $chapter->notes) }}</textarea>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="btn-primary px-6 py-2 rounded">Update Chapter</button>
            <a href="{{ route('subjects.show', $chapter->subject_id) }}" class="border px-6 py-2 rounded hover:opacity-75">Cancel</a>
        </div>
    </form>
</div>
@endsection