<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['lecture', 'section', 'lab'])->default('lecture');
            $table->string('name');
            $table->date('date')->nullable();
            $table->integer('duration')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['subject_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};