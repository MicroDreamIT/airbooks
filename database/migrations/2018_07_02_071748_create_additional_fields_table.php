<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('entity_id')->index()->unsigned();      // id of aircraft/engine etc
            $table->string('entity_type')->index();                 // type of aircraft/engine etc
            $table->string('field_name');                           // custom field name
            $table->string('field_value');                          // custom field value
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
        Schema::dropIfExists('additional_fields');
    }
}
