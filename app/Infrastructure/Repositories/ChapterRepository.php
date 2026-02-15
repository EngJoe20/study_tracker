<?php

namespace App\Infrastructure\Repositories;

use App\Domains\Chapter\Chapter;
use Illuminate\Support\Collection;

class ChapterRepository
{
    public function findById(int $id): ?Chapter
    {
        return Chapter::with('lectures')->find($id);
    }

    public function findBySubject(int $subjectId): Collection
    {
        return Chapter::where('subject_id', $subjectId)
            ->orderBy('order')
            ->get();
    }

    public function create(array $data): Chapter
    {
        return Chapter::create($data);
    }

    public function update(Chapter $chapter, array $data): Chapter
    {
        $chapter->update($data);
        return $chapter->fresh();
    }
}