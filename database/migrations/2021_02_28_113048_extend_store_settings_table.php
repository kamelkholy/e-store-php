<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ExtendStoreSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->string('store_name')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            //
        });
        DB::statement("ALTER TABLE store_settings ADD store_logo MEDIUMBLOB NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->dropColumn('store_name');
            $table->dropColumn('facebook');
            $table->dropColumn('instagram');
            $table->dropColumn('linkedin');
            $table->dropColumn('whatsapp');
            $table->dropColumn('twitter');
            $table->dropColumn('youtube');
            $table->dropColumn('store_logo');
        });
    }
}
