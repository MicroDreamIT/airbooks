<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attaches', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable();
            $table->boolean('accessibility')->default(false);

            $table->string('attachable_type')->index(); // type aircratt / apu / engine etc
            $table->integer('attachable_id')->index(); // id of aircratt / apu / engine etc

            $table->string('type')->nullable(); //file type .jpg, .pdf
            $table->string('path')->index();

            $table->string('original_file_name')->index();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
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
        Schema::dropIfExists('attaches');
    }
}
