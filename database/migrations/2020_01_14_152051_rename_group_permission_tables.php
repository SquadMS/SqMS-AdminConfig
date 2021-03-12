<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameGroupPermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
        });

        Schema::table('group_permissions', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropForeign(['permission_id']);
        });

        Schema::rename('groups', 'server_groups');
        Schema::rename('permissions', 'server_permissions');
        Schema::rename('group_permissions', 'server_group_server_permissions');

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('group_id', 'server_group_id');
            $table->foreign('server_group_id')->references('id')->on('server_groups')->onDelete('set null');
        });

        Schema::table('server_group_server_permissions', function (Blueprint $table) {
            $table->renameColumn('group_id', 'server_group_id');
            $table->foreign('server_group_id')->references('id')->on('server_groups')->onDelete('cascade');

            $table->renameColumn('permission_id', 'server_permission_id');
            $table->foreign('server_permission_id')->references('id')->on('server_permissions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['server_group_id']);
        });

        Schema::table('server_group_server_permissions', function (Blueprint $table) {
            $table->dropForeign(['server_group_id']);
            $table->dropForeign(['server_permission_id']);
        });

        Schema::rename('server_groups', 'groups');
        Schema::rename('server_permissions', 'permissions');
        Schema::rename('server_group_server_permissions', 'group_permissions');

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('server_group_id', 'group_id');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
        });

        Schema::table('group_permissions', function (Blueprint $table) {
            $table->renameColumn('server_group_id', 'group_id');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');

            $table->renameColumn('server_permission_id', 'permission_id');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');
        });
    }
}
