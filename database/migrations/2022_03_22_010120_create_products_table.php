<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('status_product_no_stock_id');
            $table->uuid('uuid');
            $table->string('title');
            $table->string('flag');
            $table->text('image');
            $table->double('price', 10, 2);
            $table->double('min_for_sale', 10, 2)->default(1);
            $table->text('description');
            $table->double('quantity', 10, 2)->default(0);
            $table->integer('stock_controll')->default(0)->comment("0 disableb | 1 - enabled");
            $table->integer('status')->default(0)->comment("0 disableb | 1 - enabled");
            $table->timestamps();

            $table->foreign('status_product_no_stock_id')
            ->references('id')
            ->on('status_product_no_stocks');

            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
                ->onDelete('cascade');
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('product_id');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
