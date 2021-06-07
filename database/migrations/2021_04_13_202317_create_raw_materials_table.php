<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_materials', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('matière première');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('brand');
            $table->integer('price');
            $table->integer('requests')->nullable();
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
        Schema::dropIfExists('raw_materials');
    }
}
