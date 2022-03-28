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
            $table->id();
            $table->unsignedBigInteger('tenants_id');
            $table->string('name')->unique();
            $table->polygon('coordinates')->nullable();
            $table->time('delivery_time_ini', $precision = 0)->nullable();
            $table->time('delivery_time_end', $precision = 0)->nullable();
            $table->enum('active', ['Y', 'N'])->default('Y');
            $table->timestamps();

            $table->foreign('tenants_id')
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
