<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWindowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('windows', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('window', 3);
            $table->unsignedBigInteger('host_id')->nullable();
                $table->foreign('host_id')
                            ->references('id')
                            ->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->nullable();
                $table->foreign('client_id')
                            ->references('id')
                            ->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('call_id')->nullable();
                $table->foreign('call_id')
                            ->references('id')
                            ->on('calls')->onDelete('cascade');
            $table->unsignedBigInteger('status_id')->nullable();
                $table->foreign('status_id')
                            ->references('id')
                            ->on('statuses');
            $table->unsignedBigInteger('office_id')->nullable();
                $table->foreign('office_id')
                            ->references('id')
                            ->on('offices');
            $table->string('mensaje')->nullable();
            $table->string('link')->nullable();
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
        Schema::dropIfExists('windows');
    }
}
