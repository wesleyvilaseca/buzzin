<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CategoryProductMarket extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('category_product_market', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_market_id');
            $table->unsignedBigInteger('product_market_id');

            $table->foreign('category_market_id')
                ->references('id')
                ->on('category_markets')
                ->onDelete('cascade');
            $table->foreign('product_market_id')
                ->references('id')
                ->on('product_markets')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('category_product_market');
    }
}
