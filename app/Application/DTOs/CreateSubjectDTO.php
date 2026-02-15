<?php

namespace App\Application\DTOs;

class CreateSubjectDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly string $name,
        public readonly ?array $progressWeights = null
    ) {}

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'name' => $this->name,
            'progress_weights' => $this->progressWeights ?? [
                'chapters' => 0.40,
                'sections' => 0.20,
                'labs' => 0.20,
                'project' => 0.20
            ]
        ];
    }
}