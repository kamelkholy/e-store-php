<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateFeaturedCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('featured_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('category');
            $table->unsignedBigInteger('featured_product')->nullable();
            $table->integer('products_limit');
            $table->integer('sortOrder')->default(0);
            $table->timestamps();
        });
        DB::statement("ALTER TABLE featured_categories ADD banner MEDIUMBLOB");
        DB::statement("ALTER TABLE featured_categories ADD featured_img MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('featured_categories');
    }
}
