<?php

namespace App\Application\UseCases;

use App\Infrastructure\Repositories\SubjectRepository;

class CalculateSubjectProgressUseCase
{
    public function __construct(
        private SubjectRepository $repository
    ) {}

    public function execute(int $subjectId): float
    {
        $subject = $this->repository->findById($subjectId);
        
        if (!$subject) {
            throw new \Exception("Subject not found");
        }

        $subject->updateProgress();
        
        return $subject->total_progress;
    }
}