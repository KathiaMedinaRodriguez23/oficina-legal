<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyLastNameNullableOnAdvocateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1) Eliminamos la columna last_name
        Schema::table('advocate_clients', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('gender');
        });

        // 2) La volvemos a añadir, ahora como nullable
        Schema::table('advocate_clients', function (Blueprint $table) {
            $table->string('last_name')->nullable()->after('middle_name');
            $table->enum('gender', ['Male', 'Female'])->nullable()->after('last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 1) Eliminamos la versión nullable
        Schema::table('advocate_clients', function (Blueprint $table) {
            $table->dropColumn('last_name');
            $table->dropColumn('gender');
        });

        // 2) La volvemos a añadir en su forma original (no nullable)
        Schema::table('advocate_clients', function (Blueprint $table) {
            $table->string('last_name')->after('middle_name');
            $table->enum('gender', ['Male', 'Female'])->nullable()->after('last_name');
        });
    }
}
