<?php

namespace App\Http\Controllers;

use App\Domains\Lecture\Lecture;
use App\Infrastructure\Repositories\LectureRepository;
use App\Infrastructure\Repositories\SubjectRepository;
use App\Infrastructure\Repositories\ChapterRepository;
use App\Application\UseCases\AttachChaptersToLectureUseCase;
use App\Application\UseCases\CalculateSubjectProgressUseCase;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function __construct(
        private LectureRepository $lectureRepository,
        private SubjectRepository $subjectRepository,
        private ChapterRepository $chapterRepository,
        private AttachChaptersToLectureUseCase $attachChaptersUseCase,
        private CalculateSubjectProgressUseCase $progressUseCase
    ) {}

    public function create(int $subjectId)
    {
        $subject = $this->subjectRepository->findById($subjectId);
        $chapters = $this->chapterRepository->findBySubject($subjectId);
        
        return view('lectures.create', compact('subject', 'chapters'));
    }

    public function store(Request $request, int $subjectId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:lecture,section,lab',
            'date' => 'nullable|date',
            'duration' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
            'chapters' => 'nullable|array',
            'chapters.*.id' => 'required|exists:chapters,id',
            'chapters.*.coverage' => 'required|numeric|min:0|max:100'
        ]);

        $validated['subject_id'] = $subjectId;
        
        $lecture = $this->lectureRepository->create($validated);

        // Attach chapters with coverage
        if (isset($validated['chapters'])) {
            $chaptersData = [];
            foreach ($validated['chapters'] as $chapterData) {
                $chaptersData[$chapterData['id']] = $chapterData['coverage'];
            }
            
            $this->attachChaptersUseCase->execute($lecture->id, $chaptersData);
        }

        // Recalculate subject progress
        $this->progressUseCase->execute($subjectId);

        return redirect()->route('subjects.show', $subjectId)
            ->with('success', 'Lecture created successfully');
    }

    public function edit(int $id)
    {
        $lecture = $this->lectureRepository->findById($id);
        $chapters = $this->chapterRepository->findBySubject($lecture->subject_id);
        
        return view('lectures.edit', compact('lecture', 'chapters'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:lecture,section,lab',
            'date' => 'nullable|date',
            'duration' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
            'chapters' => 'nullable|array',
            'chapters.*.id' => 'required|exists:chapters,id',
            'chapters.*.coverage' => 'required|numeric|min:0|max:100'
        ]);

        $lecture = $this->lectureRepository->findById($id);
        $this->lectureRepository->update($lecture, $validated);

        // Update chapters with coverage
        if (isset($validated['chapters'])) {
            $chaptersData = [];
            foreach ($validated['chapters'] as $chapterData) {
                $chaptersData[$chapterData['id']] = $chapterData['coverage'];
            }
            
            $this->attachChaptersUseCase->execute($lecture->id, $chaptersData);
        }

        // Recalculate subject progress
        $this->progressUseCase->execute($lecture->subject_id);

        return redirect()->route('subjects.show', $lecture->subject_id)
            ->with('success', 'Lecture updated successfully');
    }

    public function destroy(int $id)
    {
        $lecture = $this->lectureRepository->findById($id);
        $subjectId = $lecture->subject_id;
        $lecture->delete();

        // Recalculate subject progress
        $this->progressUseCase->execute($subjectId);

        return redirect()->route('subjects.show', $subjectId)
            ->with('success', 'Lecture deleted successfully');
    }
}