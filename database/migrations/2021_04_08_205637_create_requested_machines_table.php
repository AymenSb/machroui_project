<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestedMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_machines', function (Blueprint $table) {
            $table->id();
            $table->String('name'); //check
            $table->String('price');//check
            $table->String('Vendor')->nullable();//check
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            $table->longtext('details');//check
            $table->longtext('characteristics');
            $table->longtext('markDetails');
            $table->String('state');//check
            $table->integer('stateVal');//check
            $table->longText('main_image')->nullable();
            $table->text('images')->nullable();
            $table->longText('base64Urls')->nullable();
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
        Schema::dropIfExists('requested_machines');
    }
}
