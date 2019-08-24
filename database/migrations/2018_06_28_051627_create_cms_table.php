<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');                              // Page url
            $table->string('section');                          // Header/footer/header bottom etc
            $table->string('title')->nullable();                            // Section Title
            $table->string('sub_title')->nullable();                        // Section Sub title
            $table->string('custom_url')->nullable();                        // Section Sub title
            $table->longText('body')->nullable();                             // Section message
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            //Need to create a media base on this type
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cms');
    }
}
