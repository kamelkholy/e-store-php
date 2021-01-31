<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('name_ar');
            $table->text('description');
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('weight')->nullable();
            $table->integer('length')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('weight_class')->nullable();
            $table->string('length_class')->nullable();
            $table->string('sku')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('discount')->nullable();
            $table->boolean('enable_discount')->default(0);
            $table->enum('shippingType', ['calculated', 'flat', 'free']);
            $table->decimal('shipping_fees')->nullable();

            $table->unsignedBigInteger('type');
            $table->unsignedBigInteger('brand');
            $table->unsignedBigInteger('category')->nullable();
            $table->longText('specifications');
            $table->integer('sortOrder')->default(0);
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
        Schema::dropIfExists('products');
    }
}
