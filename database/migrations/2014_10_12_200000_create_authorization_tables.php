<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizationTables extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('roles', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->unique();
            $table->string('label');
            $table->boolean('protected')->default(false);
        });

        Schema::create('permissions', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('name')->unique();
            $table->string('label');
            $table->string('group');
        });

        Schema::create('permission_role', function(Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamps();

            $table->primary(['permission_id', 'role_id']);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });

        Schema::create('user_role', function(Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->primary(['role_id', 'user_id']);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('user_permission', function(Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->primary(['permission_id', 'user_id']);
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });

/*
        Schema::create('admin_user_role', function(Blueprint $table) {
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('admin_user_id');
            $table->timestamps();

            $table->primary(['role_id', 'admin_user_id']);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('admin_user_id')->references('id')->on('admin_users');
        });

        Schema::create('admin_user_permission', function(Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('admin_user_id');
            $table->timestamps();

            $table->primary(['permission_id', 'admin_user_id']);
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
            $table->foreign('admin_user_id')->references('id')->on('admin_users');
        });*/

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
//        Schema::dropIfExists('admin_user_permission');
//        Schema::dropIfExists('admin_user_role');
        Schema::dropIfExists('user_permission');
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');

    }
}
