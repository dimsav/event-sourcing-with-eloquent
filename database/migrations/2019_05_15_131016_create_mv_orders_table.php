<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMvOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mv_orders', function (Blueprint $table) {
            $table->string('id', '42')->primary();
            $table->integer('total');
            $table->bigInteger('buyer_id')->unsigned();
            $table->bigInteger('seller_id')->unsigned();
            $table->boolean('is_dispatched')->nullable();
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
        Schema::dropIfExists('mv_orders');
    }
}
