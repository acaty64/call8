<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('call_id');
                $table->foreign('call_id')
                            ->references('id')
                            ->on('calls')->onDelete('cascade');
            $table->unsignedBigInteger('host_id');
                $table->foreign('host_id')
                            ->references('id')
                            ->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('client_id');
                $table->foreign('client_id')
                            ->references('id')
                            ->on('users')->onDelete('cascade');
            $table->mediumText('host_comment');
            $table->mediumText('client_comment');
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
        Schema::dropIfExists('comments');
    }
}
