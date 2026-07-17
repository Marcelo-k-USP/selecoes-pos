<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateProgramasTableRemoveParametroId extends Migration
{
    public function up()
    {
        Schema::table('programas', function (Blueprint $table) {
            $table->dropForeign(['parametro_id']);
            $table->dropColumn('parametro_id');
        });
    }

    public function down()
    {
        Schema::table('programas', function (Blueprint $table) {
            $table->unsignedBigInteger('parametro_id')->nullable();
            $table->foreign('parametro_id')->references('id')->on('parametros');
        });
    }
}
