<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('role')->nullable()->default(0);
            // $table->integer('status')->nullable()->default(0);
            $table->string('name');
            $table->integer('manager_id')->nullable();
            $table->bigInteger('tgbot_id')->nullable();
            $table->string('tgbot_name')->nullable();
            $table->string('tgbot_nik')->nullable();
            $table->string('phone')->nullable();
            $table->string('code')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token', 60)->unique();
            $table->integer('api_status')->nullable()->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
