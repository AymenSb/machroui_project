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
            $table->longtext('details');//check
            $table->longtext('characteristics');
            $table->longtext('markDetails');
            $table->String('state');//check
            $table->integer('stateVal');//check
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
