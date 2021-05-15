<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')
                            ->references('id')
                            ->on('users')->onDelete('cascade');
           $table->unsignedBigInteger('type_id');
                $table->foreign('type_id')
                            ->references('id')
                            ->on('types')->onDelete('cascade');
           $table->unsignedBigInteger('office_id')->nullable();
                $table->foreign('office_id')
                            ->references('id')
                            ->on('offices')->onDelete('cascade');
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
        Schema::dropIfExists('accesses');
    }
}
