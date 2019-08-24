<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('creator_id')->unsigned()->index();
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('email');

            $table->enum('title', ['Mr/Ms', 'Esq', 'Hon', 'Jr', 'Dr', 'Mrs', 'Mr', 'Ms', 'Messrs', 'Mmes', 'Msgr', 'Prof', 'Rev', 'Rt. Hon', 'Sr', 'St']);
            $table->integer('company_id')->index()->unsigned()->nullable();
            $table->integer('user_id')->index()->unsigned()->nullable();
//            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('first_name')->index(); //
            $table->string('last_name')->index(); //
            $table->enum('gender', ['male', 'female', 'other']); //
            $table->string('birthday')->nullable();
            $table->integer('job_title')->index()->unsigned()->nullable(); //
//            $table->foreign('job_title')->references('id')->on('titles')->onDelete('cascade');
            $table->integer('department_id')->index()->unsigned()->nullable();
//            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->string('business_phone')->nullable(); //
            $table->string('mobile_phone')->nullable(); //
            $table->string('skype')->nullable(); //
            $table->string('linkedin')->nullable();//
            $table->text('address')->nullable();
            $table->integer('city_id')->index()->unsigned()->nullable();
            $table->integer('country_id')->index()->unsigned()->nullable();
            $table->integer('state_id')->index()->unsigned()->nullable();
            $table->string('religion')->nullable();
            $table->enum('preferred_contact_method', ['Email', 'Phone', 'Both'])->nullable(); //
            $table->text('message')->nullable(); // Message for update enquery
            $table->timestamp('contact_date')->nullable(); //Contact date for update enquery
            $table->boolean('is_published')->default(true);
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_public')->default(false);
            $table->integer('views')->default(0);
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
        Schema::dropIfExists('contacts');
    }
}
