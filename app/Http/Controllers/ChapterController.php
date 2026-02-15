<?php

namespace App\Http\Controllers;

use App\Domains\Chapter\Chapter;
use App\Infrastructure\Repositories\ChapterRepository;
use App\Infrastructure\Repositories\SubjectRepository;
use App\Application\UseCases\CalculateSubjectProgressUseCase;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function __construct(
        private ChapterRepository $chapterRepository,
        private SubjectRepository $subjectRepository,
        private CalculateSubjectProgressUseCase $progressUseCase
    ) {}

    public function create(int $subjectId)
    {
        $subject = $this->subjectRepository->findById($subjectId);
        return view('chapters.create', compact('subject'));
    }

    public function store(Request $request, int $subjectId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        $validated['subject_id'] = $subjectId;
        
        $chapter = $this->chapterRepository->create($validated);

        // Recalculate subject progress
        $this->progressUseCase->execute($subjectId);

        return redirect()->route('subjects.show', $subjectId)
            ->with('success', 'Chapter added successfully');
    }

    public function edit(int $id)
    {
        $chapter = $this->chapterRepository->findById($id);
        return view('chapters.edit', compact('chapter'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'nullable|integer|min:0',
            'notes' => 'nullable|string'
        ]);

        $chapter = $this->chapterRepository->findById($id);
        $this->chapterRepository->update($chapter, $validated);

        return redirect()->route('subjects.show', $chapter->subject_id)
            ->with('success', 'Chapter updated successfully');
    }

    public function destroy(int $id)
    {
        $chapter = $this->chapterRepository->findById($id);
        $subjectId = $chapter->subject_id;
        $chapter->delete();

        // Recalculate subject progress
        $this->progressUseCase->execute($subjectId);

        return redirect()->route('subjects.show', $subjectId)
            ->with('success', 'Chapter deleted successfully');
    }
}