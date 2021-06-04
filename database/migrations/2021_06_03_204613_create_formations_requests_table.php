<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formations_requests', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_surname');
            $table->string('client_email');
            $table->integer('client_number');
            $table->unsignedBigInteger('formation_id')->nullable();
            $table->boolean('Accpted')->default(0);
            $table->foreign('formation_id')->references('id')->on('formations')->onDelete('cascade');
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
        Schema::dropIfExists('formations_requests');
    }
}
