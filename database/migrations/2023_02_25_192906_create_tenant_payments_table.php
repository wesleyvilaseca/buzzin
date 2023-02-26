<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->json('data')->nullable();
            $table->integer('status')->default(0)->comment("0 - disbled | 1 - enabled");
            $table->timestamps();

            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants');

            $table->foreign('payment_id')
                ->references('id')
                ->on('payments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_payments');
    }
}
