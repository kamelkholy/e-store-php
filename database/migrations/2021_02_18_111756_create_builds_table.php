<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('builds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('build_name');
            $table->enum('build_access', ['private', 'public']);
            $table->unsignedBigInteger('processor')->nullable();
            $table->unsignedBigInteger('motherboard')->nullable();
            $table->unsignedBigInteger('ram')->nullable();
            $table->unsignedBigInteger('primary_storage')->nullable();
            $table->unsignedBigInteger('secondary_storage')->nullable();
            $table->unsignedBigInteger('gpu')->nullable();
            $table->unsignedBigInteger('tower')->nullable();
            $table->unsignedBigInteger('tower_cooler')->nullable();
            $table->unsignedBigInteger('optical_drive')->nullable();
            $table->unsignedBigInteger('cpu_cooler')->nullable();
            $table->unsignedBigInteger('power_supply')->nullable();
            $table->unsignedBigInteger('monitor')->nullable();
            $table->unsignedBigInteger('keyboard')->nullable();
            $table->unsignedBigInteger('mouse')->nullable();
            $table->unsignedBigInteger('headphone')->nullable();
            $table->unsignedBigInteger('customer')->nullable();
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
        Schema::dropIfExists('builds');
    }
}
