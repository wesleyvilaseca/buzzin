<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zones', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->string('name');
            $table->point('location')->nullable();
            $table->polygon('coordinates')->nullable();
            $table->string('delivery_time_ini')->nullable();
            $table->string('delivery_time_end')->nullable();
            $table->integer('time_type')->default(1);
            $table->integer('active')->default(1);
            $table->integer('type')->default(1);
            $table->integer('free')->nullable();
            $table->double('free_when')->nullable();
            $table->double('price')->nullable();
            $table->timestamps();

            $table->foreign('tenant_id')
                ->references('id')
                ->on('tenants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('zones');
    }
}
