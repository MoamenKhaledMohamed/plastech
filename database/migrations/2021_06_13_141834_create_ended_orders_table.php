<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndedOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ended_orders', function (Blueprint $table) {
            $table->id();
            $table->date('order_date')->nullable();
            $table->bigInteger('weight')->nullable();
            $table->bigInteger('earned_points')->nullable();
            $table->float('consumed_time')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('worker_id')->constrained();
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
        Schema::dropIfExists('ended_orders');
    }
}
