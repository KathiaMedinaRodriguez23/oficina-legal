<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyMiddleNameInAdvocateClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advocate_clients', function (Blueprint $table) {
            $table->dropColumn('middle_name');
        });

        Schema::table('advocate_clients', function (Blueprint $table) {
            $table->string('middle_name')->nullable()->after('first_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('advocate_clients', function (Blueprint $table) {
            $table->dropColumn('middle_name');
        });

        Schema::table('advocate_clients', function (Blueprint $table) {
            $table->string('middle_name')->after('first_name');
        });
    }
}
