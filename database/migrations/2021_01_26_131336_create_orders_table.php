<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamp('order_date')->nullable();
            $table->bigInteger('weight')->nullable();
            $table->bigInteger('point_earned')->nullable();
            $table->float('consumed_time')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('worker_id')->constrained();
            $table->boolean('is_ended')->default(false);
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
        Schema::dropIfExists('orders');
    }
}
