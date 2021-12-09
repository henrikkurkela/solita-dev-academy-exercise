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
        Schema::create('farm_list', function (Blueprint $table) {
            $table->id();
            $table->string('location');
            $table->timestamps();
        });

        Schema::create('farm_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('location_id')->constrained('farm_list')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('farm_data');
        Schema::dropIfExists('farm_list');
    }
}
