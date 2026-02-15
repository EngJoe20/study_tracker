<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Domains\Subject\Subject;
use App\Domains\Chapter\Chapter;
use App\Domains\Lecture\Lecture;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RealLifeScenariosTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function scenario_one_lecture_covers_multiple_chapters()
    {
        $user = User::factory()->create();
        $subject = Subject::create([
            'user_id' => $user->id,
            'name' => 'Test Subject'
        ]);

        $ch1 = Chapter::create(['subject_id' => $subject->id, 'name' => 'Chapter 1', 'order' => 1]);
        $ch2 = Chapter::create(['subject_id' => $subject->id, 'name' => 'Chapter 2', 'order' => 2]);

        $lecture = Lecture::create([
            'subject_id' => $subject->id,
            'type' => 'lecture',
            'name' => 'Combined Lecture'
        ]);

        // One lecture covers Chapter 1 completely and Chapter 2 partially
        $lecture->chapters()->attach([
            $ch1->id => ['coverage_percentage' => 100],
            $ch2->id => ['coverage_percentage' => 40]
        ]);

        $ch1->calculateCompletion();
        $ch2->calculateCompletion();

        $this->assertEquals(100, $ch1->completion_percentage);
        $this->assertEquals('completed', $ch1->status);
        $this->assertEquals(40, $ch2->completion_percentage);
        $this->assertEquals('in_progress', $ch2->status);
    }

    /** @test */
    public function scenario_one_chapter_across_multiple_lectures()
    {
        $user = User::factory()->create();
        $subject = Subject::create([
            'user_id' => $user->id,
            'name' => 'Test Subject'
        ]);

        $chapter = Chapter::create(['subject_id' => $subject->id, 'name' => 'Big Chapter', 'order' => 1]);

        $lec1 = Lecture::create(['subject_id' => $subject->id, 'type' => 'lecture', 'name' => 'Lecture 1']);
        $lec2 = Lecture::create(['subject_id' => $subject->id, 'type' => 'lecture', 'name' => 'Lecture 2']);
        $lec3 = Lecture::create(['subject_id' => $subject->id, 'type' => 'lecture', 'name' => 'Lecture 3']);

        // Chapter covered across 3 lectures: 30% + 50% + 20% = 100%
        $lec1->chapters()->attach($chapter->id, ['coverage_percentage' => 30]);
        $chapter->calculateCompletion();
        $this->assertEquals(30, $chapter->fresh()->completion_percentage);

        $lec2->chapters()->attach($chapter->id, ['coverage_percentage' => 50]);
        $chapter->calculateCompletion();
        $this->assertEquals(80, $chapter->fresh()->completion_percentage);

        $lec3->chapters()->attach($chapter->id, ['coverage_percentage' => 20]);
        $chapter->calculateCompletion();
        $this->assertEquals(100, $chapter->fresh()->completion_percentage);
        $this->assertEquals('completed', $chapter->fresh()->status);
    }

    /** @test */
    public function scenario_weighted_progress_calculation()
    {
        $user = User::factory()->create();
        $subject = Subject::create([
            'user_id' => $user->id,
            'name' => 'Project-Heavy Subject',
            'progress_weights' => [
                'chapters' => 0.30,
                'sections' => 0.10,
                'labs' => 0.10,
                'project' => 0.50
            ]
        ]);

        // Add chapters
        $ch1 = Chapter::create(['subject_id' => $subject->id, 'name' => 'Ch1', 'order' => 1, 'completion_percentage' => 100, 'status' => 'completed']);
        $ch2 = Chapter::create(['subject_id' => $subject->id, 'name' => 'Ch2', 'order' => 2, 'completion_percentage' => 50, 'status' => 'in_progress']);
        // Average chapters: 75%

        // Add project
        \App\Domains\Project\Project::create([
            'subject_id' => $subject->id,
            'name' => 'Final Project',
            'progress' => 80
        ]);

        $subject->updateProgress();

        // Expected: (75 * 0.3) + (0 * 0.1) + (0 * 0.1) + (80 * 0.5) = 22.5 + 40 = 62.5
        $this->assertEquals(62.5, $subject->fresh()->total_progress);
    }
}