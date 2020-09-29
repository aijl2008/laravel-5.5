<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RbacLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('rbac.database.table_pre') . 'logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->string('connection', 45);
            $table->string('ip', 45);
            $table->string('ua', 255);
            $table->string('sql', 255);
            $table->text('bindings');
            $table->float('time');
            $table->tinyInteger('error_code');
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
        Schema::dropIfExists(config('rbac.database.table_pre') . 'logs');
    }
}
