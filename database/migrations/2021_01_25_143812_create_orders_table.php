<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('email');
            $table->text('address');
            $table->string('city');
            $table->enum('payment_method', ['cash', 'visa']);
            $table->longText('products');
            $table->decimal('total');
            $table->decimal('sub_total');
            $table->decimal('shipping_fees');
            $table->integer('quantity');
            $table->string('status');
            $table->text('customer_message')->nullable();
            $table->text('staff_notes')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
