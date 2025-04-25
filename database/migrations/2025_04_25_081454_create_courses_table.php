<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('description')->nullable();
            $table->float('duration')->default('0');
            $table->unsignedBigInteger('likes')->default(0)->index();
            $table->unsignedBigInteger('dislikes')->default(0)->index();
            $table->dateTime('end_date')->nullable();
            $table->smallInteger('year')->index();
            $table->smallInteger('section')->index();
            $table->foreignId('subject_id')->constrained('subjects');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
