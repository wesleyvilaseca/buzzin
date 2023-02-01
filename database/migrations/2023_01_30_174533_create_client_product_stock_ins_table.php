<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientProductStockInsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('client_product_stock_ins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('product_market_id');
            $table->string('nota', 100)->nullable();
            $table->double('price', 10, 2);
            $table->double('quantity', 10, 2);
            $table->text('anotation')->nullable();
            $table->unsignedBigInteger('weight_class_id')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('client_product_stock_ins');
    }
}
