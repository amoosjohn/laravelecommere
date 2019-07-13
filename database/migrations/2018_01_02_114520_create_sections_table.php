<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->bigInteger('user_id');
            $table->tinyInteger('status');
            $table->integer('category')->nullable();
            $table->string('category2')->nullable();
            $table->string('category3')->nullable();
            $table->string('image')->nullable();
            $table->string('url')->nullable();
            $table->string('title2')->nullable();
            $table->string('short2')->nullable();
            $table->string('image2')->nullable();
            $table->string('url2')->nullable();
            $table->string('title3')->nullable();
            $table->string('short3')->nullable();
            $table->string('image3')->nullable();
            $table->string('url3')->nullable();
            $table->string('title4')->nullable();
            $table->string('short4')->nullable();
            $table->string('image4')->nullable();
            $table->string('url4')->nullable();
            $table->string('title5')->nullable();
            $table->string('short5')->nullable();
            $table->string('image5')->nullable();
            $table->string('url5')->nullable();
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
