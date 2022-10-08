<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answears', function (Blueprint $table) {
            $table->id();
            // $table->foreignId('activity_id')->constrained('activities');
            $table->foreignId('question_id')->constrained('questions');
            $table->foreignId('option_id')->nullable()->constrained('options');
            $table->text('content')->nullable();
            // $table->foreignId('')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('answears');
    }
};
