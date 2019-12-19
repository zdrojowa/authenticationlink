<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthenticationLinksRelationship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('authentication_links', function(Blueprint $table) {
            $table->foreign('user_id')->on(\Zdrojowa\AuthenticationLink\Facades\AuthenticationLink::getUserModel()->getTable())->references('id')->onDelete('CASCADE');
            $table->foreign('system_id')->on(\Zdrojowa\AuthenticationLink\Facades\AuthenticationLink::getSystemModel()->getTable())->references('id')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('authentication_links', function(Blueprint $table) {
            $table->dropForeign('authentication_links_system_id_foreign');
            $table->dropForeign('authentication_links_user_id_foreign');
        });
    }
}
