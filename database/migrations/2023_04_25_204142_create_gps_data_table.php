<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGpsDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gps_data', function (Blueprint $table) {
            $table->id();
            $table->decimal('current_battery')->nullable();
            $table->decimal('battery_voltage')->nullable();
            $table->decimal('powersource_voltage')->nullable();
            $table->boolean('is_moving')->nullable();
            $table->decimal('altitude');
            $table->decimal('direction')->nullable();
            $table->double('latitude');
            $table->double('longitude');
            $table->integer('satellites');
            $table->decimal('speed')->nullable();
            $table->decimal('analog_input')->nullable();
            $table->decimal('x_acceleration')->nullable();
            $table->decimal('y_acceleration')->nullable();
            $table->decimal('z_acceleration')->nullable();
            $table->foreignId('gps_device_id')->constrained();
            $table->foreignId('fetch_id')->constrained();
            $table->timestamp('gps_timestamp');
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
        Schema::dropIfExists('gps_data');
    }
}
