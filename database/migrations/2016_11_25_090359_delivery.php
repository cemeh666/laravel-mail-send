<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Delivery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::create('delivery', function (Blueprint $table) {
		    $table->increments('id');
		    $table->integer('email_count');
		    $table->string('delivery_name');
		    $table->string('last_active');
		    $table->string('table_name');
		    $table->string('table_field');
		    $table->string('mailer');
		    $table->string('template');
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
	    Schema::drop('delivery');
    }
}
