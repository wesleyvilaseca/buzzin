<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDashboardExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dashboard_extensions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description')->nullable();
            $table->text('detail')->nullable();
            $table->string('image', 200)->nullable();
            $table->string('route_base')->nullable();
            $table->string('alias', 200)->nullable();
            $table->json('data')->nullable();
            $table->string('integration')->nullable();
            $table->integer('status')->default(0)->comment("0 - disableb | 1 - enabled");
            $table->integer('free')->default(1)->comment("0 - notfree | 1 - free");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dashboard_extensions');
    }
}
