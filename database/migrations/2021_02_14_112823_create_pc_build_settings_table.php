<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePcBuildSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pc_build_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('processor');
            $table->unsignedBigInteger('motherboard');
            $table->unsignedBigInteger('ram');
            $table->unsignedBigInteger('primary_storage');
            $table->unsignedBigInteger('secondary_storage');
            $table->unsignedBigInteger('gpu');
            $table->unsignedBigInteger('tower');
            $table->unsignedBigInteger('tower_cooler');
            $table->unsignedBigInteger('optical_drive');
            $table->unsignedBigInteger('cpu_cooler');
            $table->unsignedBigInteger('power_supply');
            $table->unsignedBigInteger('monitor');
            $table->unsignedBigInteger('keyboard');
            $table->unsignedBigInteger('mouse');
            $table->unsignedBigInteger('headphone');
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
        Schema::dropIfExists('pc_build_settings');
    }
}
