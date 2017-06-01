<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableStoresAddFieldsAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->string('token_type', 100)->nullable();
            $table->bigInteger('expires_in')->nullable();
            $table->string('refresh_token', 150)->nullable();
            $table->string('scope', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['token_type', 'expires_in', 'refresh_token', 'scope']);
        });
    }
}
