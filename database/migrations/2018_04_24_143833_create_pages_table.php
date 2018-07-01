<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique()->index();
            $table->string('route_name')->unique()->index();
            $table->json('slug');
            $table->json('title');
            $table->json('heading')->nullable();
            $table->json('body')->nullable();
            $table->json('seo')->nullable();
            $table->json('meta_tags')->nullable();
            $table->string('robots')->default('index,follow');

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
        Schema::dropIfExists('pages');
    }
}
