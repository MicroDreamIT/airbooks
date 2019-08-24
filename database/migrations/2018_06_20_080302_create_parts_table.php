<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('uid')->index();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('part_number');
            $table->string('alternate_part_number')->nullable();
            $table->integer('condition_id')->index()->unsigned();
            $table->foreign('condition_id')->references('id')->on('conditions')->onDelete('cascade');
            $table->float('quantity');
            $table->enum('unit_measure', ['EA', 'KG','LBS','MM','CM','inch','foot','liter','gallon'])->nullable();
            $table->decimal('price', 16,4)->nullable();
            $table->integer('release_id')->index()->unsigned()->nullable();
            $table->integer('location')->index()->unsigned()->nullable();
            $table->text('description')->nullable();
            $table->integer('owner')->index()->unsigned()->nullable();
            $table->integer('seller')->index()->unsigned()->nullable();
            $table->integer('primary_contact')->index()->unsigned();
            $table->foreign('primary_contact')->references('id')->on('contacts')->onDelete('cascade');
//            $table->longText('custom')->nullable();
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
        Schema::dropIfExists('parts');
    }
}
