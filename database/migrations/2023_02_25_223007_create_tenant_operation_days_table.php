<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantOperationDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenant_operation_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->unsignedBigInteger('operation_day_id')->nullable();
            $table->json('data')->nullable();
            $table->integer('status')->default(0)->comment("0 - disbled | 1 - enabled");
            $table->timestamps();

            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants');

            $table->foreign('operation_day_id')
                ->references('id')
                ->on('operation_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenant_operation_days');
    }
}
