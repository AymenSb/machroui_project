<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('machine');
            $table->String('name'); //check
            $table->integer('price');//check
            $table->String('Vendor')->nullable();//check
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('users')->onDelete('cascade');
            $table->longtext('details');//check
            $table->longtext('characteristics');
            $table->longtext('markDetails');
            $table->String('state');//check
            $table->integer('stateVal');//check
            $table->integer('offers')->nullable();
            $table->longText('main_image')->nullable();
            $table->text('images')->nullable();
            $table->longText('base64Urls')->nullable();
            $table->text('video_name')->nullable();
            $table->longText('video_base64')->nullable();

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
        Schema::dropIfExists('machines');
    }
}
