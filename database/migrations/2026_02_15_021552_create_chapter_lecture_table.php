<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chapter_lecture', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chapter_id')->constrained()->onDelete('cascade');
            $table->foreignId('lecture_id')->constrained()->onDelete('cascade');
            $table->decimal('coverage_percentage', 5, 2)->default(0); // KEY FIELD
            $table->timestamps();
            
            $table->unique(['chapter_id', 'lecture_id']);
            $table->index('lecture_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chapter_lecture');
    }
};