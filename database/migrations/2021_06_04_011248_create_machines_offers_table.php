<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines_offers', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_surname');
            $table->string('client_email');
            $table->integer('client_number');
            $table->integer('client_offer');
            $table->unsignedBigInteger('machine_id')->nullable();
            $table->boolean('Accpted')->default(0);
            $table->boolean('hasAcceptedOffer')->default(0);
            $table->boolean('hasRefusedOffer')->default(0);
            $table->foreign('machine_id')->references('id')->on('machines')->onDelete('cascade');

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
        Schema::dropIfExists('machines_offers');
    }
}
