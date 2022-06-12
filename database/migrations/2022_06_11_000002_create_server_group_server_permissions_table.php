<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('server_group_server_permissions', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('server_group_id');
            $table->foreign('server_group_id')->references('id')->on('server_groups')->onDelete('cascade');

            $table->unsignedBigInteger('server_permission_id');
            $table->foreign('server_permission_id')->references('id')->on('server_permissions')->onDelete('cascade');

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
        Schema::dropIfExists('server_group_server_permissions');
    }
};
