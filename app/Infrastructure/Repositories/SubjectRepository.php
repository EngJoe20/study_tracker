<?php

namespace App\Infrastructure\Repositories;

use App\Domains\Subject\Subject;
use Illuminate\Support\Collection;

class SubjectRepository
{
    public function findById(int $id): ?Subject
    {
        return Subject::with(['chapters', 'lectures', 'project'])->find($id);
    }

    public function findByUser(int $userId): Collection
    {
        return Subject::where('user_id', $userId)
            ->with(['chapters', 'lectures', 'project'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    public function update(Subject $subject, array $data): Subject
    {
        $subject->update($data);
        return $subject->fresh();
    }

    public function delete(Subject $subject): bool
    {
        return $subject->delete();
    }
}