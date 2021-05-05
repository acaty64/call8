<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTracesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('traces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('host_id')->nullable();
                $table->foreign('host_id')
                            ->references('id')
                            ->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->nullable();
                $table->foreign('client_id')
                            ->references('id')
                            ->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('call_id')->nullable();
            $table->unsignedBigInteger('window_id')->nullable();
            $table->unsignedBigInteger('status_id');
                $table->foreign('status_id')
                            ->references('id')
                            ->on('statuses');
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
        Schema::dropIfExists('traces');
    }
}
