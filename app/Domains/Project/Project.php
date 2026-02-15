<?php

namespace App\Domains\Project;

use App\Domains\Subject\Subject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'subject_id',
        'name',
        'description',
        'deadline',
        'progress',
        'status'
    ];

    protected $casts = [
        'deadline' => 'date',
        'progress' => 'decimal:2'
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function updateProgress(float $progress): void
    {
        $this->progress = min($progress, 100);
        $this->updateStatus();
        $this->save();
    }

    private function updateStatus(): void
    {
        if ($this->progress == 0) {
            $this->status = 'not_started';
        } elseif ($this->progress >= 100) {
            $this->status = 'completed';
        } else {
            $this->status = 'in_progress';
        }
    }
}