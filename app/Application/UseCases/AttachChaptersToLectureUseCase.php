<?php

namespace App\Application\UseCases;

use App\Domains\Lecture\Lecture;
use App\Infrastructure\Repositories\LectureRepository;

class AttachChaptersToLectureUseCase
{
    public function __construct(
        private LectureRepository $repository
    ) {}

    /**
     * @param int $lectureId
     * @param array $chaptersData [chapter_id => coverage_percentage]
     */
    public function execute(int $lectureId, array $chaptersData): void
    {
        $lecture = $this->repository->findById($lectureId);
        
        if (!$lecture) {
            throw new \Exception("Lecture not found");
        }

        $lecture->attachChaptersWithCoverage($chaptersData);
    }
}