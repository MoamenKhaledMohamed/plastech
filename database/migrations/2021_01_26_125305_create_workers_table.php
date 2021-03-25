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
            $table->float("total_time")->nullable();
            $table->float("my_total_time")->nullable();
            $table->float("weight")->nullable();
            $table->float("my_weight")->nullable();
            $table->integer("number_of_orders")->nullable();
            $table->integer("my_number_of_orders")->nullable();
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
