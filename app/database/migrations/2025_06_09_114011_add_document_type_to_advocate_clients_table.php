<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDocumentTypeToAdvocateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('advocate_clients', function (Blueprint $table) {
            $table->string('dni_ruc')->nullable(false)->unique()->after('id');
            $table->string('document_type')->nullable(false)->after('dni_ruc');
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
            $table->dropColumn('dni_ruc');
            $table->dropColumn('document_type');
        });
    }
}
