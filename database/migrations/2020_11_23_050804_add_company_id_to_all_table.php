<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompanyIdToAllTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // users table
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('company_id')->unsigned()->after('role')->nullable();
        });
        // products table
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('company_id')->after('code')->nullable();
        });
        // roles table
        Schema::table('roles', function (Blueprint $table) {
            $table->bigInteger('company_id')->after('guard_name')->nullable();
        });
        // permissions table
        Schema::table('permissions', function (Blueprint $table) {
            $table->bigInteger('company_id')->after('guard_name')->nullable();
        });
        // permissions table
        Schema::table('settings', function (Blueprint $table) {
            $table->bigInteger('company_id')->after('product_id')->nullable();
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
            //
        });
    }
}
