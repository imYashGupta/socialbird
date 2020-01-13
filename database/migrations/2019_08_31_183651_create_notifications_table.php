<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id'); // set relationship in user model 
            $table->string('user_to_notify'); //the user who will recive this notification
            $table->string('type'); //follow ,comments etc
            $table->string('data'); //follow id ,comment id etc ,you can set relationship in model about this
            $table->integer('read')->default(0); //read recipt
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
        Schema::dropIfExists('notifications');
    }
}
