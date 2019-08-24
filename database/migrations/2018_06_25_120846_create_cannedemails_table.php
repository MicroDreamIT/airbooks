<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCannedemailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cannedemails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message_type'); // Signup , Forgot Password,
            $table->string('subject');
            $table->string('sending_email'); // Which email use for send
            $table->text('message')->nullable();
            $table->string('location');
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
        Schema::dropIfExists('cannedemails');
    }
}
