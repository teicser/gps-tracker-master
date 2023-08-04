<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateAnalogInputTableGpsData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gps_data', function (Blueprint $table) {
            $table->double('analog_input')->change();
            $table->double('altitude')->change();
            $table->double('direction')->change();
            $table->double('speed')->change();
            $table->double('x_acceleration')->change();
            $table->double('y_acceleration')->change();
            $table->double('z_acceleration')->change();
            $table->double('ident')->change();
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gps_data', function (Blueprint $table) {
            //
        });
    }
}
