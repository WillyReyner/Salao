<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Edital;

class EditaisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Edital::create([
            'nome' => 'Teste',
            'situacao' => 'Ativo',
            'rede' => '',
            'text' => '',
            'downloads' => '1',
            'ordem' => '1',
            'numero' => '1',
            'categoria' => '',
            'modalidade' => '',
            'turno' => '',
            'tags' => '',
            'documentos_inscricao' => 'Documentacao1Value',
            'etapas_processo' => '',
            'faixa_etaria' => '',
            'agendar_publicacao' => 'Sim',
            'udepi' => 'Sim',
            'contagem_editais' => '',
            'observacoes' => 'Teste',
            'dt_publicacao' => '2023-10-01',
            'dt_fim_edital' => '2023-10-31',
            'dt_inicio_inscricao' => '2023-10-01',
            'dt_fim_inscricao' => '2023-10-31',
            'data_publicacao' => '2023-10-01',
            'data_inicio_inscricao' => '2023-10-01',
            'data_fim_inscricao' => '2023-10-31',
            'escola_id' => '1',
            'municipio_id' => '1',
        ]);

        Edital::create([
            'nome' => 'Teste1',
            'situacao' => 'Ativo',
            'rede' => '',
            'text' => '',
            'downloads' => '1',
            'ordem' => '1',
            'numero' => '1',
            'categoria' => '',
            'modalidade' => '',
            'turno' => '',
            'tags' => '',
            'documentos_inscricao' => 'Documentacao1Value',
            'etapas_processo' => '',
            'faixa_etaria' => '',
            'agendar_publicacao' => 'Sim',
            'udepi' => 'Sim',
            'contagem_editais' => '',
            'observacoes' => 'Teste',
            'dt_publicacao' => '2023-10-01',
            'dt_fim_edital' => '2023-10-31',
            'dt_inicio_inscricao' => '2023-10-01',
            'dt_fim_inscricao' => '2023-10-31',
            'data_publicacao' => '2023-10-01',
            'data_inicio_inscricao' => '2023-10-01',
            'data_fim_inscricao' => '2023-10-31',
            'escola_id' => '1',
            'municipio_id' => '1',
        ]);

        Edital::create([
            'nome' => 'Teste2',
            'situacao' => 'Ativo',
            'rede' => '',
            'text' => '',
            'downloads' => '1',
            'ordem' => '1',
            'numero' => '1',
            'categoria' => '',
            'modalidade' => '',
            'turno' => '',
            'tags' => '',
            'documentos_inscricao' => 'Documentacao1Value',
            'etapas_processo' => '',
            'faixa_etaria' => '',
            'agendar_publicacao' => 'Sim',
            'udepi' => 'Sim',
            'contagem_editais' => '',
            'observacoes' => 'Teste',
            'dt_publicacao' => '2023-10-01',
            'dt_fim_edital' => '2023-10-31',
            'dt_inicio_inscricao' => '2023-10-01',
            'dt_fim_inscricao' => '2023-10-31',
            'data_publicacao' => '2023-10-01',
            'data_inicio_inscricao' => '2023-10-01',
            'data_fim_inscricao' => '2023-10-31',
            'escola_id' => '1',
            'municipio_id' => '1',
        ]);

        Edital::create([
            'nome' => 'Teste3',
            'situacao' => 'Ativo',
            'rede' => '',
            'text' => '',
            'downloads' => '1',
            'ordem' => '1',
            'numero' => '1',
            'categoria' => '',
            'modalidade' => '',
            'turno' => '',
            'tags' => '',
            'documentos_inscricao' => 'Documentacao1Value',
            'etapas_processo' => '',
            'faixa_etaria' => '',
            'agendar_publicacao' => 'Sim',
            'udepi' => 'Sim',
            'contagem_editais' => '',
            'observacoes' => 'Teste',
            'dt_publicacao' => '2023-10-01',
            'dt_fim_edital' => '2023-10-31',
            'dt_inicio_inscricao' => '2023-10-01',
            'dt_fim_inscricao' => '2023-10-31',
            'data_publicacao' => '2023-10-01',
            'data_inicio_inscricao' => '2023-10-01',
            'data_fim_inscricao' => '2023-10-31',
            'escola_id' => '1',
            'municipio_id' => '1',
        ]);
    }
}
