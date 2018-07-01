<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->index();
            $table->unsignedInteger('page_id')->index();
            $table->string('more')->nullable();
            $table->json('title')->nullable();
            $table->json('body')->nullable();
            $table->string('image')->nullable();
            $table->boolean('image_outside')->default(true);
            $table->string('css_class')->nullable();
            $table->json('css')->nullable();
            $table->unsignedTinyInteger('order')->default(0);

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
        Schema::dropIfExists('modules');
    }
}
