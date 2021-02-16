<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
          //  $table->foreignId('user_id')->constrained()->onDelete('cascade');
         //   $table->foreignId('location_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->dateTime('time');
            $table->string('detail')->nullable();
            $table->string('comment');
            $table->string('image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidents');
    }
}
