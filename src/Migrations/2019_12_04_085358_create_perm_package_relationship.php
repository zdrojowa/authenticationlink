<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermPackageRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('perm_package', function (Blueprint $table) {
            $table->foreign('permission_id')->on('permissions')->references('id')->onDelete('CASCADE');
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
        Schema::table('perm_package', function (Blueprint $table) {
            $table->dropForeign('perm_package_permission_id_foreign');
            $table->dropForeign('perm_package_permission_package_id_foreign');
        });
    }
}
