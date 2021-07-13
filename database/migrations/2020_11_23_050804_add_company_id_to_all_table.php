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
            $table->foreign('company_id')
            ->references('id')
            ->on('companies')
            ->onDelete('cascade');
        });
        // products table
        Schema::table('products', function (Blueprint $table) {
            $table->bigInteger('company_id')->unsigned()->after('code')->nullable();
            $table->foreign('company_id')
            ->references('id')
            ->on('companies')
            ->onDelete('cascade');
        });
        // roles table
        Schema::table('roles', function (Blueprint $table) {
            $table->bigInteger('company_id')->unsigned()->after('guard_name')->nullable();
            $table->foreign('company_id')
            ->references('id')
            ->on('companies')
            ->onDelete('cascade');
            
        });
        // permissions table
        Schema::table('settings', function (Blueprint $table) {
            $table->bigInteger('company_id')->unsigned()->after('product_id')->nullable();
            $table->foreign('company_id')
            ->references('id')
            ->on('companies')
            ->onDelete('cascade');
        });
        Schema::table('log_activities', function (Blueprint $table) {
            $table->bigInteger('company_id')->unsigned()->after('user_id')->nullable();
            $table->foreign('company_id')
            ->references('id')
            ->on('companies')
            ->onDelete('cascade');
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
            $table->dropColumn('company_id');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
        Schema::table('log_activities', function (Blueprint $table) {
            $table->dropColumn('company_id');
        });
      
    }
}
