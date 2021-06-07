<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawmaterialsRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rawmaterials_requests', function (Blueprint $table) {
            $table->id();
            $table->string('client_name');
            $table->string('client_surname');
            $table->string('client_email');
            $table->integer('client_number');
            $table->boolean('Accpted')->default(0);
            $table->unsignedBigInteger('rawmaterial_id')->nullable();
            $table->foreign('rawmaterial_id')->references('id')->on('raw_materials')->onDelete('cascade');
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
        Schema::dropIfExists('rawmaterials_requests');
    }
}
