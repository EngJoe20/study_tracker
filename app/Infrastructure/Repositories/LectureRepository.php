<?php

namespace App\Infrastructure\Repositories;

use App\Domains\Lecture\Lecture;
use Illuminate\Support\Collection;

class LectureRepository
{
    public function findById(int $id): ?Lecture
    {
        return Lecture::with('chapters')->find($id);
    }

    public function findBySubject(int $subjectId): Collection
    {
        return Lecture::where('subject_id', $subjectId)
            ->orderBy('date', 'desc')
            ->get();
    }

    public function create(array $data): Lecture
    {
        return Lecture::create($data);
    }

    public function update(Lecture $lecture, array $data): Lecture
    {
        $lecture->update($data);
        return $lecture->fresh();
    }
}