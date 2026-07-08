<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class UpdateSelecoesTableUpdateCamposTemplate extends Migration
{
    public function up()
    {
        Schema::table('selecoes', function (Blueprint $table) {
            $table->renameColumn('template', 'template_inscricoes');
        });

        Schema::table('selecoes', function (Blueprint $table) {
            $table->json('template_solicitacoesisencaotaxa')->nullable()->after('email_inscricaomatricularejeicao_texto');
            $table->json('template_matriculas')->nullable()->after('template_inscricoes');
        });

        $categoriaId = DB::table('categorias')->where('nome', 'Aluno Especial')->value('id');
        if ($categoriaId)
            DB::table('selecoes')->where('categoria_id', $categoriaId)->whereNotNull('template_inscricoes')->update([
                'template_matriculas' => DB::raw('template_inscricoes'),
                'template_inscricoes' => null
            ]);

        $programasMatriculaIds = DB::table('programas')->where('processos', 'Matrícula')->pluck('id');
        if ($programasMatriculaIds->isNotEmpty())
            DB::table('selecoes')->whereIn('programa_id', $programasMatriculaIds)->whereNotNull('template_inscricoes')->update([
                'template_matriculas' => DB::raw('template_inscricoes'),
                'template_inscricoes' => null
            ]);

        DB::table('selecoes')->where('tem_taxa', 1)->update([
            'template_solicitacoesisencaotaxa' => '{
                "nome": {
                    "label": "Nome",
                    "type": "text",
                    "validate": "required",
                    "order": 0
                },
                "tipo_de_documento": {
                    "label": "Tipo de Documento",
                    "type": "select",
                    "value": [
                    {
                        "label": "RG",
                        "value": "rg",
                        "order": 0
                    },
                    {
                        "label": "RNE",
                        "value": "rne",
                        "order": 1
                    },
                    {
                        "label": "Passaporte",
                        "value": "passaporte",
                        "order": 2
                    }
                    ],
                    "help": "Utilize o passaporte apenas se não possuir documento de identidade brasileira (RG)",
                    "validate": "required",
                    "order": 1
                },
                "numero_do_documento": {
                    "label": "Número do Documento",
                    "type": "text",
                    "validate": "required",
                    "order": 2
                },
                "cpf": {
                    "label": "CPF",
                    "type": "text",
                    "validate": "required",
                    "order": 3
                },
                "e_mail": {
                    "label": "E-mail",
                    "type": "email",
                    "validate": "required",
                    "order": 4
                }
            }'
        ]);

        DB::table('selecoes')->whereNull('template_solicitacoesisencaotaxa')->update(['template_solicitacoesisencaotaxa' => '{}']);
        DB::table('selecoes')->whereNull('template_inscricoes')->update(['template_inscricoes' => '{}']);
        DB::table('selecoes')->whereNull('template_matriculas')->update(['template_matriculas' => '{}']);
    }

    public function down()
    {
        $categoriaId = DB::table('categorias')->where('nome', 'Aluno Especial')->value('id');
        if ($categoriaId)
            DB::table('selecoes')->where('categoria_id', $categoriaId)->whereNotNull('template_matriculas')->update([
                'template_inscricoes' => DB::raw('template_matriculas'),
                'template_matriculas' => null
            ]);

        $programasMatriculaIds = DB::table('programas')->where('processos', 'Matrícula')->pluck('id');
        if ($programasMatriculaIds->isNotEmpty())
            DB::table('selecoes')->whereIn('programa_id', $programasMatriculaIds)->whereNotNull('template_matriculas')->update([
                'template_inscricoes' => DB::raw('template_matriculas'),
                'template_matriculas' => null
            ]);

        Schema::table('selecoes', function (Blueprint $table) {
            $table->dropColumn(['template_solicitacoesisencaotaxa', 'template_matriculas']);
            $table->renameColumn('template_inscricoes', 'template');
        });
    }
}
