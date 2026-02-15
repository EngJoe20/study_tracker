<?php

namespace App\Application\UseCases;

use App\Application\DTOs\CreateSubjectDTO;
use App\Domains\Subject\Subject;
use App\Infrastructure\Repositories\SubjectRepository;

class CreateSubjectUseCase
{
    public function __construct(
        private SubjectRepository $repository
    ) {}

    public function execute(CreateSubjectDTO $dto): Subject
    {
        return $this->repository->create($dto->toArray());
    }
}