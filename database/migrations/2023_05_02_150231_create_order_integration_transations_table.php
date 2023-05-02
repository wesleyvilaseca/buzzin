<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderIntegrationTransationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_integration_transations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->json('data')->nullable();
            $table->string('integration')->nullable();
            $table->string('description')->nullable();
            $table->float('transaction_amount')->nullable();
            $table->string('barcode')->nullable();
            $table->string('payment_method_id')->nullable();
            $table->string('payment_type_id')->nullable();
            $table->longtext('external_resource_url')->nullable();
            $table->float('total')->nullable();
            $table->string('last_four_digits', 4)->nullable();
            $table->string('status')->nullable();
            $table->string('status_detail')->nullable();
            $table->timestamps();

            $table->foreign('order_id')
                        ->references('id')
                        ->on('orders')
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
        Schema::dropIfExists('order_integration_transations');
    }
}
