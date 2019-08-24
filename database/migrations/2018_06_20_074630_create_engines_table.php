<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnginesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('engines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('uid')->index();
            $table->string('title')->nullable();
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('manufacturer_id')->index()->unsigned();
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('cascade');
            $table->integer('category_id')->index()->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('type_id')->index()->unsigned();
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->integer('model_id')->index()->unsigned()->nullable();
            $table->enum('offer_for',['Sale','Lease','Exchange','Lease Purchase']);
            $table->string('esn')->nullable();
            $table->enum('status', ['new','as removed','overhauled','serviceable','repaired','operational', 'storage','non serviceable', 'tear down']);
            $table->timestamp('availability')->nullable(); //Available date
            $table->decimal('price', 14, 4)->nullable();
            $table->text('lease_terms')->nullable();
            $table->text('exchange_terms')->nullable();
            $table->text('description')->nullable();
            $table->integer('current_location')->nullable();

            $table->integer('owner_id')->index()->unsigned()->nullable();
            $table->integer('seller_id')->index()->unsigned()->nullable();
            $table->integer('primary_contact')->index()->unsigned();
            $table->foreign('primary_contact')->references('id')->on('contacts')->onDelete('cascade');
            $table->integer('cycle_remaining')->default(0);
            $table->string('thrust_rating')->nullable();
            $table->text('lsv_description')->nullable();
            $table->text('tso')->nullable();
            $table->text('status_reason')->nullable(); // Admin Message goes here
            $table->timestamp('promotion_date')->nullable();
//            $table->boolean('promote_status')->default(false);
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);
            /**
             * Pending Approval: When user submits, it shows message pending approval
             * Approved: When admin approve the listing, it is showing Approved to user.
             * Revise: If admin tag revise, user can see revise label and resubmit it.
             * Rejected: If item is rjected, user cannot resubmit it but can make new to submit again.
             * Published: If isActiveStatus and isPublished both are true then it will be published on frontend;
             */
            $table->enum('isActiveStatus', ['Pending Approval', 'Approved', 'Revise', 'Rejected']); //Default Value will be first one.
            $table->boolean('is_featured')->default(false);
            /** Addition Note:
             * if isPublished true more than 60 days and user don't refresh the time(forntend) then it will be false
             */
            $table->boolean('is_active_by_user')->default(true);
            $table->boolean('is_published')->default(false);
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
        Schema::dropIfExists('engines');

    }
}
