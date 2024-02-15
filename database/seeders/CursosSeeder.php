<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;

class CursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Curso::create([
            'nome' => 'Desenvolveminto Web',
            'situacao' => 'Ativo',
            'link_video_apresentacao' => 'https://www.youtube.com/watch?v=LCjpoCgSb58&ab_channel=StandUpBrasil',
            'faixa_etaria' => '',
            'imagem' => '',
            'conteudo' => '',
            'destaque' => 'Sim',
            'eixo_tecnologico' => '',
            'objetivos' => 'Teste',
            'conteudo_programatico' => 'Teste',
            'campo_atuacao' => '',
            'resumo' => 'Teste',
            'trilha_informativa' => '',
            'curso_tecnico' => '',
            'qualificacao' => '',
            'tag' => 'TesteTag1, TesteTag2, TesteTag3',
            'descricao' => 'Teste',
            'created_by' => '1',
        ]);

        Curso::create([
            'nome' => 'Desenvolveminto JAVASCRIPT',
            'situacao' => 'Ativo',
            'link_video_apresentacao' => 'https://www.youtube.com/watch?v=LCjpoCgSb58&ab_channel=StandUpBrasil',
            'faixa_etaria' => '',
            'imagem' => '',
            'conteudo' => '',
            'destaque' => 'Sim',
            'eixo_tecnologico' => '',
            'objetivos' => 'Teste',
            'conteudo_programatico' => 'Teste',
            'campo_atuacao' => '',
            'resumo' => 'Teste',
            'trilha_informativa' => '',
            'curso_tecnico' => '',
            'qualificacao' => '',
            'tag' => 'TesteTag1, TesteTag2, TesteTag3',
            'descricao' => 'Teste',
            'created_by' => '1',
        ]);

        Curso::create([
            'nome' => 'Desenvolveminto PHP',
            'situacao' => 'Ativo',
            'link_video_apresentacao' => 'https://www.youtube.com/watch?v=LCjpoCgSb58&ab_channel=StandUpBrasil',
            'faixa_etaria' => '',
            'imagem' => '',
            'conteudo' => '',
            'destaque' => 'Sim',
            'eixo_tecnologico' => '',
            'objetivos' => 'Teste',
            'conteudo_programatico' => 'Teste',
            'campo_atuacao' => '',
            'resumo' => 'Teste',
            'trilha_informativa' => '',
            'curso_tecnico' => '',
            'qualificacao' => '',
            'tag' => 'TesteTag1, TesteTag2, TesteTag3',
            'descricao' => 'Teste',
            'created_by' => '1',
        ]);

        Curso::create([
            'nome' => 'Desenvolveminto Java',
            'situacao' => 'Ativo',
            'link_video_apresentacao' => 'https://www.youtube.com/watch?v=LCjpoCgSb58&ab_channel=StandUpBrasil',
            'faixa_etaria' => '',
            'imagem' => '',
            'conteudo' => '',
            'destaque' => 'Sim',
            'eixo_tecnologico' => '',
            'objetivos' => 'Teste',
            'conteudo_programatico' => 'Teste',
            'campo_atuacao' => '',
            'resumo' => 'Teste',
            'trilha_informativa' => '',
            'curso_tecnico' => '',
            'qualificacao' => '',
            'tag' => 'TesteTag1, TesteTag2, TesteTag3',
            'descricao' => 'Teste',
            'created_by' => '1',
        ]);
    }
}
