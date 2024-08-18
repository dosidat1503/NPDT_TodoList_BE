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
        Schema::dropIfExists('tasks');
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements("TASK_ID"); 
            $table->string('NAME')->unique();
            $table->string('NOTE')->nullable();
            $table->string('DUEDATE')->nullable(); 
            $table->boolean('ISCOMPLETE')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    { 
    }
};
