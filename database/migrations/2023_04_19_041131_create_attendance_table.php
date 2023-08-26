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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->decimal('check_in_latitude', 10, 8)->nullable();
            $table->decimal('check_in_longitude', 11, 8)->nullable();
            $table->time('check_in_time')->nullable();
            $table->date('check_in_date')->nullable();
            $table->decimal('check_out_latitude', 10, 8)->nullable();
            $table->decimal('check_out_longitude', 11, 8)->nullable();
            $table->time('check_out_time')->nullable();
            $table->date('check_out_date')->nullable();
            $table->bigInteger('work_hours')->nullable();
            $table->bigInteger('overtime')->nullable();
            $table->enum('status',['Present','Late','Holiday','Leave','Absent','Permission'])->nullable();
            $table->string('photo_in')->nullable();
            $table->string('photo_out')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};
