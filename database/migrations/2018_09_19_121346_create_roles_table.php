<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('role_id')->unsigned()->index();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
//            $table->primary(['user_id', 'role_id']);
            $table->timestamps();
        });

        Schema::create('permission_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('permission_id')->unsigned()->index();
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->timestamps();
        });



       /* Schema::create('request_map', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code'); //INV-1 Next Row INV-2 Like that (Single)
            $table->string('config_attribute');//ROLE_101_, ROLE_102_1
            $table->string('url');//admin/category/create
            $table->string('http_method');//GET
            $table->boolean('is_common');//0
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('authority');//ROLE_101_1
            $table->string('name');//ADMIN
            $table->boolean('is_active');
            $table->timestamps();
        });

        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('role_id')->unsigned()->index();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->primary(['user_id', 'role_id']);
            $table->timestamps();
        });

        Schema::create('features', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code'); //F_INV_1,next row F_INV_2(Single)
            $table->string('name');//CREATE BRAND, UPDATE BRAND
            $table->string('request_map_code');//INV-9,INV-10
            $table->timestamps();
        });

        Schema::create('feature_role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('role_authority');//ROLE_101_1,new
            $table->string('feature_code'); //F_INV_1
            $table->timestamps();
        });

        //Role Authority
        //ROLE_101_1	F_INV_1
        //ROLE_101_1	F_INV_2
        //ROLE_101_1	F_INV_3
        //ROLE_101_1	F_INV_4
        //ROLE_102_1	F_INV_1
        //ROLE_102_1	F_INV_2
        //ROLE_102_1	F_INV_3
        //ROLE_102_1	F_INV_4
        //ROLE_103_1	F_INV_1
        //ROLE_103_1	F_INV_2
        //ROLE_103_1	F_INV_3*/


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('request_map');
//        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('permission_user');
//        Schema::dropIfExists('features');
//        Schema::dropIfExists('feature_role');
    }
}
