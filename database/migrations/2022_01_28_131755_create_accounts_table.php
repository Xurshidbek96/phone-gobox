<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')
            ->constrained()
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->string('platform')->nullable();
            $table->string('account')->nullable();
            $table->string('type_account')->nullable();
            $table->string('profile')->nullable();
            $table->date('date_create')->nullable();
            $table->string('geo')->nullable();
            $table->string('etap')->nullable();
            $table->string('status')->nullable();
            $table->text('info')->nullable();
            $table->string('connect_provider')->nullable();
            $table->string('geo_provider')->nullable();
            $table->string('ip_port')->nullable();
            $table->string('city')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->integer('day')->nullable();
            $table->string('month')->nullable();
            $table->integer('year')->nullable();
            $table->string('login')->nullable();
            $table->string('password')->nullable();
            $table->bigInteger('number')->nullable();
            $table->string('payment')->nullable();
            $table->string('type_payment')->nullable();
            $table->date('date_payment')->nullable();
            $table->integer('billing')->nullable();
            $table->text('comment')->nullable();
            $table->string('file1')->nullable();
            $table->string('file2')->nullable();
            $table->string('file3')->nullable();
            $table->string('file4')->nullable();
            $table->json("img")->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
