<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('plan_id');
            $table->uuid('uuid')->nullable();
            $table->string('cnpj')->unique();
            $table->enum('type', ['J', 'F'])->default('J');
            $table->string('name')->unique();
            $table->string('url')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('logo')->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('number')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->json('data')->nullable();
            $table->enum('open', ['Y', 'N'])->default('N');
            $table->integer('order_when_closed')->default(0);
            // Status tenant (se inativar 'N' ele perde o acesso ao sistema)
            $table->enum('active', ['Y', 'N'])->default('Y');

            // Subscription
            $table->date('subscription')->nullable(); // Data que se inscreveu
            $table->date('expires_at')->nullable(); // Data que expira o acesso
            $table->string('subscription_id', 255)->nullable(); // Identificado do Gateway de pagamento
            $table->boolean('subscription_active')->default(false); // Assinatura ativa (porque pode cancelar)
            $table->boolean('subscription_suspended')->default(false); // Assinatura cancelada

            $table->timestamps();


            $table->foreign('plan_id')->references('id')->on('plans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
    }
}
