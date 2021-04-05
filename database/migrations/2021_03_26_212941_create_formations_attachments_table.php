<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormationsAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formations_attachments', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->unsignedBigInteger('formation_id')->nullable();
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
        Schema::dropIfExists('formations_attachments');
    }
}
