<?php

namespace App\Domains\Chapter;

use App\Domains\Subject\Subject;
use App\Domains\Lecture\Lecture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chapter extends Model
{
    protected $fillable = [
        'subject_id',
        'name',
        'order',
        'status',
        'completion_percentage',
        'notes'
    ];

    protected $casts = [
        'completion_percentage' => 'decimal:2'
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function lectures(): BelongsToMany
    {
        return $this->belongsToMany(Lecture::class)
            ->withPivot('coverage_percentage')
            ->withTimestamps();
    }

    /**
     * Calculate chapter completion based on all lecture coverages
     */
    public function calculateCompletion(): void
    {
        $totalCoverage = $this->lectures()
            ->sum('chapter_lecture.coverage_percentage');

        $this->completion_percentage = min($totalCoverage, 100);
        $this->updateStatus();
        $this->save();
    }

    private function updateStatus(): void
    {
        if ($this->completion_percentage == 0) {
            $this->status = 'not_started';
        } elseif ($this->completion_percentage >= 100) {
            $this->status = 'completed';
        } else {
            $this->status = 'in_progress';
        }
    }
}