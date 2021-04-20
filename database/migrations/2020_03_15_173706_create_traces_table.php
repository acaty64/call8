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
            $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')
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
