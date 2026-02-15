<?php

namespace App\Http\Controllers;

use App\Application\DTOs\CreateSubjectDTO;
use App\Application\UseCases\CreateSubjectUseCase;
use App\Application\UseCases\CalculateSubjectProgressUseCase;
use App\Infrastructure\Repositories\SubjectRepository;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct(
        private SubjectRepository $repository,
        private CreateSubjectUseCase $createUseCase,
        private CalculateSubjectProgressUseCase $progressUseCase
    ) {}

    public function index()
    {
        $subjects = $this->repository->findByUser(auth()->id());
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'chapters_weight' => 'nullable|numeric|min:0|max:1',
            'sections_weight' => 'nullable|numeric|min:0|max:1',
            'labs_weight' => 'nullable|numeric|min:0|max:1',
            'project_weight' => 'nullable|numeric|min:0|max:1',
        ]);

        $weights = null;
        if ($request->filled(['chapters_weight', 'sections_weight', 'labs_weight', 'project_weight'])) {
            $weights = [
                'chapters' => (float) $request->chapters_weight,
                'sections' => (float) $request->sections_weight,
                'labs' => (float) $request->labs_weight,
                'project' => (float) $request->project_weight,
            ];
        }

        $dto = new CreateSubjectDTO(
            userId: auth()->id(),
            name: $validated['name'],
            progressWeights: $weights
        );

        $subject = $this->createUseCase->execute($dto);

        return redirect()->route('subjects.show', $subject)
            ->with('success', 'Subject created successfully');
    }

    public function show(int $id)
    {
        $subject = $this->repository->findById($id);
        
        // Recalculate progress
        $this->progressUseCase->execute($id);
        $subject->refresh();
        
        return view('subjects.show', compact('subject'));
    }
}