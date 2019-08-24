<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('transaction_id');
            $table->integer('order_id');
            $table->integer('response_code');
            $table->text('response_message')->nullable();
            $table->string('customer_name');
            $table->string('customer_email');
            $table->decimal('transaction_amount',14,2);
            $table->string('transaction_currency')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('first_4_digits')->nullable();
            $table->string('last_4_digits')->nullable();
            $table->string('card_brand')->nullable();
            $table->timestamp('trans_date');
            $table->string('pt_customer_email')->nullable();
            $table->string('pt_customer_password')->nullable();
            $table->string('pt_token')->nullable();
            $table->string('secure_sign')->nullable();

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
        Schema::dropIfExists('payment_histories');
    }
}

