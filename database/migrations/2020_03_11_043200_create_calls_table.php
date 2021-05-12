<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->integer('number')->nullable();
            $table->unsignedBigInteger('client_id');
                $table->foreign('client_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('status_id');
                $table->foreign('status_id')
                ->references('id')
                ->on('statuses');
            $table->unsignedBigInteger('office_id');
                $table->foreign('office_id')->references('id')->on('offices')->onDelete('cascade');
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
        Schema::dropIfExists('calls');
    }
}
