<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('type',['aircraft', 'engine', 'apu', 'parts'])->index(); //Type like Aircraft, Apu etc
            $table->integer('type_id')->index()->unsigned(); //Type Table ID not Aircraft Id or Engine Id
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->boolean('is_active');
            $table->text('description')->nullable();

//            $table->unique(['type', 'name']);
            $table->timestamps();
        });

        // There is a Media Need to Put on media table

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('models');

    }
}
