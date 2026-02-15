<?php

namespace Database\Seeders;

use App\Models\User;
use App\Domains\Subject\Subject;
use App\Domains\Chapter\Chapter;
use App\Domains\Lecture\Lecture;
use App\Domains\Project\Project;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Demo User
        $user = User::factory()->create([
            'name' => 'Demo Student',
            'email' => 'demo@studytracker.com',
            'theme' => 'programmer'
        ]);

        // Subject 1: Data Structures & Algorithms
        $dsa = Subject::create([
            'user_id' => $user->id,
            'name' => 'Data Structures & Algorithms',
            'progress_weights' => [
                'chapters' => 0.50,
                'sections' => 0.20,
                'labs' => 0.20,
                'project' => 0.10
            ]
        ]);

        // Chapters for DSA
        $ch1 = Chapter::create(['subject_id' => $dsa->id, 'name' => 'Arrays & Strings', 'order' => 1]);
        $ch2 = Chapter::create(['subject_id' => $dsa->id, 'name' => 'Linked Lists', 'order' => 2]);
        $ch3 = Chapter::create(['subject_id' => $dsa->id, 'name' => 'Stacks & Queues', 'order' => 3]);
        $ch4 = Chapter::create(['subject_id' => $dsa->id, 'name' => 'Trees', 'order' => 4]);
        $ch5 = Chapter::create(['subject_id' => $dsa->id, 'name' => 'Graphs', 'order' => 5]);

        // Lecture 1: Covers Chapter 1 completely
        $lec1 = Lecture::create([
            'subject_id' => $dsa->id,
            'type' => 'lecture',
            'name' => 'Introduction to Arrays',
            'date' => now()->subDays(10),
            'duration' => 90
        ]);
        $lec1->chapters()->attach($ch1->id, ['coverage_percentage' => 100]);
        $ch1->calculateCompletion();

        // Lecture 2: Covers Chapter 2 (60%) and Chapter 3 (40%)
        $lec2 = Lecture::create([
            'subject_id' => $dsa->id,
            'type' => 'lecture',
            'name' => 'Linked Lists & Stack Introduction',
            'date' => now()->subDays(8),
            'duration' => 90
        ]);
        $lec2->chapters()->attach([
            $ch2->id => ['coverage_percentage' => 60],
            $ch3->id => ['coverage_percentage' => 40]
        ]);
        $ch2->calculateCompletion();
        $ch3->calculateCompletion();

        // Lecture 3: Completes Chapter 2 and adds to Chapter 3
        $lec3 = Lecture::create([
            'subject_id' => $dsa->id,
            'type' => 'lecture',
            'name' => 'Advanced Linked Lists & Queues',
            'date' => now()->subDays(6),
            'duration' => 90
        ]);
        $lec3->chapters()->attach([
            $ch2->id => ['coverage_percentage' => 40],
            $ch3->id => ['coverage_percentage' => 60]
        ]);
        $ch2->calculateCompletion();
        $ch3->calculateCompletion();

        // Lecture 4: Starts Chapter 4
        $lec4 = Lecture::create([
            'subject_id' => $dsa->id,
            'type' => 'lecture',
            'name' => 'Binary Trees Basics',
            'date' => now()->subDays(4),
            'duration' => 90
        ]);
        $lec4->chapters()->attach($ch4->id, ['coverage_percentage' => 50]);
        $ch4->calculateCompletion();

        // Lab Session
        $lab1 = Lecture::create([
            'subject_id' => $dsa->id,
            'type' => 'lab',
            'name' => 'Stack & Queue Implementation Lab',
            'date' => now()->subDays(3),
            'duration' => 120
        ]);
        $lab1->chapters()->attach($ch3->id, ['coverage_percentage' => 0]); // Just reference

        // Project
        Project::create([
            'subject_id' => $dsa->id,
            'name' => 'Binary Search Tree Implementation',
            'description' => 'Implement a complete BST with insert, delete, and search operations',
            'deadline' => now()->addDays(30),
            'progress' => 25
        ]);

        $dsa->updateProgress();

        // Subject 2: Web Development
        $web = Subject::create([
            'user_id' => $user->id,
            'name' => 'Full Stack Web Development',
            'progress_weights' => [
                'chapters' => 0.30,
                'sections' => 0.10,
                'labs' => 0.10,
                'project' => 0.50 // Project-heavy course
            ]
        ]);

        $webCh1 = Chapter::create(['subject_id' => $web->id, 'name' => 'HTML & CSS Fundamentals', 'order' => 1]);
        $webCh2 = Chapter::create(['subject_id' => $web->id, 'name' => 'JavaScript Basics', 'order' => 2]);
        $webCh3 = Chapter::create(['subject_id' => $web->id, 'name' => 'React Framework', 'order' => 3]);

        $webLec1 = Lecture::create([
            'subject_id' => $web->id,
            'type' => 'lecture',
            'name' => 'HTML5 & Modern CSS',
            'date' => now()->subDays(5),
            'duration' => 120
        ]);
        $webLec1->chapters()->attach($webCh1->id, ['coverage_percentage' => 100]);
        $webCh1->calculateCompletion();

        Project::create([
            'subject_id' => $web->id,
            'name' => 'E-Commerce Website',
            'description' => 'Build a full-stack e-commerce platform with React and Node.js',
            'deadline' => now()->addDays(60),
            'progress' => 40
        ]);

        $web->updateProgress();

        echo "✅ Database seeded successfully!\n";
        echo "📧 Login with: demo@studytracker.com\n";
        echo "🔑 Password: password\n";
    }
}