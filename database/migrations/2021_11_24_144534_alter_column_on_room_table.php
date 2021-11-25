<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterColumnOnRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('rooms')) {
            Schema::dropIfExists('rooms');
        }

        if (!Schema::hasTable('rooms')) {

            Schema::create('rooms', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('uuid')->index();
                $table->string('room_id', 255)->index();
                $table->integer('unread')->unsigned()->default(0);
                $table->string('user_uuid', 255);
                $table->timestamps();

                if (Schema::hasTable('users')) {
                    $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
