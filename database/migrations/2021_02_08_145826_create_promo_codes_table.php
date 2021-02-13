<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->decimal('discount');
            $table->enum('discount_type', ['percentage', 'ammount']);
            $table->enum('applicability', ['all', 'some', 'categories']);
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->longText('products')->nullable();
            $table->longText('categories')->nullable();
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
        Schema::dropIfExists('promo_codes');
    }
}
