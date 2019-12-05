<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserPermissionsPackagesRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_permissions_packages', function (Blueprint $table) {
            $table->foreign('user_id')->on('users')->references('id')->onDelete('CASCADE');
            $table->foreign('permission_package_id')->on('permission_packages')->references('id')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_permissions_packages', function (Blueprint $table) {
            $table->dropForeign('users_permissions_packages_permission_package_id_foreign');
            $table->dropForeign('users_permissions_packages_user_id_foreign');
        });
    }
}
