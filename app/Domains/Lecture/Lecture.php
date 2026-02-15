<?php

namespace App\Domains\Lecture;

use App\Domains\Subject\Subject;
use App\Domains\Chapter\Chapter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lecture extends Model
{
    protected $fillable = [
        'subject_id',
        'type',
        'name',
        'date',
        'duration',
        'notes'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function chapters(): BelongsToMany
    {
        return $this->belongsToMany(Chapter::class)
            ->withPivot('coverage_percentage')
            ->withTimestamps();
    }

    /**
     * Attach chapters with coverage percentages
     */
    public function attachChaptersWithCoverage(array $chaptersData): void
    {
        // $chaptersData = [chapter_id => coverage_percentage]
        $syncData = [];
        
        foreach ($chaptersData as $chapterId => $coverage) {
            $syncData[$chapterId] = ['coverage_percentage' => $coverage];
        }
        
        $this->chapters()->sync($syncData);
        
        // Recalculate affected chapters
        foreach (array_keys($chaptersData) as $chapterId) {
            $chapter = Chapter::find($chapterId);
            $chapter?->calculateCompletion();
        }
    }
}