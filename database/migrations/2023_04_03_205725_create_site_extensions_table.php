<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteExtensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_extensions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description')->nullable();
            $table->string('detail')->nullable();
            $table->string('image')->nullable();
            $table->string('route_base')->nullable();
            $table->string('integration')->nullable();
            $table->json('data')->nullable();
            $table->integer('status')->default(0)->comment("0 - disableb | 1 - enabled");
            $table->integer('free')->default(1)->comment("0 - notfree | 1 - free");
            $table->string('tag')->nullable();
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
        Schema::dropIfExists('site_extensions');
    }
}
