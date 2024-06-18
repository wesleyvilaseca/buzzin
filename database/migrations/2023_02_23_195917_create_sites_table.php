<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tenant_id');
            $table->string('domain')->nullable();
            $table->string('subdomain')->nullable();
            $table->string('url')->nullable();
            $table->json('data')->nullable();
            $table->integer('maintence')->default(1)->comment("0 - desabled maintence | 1 - enabled maintence");
            $table->integer('status_domain')->default(0)->comment("0 - waiting aprove | 1 - aproved and implanted | 2 - disabled per adm");
            $table->integer('status')->default(0)->comment("0 - waiting aprove | 1 - aproved and implanted | 2 - disabled per adm");
            $table->string('recaptcha_key', 300)->nullable();
            $table->string('recaptcha_secret_key', 300)->nullable();
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
        Schema::dropIfExists('sites');
    }
}
