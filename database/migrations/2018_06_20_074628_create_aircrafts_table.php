<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAircraftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aircrafts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->string('uid')->index();

            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('category_id')->index()->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->integer('type_id')->index()->unsigned();
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');

            $table->integer('model_id')->index()->unsigned()->nullable();

            $table->integer('manufacturer_id')->index()->unsigned();
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers')->onDelete('cascade');

            $table->string('MSN')->index(); //manufacturer serial number
            $table->string('YOM'); //Year of manufacturer
            $table->integer('seating_first_class')->nullable();
            $table->integer('seating_business')->nullable();
            $table->integer('seating_economy')->nullable();
            $table->enum('offer_for', [
                'Sale', 'ACMI', 'Dry Lease',
                'Wet Lease', 'Exchange','Charter','Lease Purchase']);

            $table->integer('mgh')->nullable(); //minimum guaranteed hours
            $table->float('per_block_hour', 14, 4)->nullable();
            $table->float('cpd', 14, 4)->nullable();
            $table->decimal('price', 14, 4)->nullable();
            $table->text('terms')->nullable();
            $table->timestamp('availability')->nullable();
            $table->enum('status', ['Storage', 'Parking', 'Operational', 'For Tear Down'])->index();
            $table->integer('registration_country')->nullable();
            $table->text('registration_number')->nullable();
            $table->integer('owner_id')->nullable();
            $table->integer('previous_operator')->nullable();
            $table->integer('current_operator')->nullable();
            $table->integer('manager_id')->nullable();
            $table->integer('seller_id')->nullable();
            $table->integer('primary_contact')->nullable();
            $table->integer('current_location')->nullable();
            $table->integer('configuration_id')->nullable();
//            $table->integer('total_time')->nullable();

            $table->integer('tsn')->nullable();
            $table->integer('csn')->nullable();
            $table->integer('mtow')->nullable(); //maximum take off weight
            $table->integer('mlgw')->nullable();
            $table->timestamp('last_c_check')->nullable();
            $table->timestamp('promotion_date')->nullable();

            $table->enum('compliance', ['EASA','FAA','TBA']);


            $table->integer('engine_type_id')->nullable();
            $table->integer('engine_model_id')->nullable();
            $table->integer('engine_manufacturer_id')->nullable();

            $table->text('description')->nullable(); //done
            $table->boolean('promote_status')->default(false);
            $table->integer('views')->default(0);
            $table->integer('likes')->default(0);

            /**
             * Pending Approval: When user submits, it shows message pending approval
             * Approved: When admin approve the listing, it is showing Approved to user.
             * Revise: If admin tag revise, user can see revise label and resubmit it.
             * Rejected: If item is rejected, user cannot resubmit it but can make new to submit again.
             * Published: If isActiveStatus and isPublished both are true then it will be published on frontend;
             */
            $table->enum('isActiveStatus', ['Pending Approval', 'Approved', 'Revise', 'Rejected']); //Default Value will be first one.
            $table->text('status_reason')->nullable();
            $table->boolean('is_featured')->default(false);
            /** Addition Note:
             * if isPublished true more than 60 days and user don't refresh the time(forntend) then it will be false
             */
            $table->boolean('is_active_by_user')->default(true);
            $table->boolean('is_published')->default(false);
            //Custom Fields goes here
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
        Schema::dropIfExists('aircrafts');
    }



}
