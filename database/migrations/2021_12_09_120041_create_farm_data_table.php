<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFarmDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farms', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->timestamps();
        });

        Schema::create('data_points', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farm_id')->constrained('farms')->onUpdate('cascade')->onDelete('cascade');
            $table->string('datetime');
            $table->string('sensortype');
            $table->decimal('value', 10, 2);
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
        Schema::dropIfExists('farms');
        Schema::dropIfExists('data_points');
    }
}
