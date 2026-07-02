<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateParametrosTableAddLinkInscricaoTermos extends Migration
{
    public function up()
    {
        Schema::table('parametros', function (Blueprint $table) {
            $table->string('link_inscricao_termos')->nullable()->after('boleto_momento_envio');
        });
    }

    public function down()
    {
        Schema::table('parametros', function (Blueprint $table) {
            $table->dropColumn('link_inscricao_termos');
        });
    }
}
