<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_shippings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('shipping_id')->nullable();
            $table->string('alias', 200)->nullable();
            $table->json('data')->nullable();
            $table->integer('status')->default(0)->comment("0 - disbled | 1 - enabled");
            $table->timestamps();

            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants');

            $table->foreign('shipping_id')
                ->references('id')
                ->on('shippings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_shippings');
    }
}
