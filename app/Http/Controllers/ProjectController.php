<?php

namespace App\Http\Controllers;

use App\Domains\Project\Project;
use App\Infrastructure\Repositories\SubjectRepository;
use App\Application\UseCases\CalculateSubjectProgressUseCase;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        private SubjectRepository $subjectRepository,
        private CalculateSubjectProgressUseCase $progressUseCase
    ) {}

    public function create(int $subjectId)
    {
        $subject = $this->subjectRepository->findById($subjectId);
        return view('projects.create', compact('subject'));
    }

    public function store(Request $request, int $subjectId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'progress' => 'nullable|numeric|min:0|max:100'
        ]);

        $validated['subject_id'] = $subjectId;
        
        $project = Project::create($validated);

        // Recalculate subject progress
        $this->progressUseCase->execute($subjectId);

        return redirect()->route('subjects.show', $subjectId)
            ->with('success', 'Project created successfully');
    }

    public function edit(int $id)
    {
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'progress' => 'nullable|numeric|min:0|max:100'
        ]);

        $project = Project::findOrFail($id);
        $project->updateProgress($validated['progress'] ?? 0);
        $project->update($validated);

        // Recalculate subject progress
        $this->progressUseCase->execute($project->subject_id);

        return redirect()->route('subjects.show', $project->subject_id)
            ->with('success', 'Project updated successfully');
    }

    public function destroy(int $id)
    {
        $project = Project::findOrFail($id);
        $subjectId = $project->subject_id;
        $project->delete();

        // Recalculate subject progress
        $this->progressUseCase->execute($subjectId);

        return redirect()->route('subjects.show', $subjectId)
            ->with('success', 'Project deleted successfully');
    }

    public function updateProgress(Request $request, int $id)
    {
        $validated = $request->validate([
            'progress' => 'required|numeric|min:0|max:100'
        ]);

        $project = Project::findOrFail($id);
        $project->updateProgress($validated['progress']);

        // Recalculate subject progress
        $this->progressUseCase->execute($project->subject_id);

        return response()->json([
            'success' => true,
            'progress' => $project->progress,
            'status' => $project->status
        ]);
    }
}