<?php

namespace App\Http\Controllers;

use App\Infrastructure\Repositories\SubjectRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        private SubjectRepository $subjectRepository
    ) {}

    public function index()
    {
        $subjects = $this->subjectRepository->findByUser(auth()->id());
        
        $stats = [
            'total_subjects' => $subjects->count(),
            'active_subjects' => $subjects->where('status', 'active')->count(),
            'completed_subjects' => $subjects->where('status', 'completed')->count(),
            'average_progress' => $subjects->avg('total_progress') ?? 0
        ];

        return view('dashboard', compact('subjects', 'stats'));
    }
}