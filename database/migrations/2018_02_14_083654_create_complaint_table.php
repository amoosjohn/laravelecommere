<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',50)->nullable();
            $table->string('name')->nullable();
            $table->string('email',50)->nullable();
            $table->string('contact',50)->nullable();
            $table->string('address')->nullable();
            $table->text('details')->nullable();
            $table->integer('resolvedBy')->nullable();
            $table->dateTime('resolvedDate')->nullable();
            $table->text('comments')->nullable();
            $table->tinyInteger('status')->nullable();
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
        Schema::dropIfExists('complaint');
    }
}
