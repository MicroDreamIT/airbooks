<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWantedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wanteds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('uid')->index();
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->enum('type', ['aircraft', 'engine', 'apu', 'parts']);
            $table->integer('manufacturer_id')->index()->nullable();
            $table->integer('type_id')->index()->nullable();
            $table->integer('model_id')->index()->nullable();
            $table->string('part_number')->nullable();
            $table->string('yom')->nullable(); // Year of manufacture
            $table->enum('terms', ['ACMI', 'Dry Lease', 'Charter', 'Lease Purchase', 'Outright Purchase','Lease','Exchange','Part out','cash']);
            $table->integer('country_id')->nullable();
            $table->timestamp('wanted_by')->nullable(); //Wanted by Date

            $table->text('comments')->nullable();
            $table->integer('primary_contact')->index()->unsigned();
            $table->foreign('primary_contact')->references('id')->on('contacts')->onDelete('cascade');
            $table->longText('custom')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->boolean('promote_status')->default(false);

            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('wanteds');
    }
}
