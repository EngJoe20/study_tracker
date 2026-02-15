<?php

namespace App\Domains\Subject;

use App\Domains\Chapter\Chapter;
use App\Domains\Lecture\Lecture;
use App\Domains\Project\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subject extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'status',
        'progress_weights',
        'total_progress'
    ];

    protected $casts = [
        'progress_weights' => 'array',
        'total_progress' => 'decimal:2'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class);
    }

    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class);
    }

    public function project(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Calculate total subject progress based on weighted components
     */
    public function calculateProgress(): float
    {
        $weights = $this->getProgressWeights();
        
        $chaptersProgress = $this->calculateChaptersProgress();
        $sectionsProgress = $this->calculateLecturesProgressByType('section');
        $labsProgress = $this->calculateLecturesProgressByType('lab');
        $projectProgress = $this->calculateProjectProgress();

        $totalProgress = 
            ($chaptersProgress * $weights['chapters']) +
            ($sectionsProgress * $weights['sections']) +
            ($labsProgress * $weights['labs']) +
            ($projectProgress * $weights['project']);

        return round($totalProgress, 2);
    }

    private function getProgressWeights(): array
    {
        return $this->progress_weights ?? [
            'chapters' => 0.40,
            'sections' => 0.20,
            'labs' => 0.20,
            'project' => 0.20
        ];
    }

    private function calculateChaptersProgress(): float
    {
        $chapters = $this->chapters;
        
        if ($chapters->isEmpty()) {
            return 0;
        }

        $totalCompletion = $chapters->sum('completion_percentage');
        return $totalCompletion / $chapters->count();
    }

    private function calculateLecturesProgressByType(string $type): float
    {
        $lectures = $this->lectures()->where('type', $type)->get();
        
        if ($lectures->isEmpty()) {
            return 0;
        }

        // For sections/labs, we consider them completed or not
        // More sophisticated logic can be added
        $completed = $lectures->filter(function ($lecture) {
            return $lecture->chapters()->wherePivot('coverage_percentage', '>', 0)->exists();
        })->count();

        return ($completed / $lectures->count()) * 100;
    }

    private function calculateProjectProgress(): float
    {
        $projects = $this->project;
        
        if ($projects->isEmpty()) {
            return 0;
        }

        return $projects->avg('progress') ?? 0;
    }

    public function updateProgress(): void
    {
        $this->total_progress = $this->calculateProgress();
        $this->save();
    }
}