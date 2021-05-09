<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('office_id');
                $table->foreign('office_id')
                    ->references('id')
                    ->on('offices')
                    ->onDelete('cascade');
            $table->unsignedBigInteger('host_id');
                $table->foreign('host_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');
            $table->integer('day');
            $table->string('hour_start',5);
            $table->string('hour_end',5);
            $table->date('date_start');
            $table->date('date_end');
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
        Schema::dropIfExists('schedules');
    }
}
