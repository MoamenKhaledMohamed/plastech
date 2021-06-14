<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('age');
            $table->integer('salary');
            $table->string('vehicle_type');
            $table->string('role');
            $table->string('government');
            $table->float("rating")->nullable();
            $table->integer("raters")->nullable();
            $table->float("my_weight")->nullable();
            $table->float("latitude")->default(37.77);
            $table->float("longitude")->default(-122.47);
            $table->integer("duration_in_seconds")->nullable();
            $table->float("distance_in_meters")->nullable();
            $table->boolean("status")->default(true);
            $table->date("time_changing_status")->nullable();
            $table->date("start_at")->nullable();
            $table->date("end_at")->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('workers');
    }
}
