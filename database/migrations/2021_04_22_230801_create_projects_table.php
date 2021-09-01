<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('projet');
            $table->string('name');
            $table->string('project_type');
            $table->text('informations')->nullable();
            $table->text('images')->default('[]');
            $table->longText('base64Urls')->default('[]');
            $table->text('pdf_file')->nullable();
            $table->longText('pdf_base64')->nullable();
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
        Schema::dropIfExists('projects');
    }
}
