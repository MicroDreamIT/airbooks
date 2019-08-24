<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name'); //Plan name like, Basic Plan, Advance Plane, Professional something like that
            $table->string('title');
            $table->decimal('price', 14, 4);
            $table->string('sub_title')->nullable();
            $table->string('position');
            $table->boolean('is_active')->default(true);
            $table->longText('details')->nullable();
            $table->timestamps();
        });

        //Necessary table  for Plan description text
        Schema::create('points', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('plan_id')->index()->unsigned();
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('cascade');
            $table->enum('points_type',['aircraft','engine','apu','part','wanted']);
            $table->integer('number_points')->default(0);
            $table->text('point_text')->nullable();
            $table->timestamps();
        });
        Schema::create('planfeatures', function (Blueprint $table) {
            $table->increments('id');
            $table->string('freaturable_type')->index(); //Model Type
            $table->integer('freaturable_id')->index();// Plan Id
            $table->integer('count')->default(0);
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
        Schema::dropIfExists('plans');
        Schema::dropIfExists('points');
        Schema::dropIfExists('features');
    }
}
