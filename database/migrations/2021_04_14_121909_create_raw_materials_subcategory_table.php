<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRawMaterialsSubcategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raw_materials_subcategory', function (Blueprint $table) {
            $table->BigIncrements('id');
            $table->unsignedBigInteger('raw_materials_id');
            $table->foreign('raw_materials_id')->references('id')->on('raw_materials')->onDelete('cascade');

            $table->unsignedBigInteger('subcategory_id');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');

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
        Schema::dropIfExists('raw_materials_subcategory');
    }
}
