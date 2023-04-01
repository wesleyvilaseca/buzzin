<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->json('data')->nullable();
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
            $table->string('type_transaction')->nullable()->comment('site_ext', 'painel_ext', 'subscription');
            
            $table->timestamps();
            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants')
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
        Schema::dropIfExists('transactions');
    }
}
