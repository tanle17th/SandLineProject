<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimecardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timecards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            // Google Maps returns the full location
            // Therefore, there is no need of extra location tables
            // Start/End Timecard Location by now will be just simple String.
            $table->string('start_location');
            $table->string('end_location')->nullable();
            $table->string('comment')->nullable();
            $table->time('total_hours')->nullable();
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
        Schema::dropIfExists('timecards');
    }
}
