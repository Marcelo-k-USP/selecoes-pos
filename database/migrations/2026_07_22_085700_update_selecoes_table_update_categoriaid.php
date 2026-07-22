<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSelecoesTableUpdateCategoriaId extends Migration
{
    public function up()
    {
        Schema::table('selecoes', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('selecoes', function (Blueprint $table) {
            $table->unsignedBigInteger('categoria_id')->nullable(false)->change();
        });
    }
}
