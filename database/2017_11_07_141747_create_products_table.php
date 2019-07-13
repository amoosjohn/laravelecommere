<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->string('name');
            $table->tinyInteger('status');
            $table->string('sku');
            $table->double('price');
            $table->double('sale_price');
            $table->double('discount');
            $table->string('short_description');
            $table->text('description');
            $table->text('return_policy');
            $table->tinyInteger('stock_status');
            $table->tinyInteger('shipping');
            $table->string('weight',10);
            $table->string('length',10);
            $table->string('width',10);
            $table->string('height',10);
            $table->integer('tax_class');
            $table->string('meta_title',100);
            $table->string('meta_keyword',500);
            $table->string('meta_description',1000);
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
        Schema::drop('products');
    }
}
