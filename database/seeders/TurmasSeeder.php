<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Turma;

class TurmasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Turma::create([
            'nome' => 'Turma1',
            'situacao' => 'Ativo',
            'tipo' => '',
            'turno' => 'Integral',
            'modalidade' => 'EAD',
            'imagem' => '',
            'resumo' => 'Teste',
            'categoria' => 'Qualificacao',
            'nivel' => 'Intermediario',
            'faixa_etaria' => 'Infantil',
            'horas_curso' => '160',
            'contato' => '',
            'vagas' => '80',
            'dias_semana' => 'Segunda',
            'data_inicio' => '2023-10-10',
            'hora_inicio' => '2023-10-10 14:44:00',
            'hora_termino' => '2023-10-10 15:44:00',
            'edital_id' => '2',
            'curso_id' => '1',
        ]);

        Turma::create([
            'nome' => 'Turma2',
            'situacao' => 'Ativo',
            'tipo' => '',
            'turno' => 'Integral',
            'modalidade' => 'EAD',
            'imagem' => '',
            'resumo' => 'Teste',
            'categoria' => 'Qualificacao',
            'nivel' => 'Intermediario',
            'faixa_etaria' => 'Infantil',
            'horas_curso' => '160',
            'contato' => '',
            'vagas' => '80',
            'dias_semana' => 'Segunda',
            'data_inicio' => '2023-10-10',
            'hora_inicio' => '2023-10-10 14:44:00',
            'hora_termino' => '2023-10-10 15:44:00',
            'edital_id' => '2',
            'curso_id' => '1',
        ]);

        Turma::create([
            'nome' => 'Turma3',
            'situacao' => 'Ativo',
            'tipo' => '',
            'turno' => 'Integral',
            'modalidade' => 'EAD',
            'imagem' => '',
            'resumo' => 'Teste',
            'categoria' => 'Qualificacao',
            'nivel' => 'Intermediario',
            'faixa_etaria' => 'Infantil',
            'horas_curso' => '160',
            'contato' => '',
            'vagas' => '80',
            'dias_semana' => 'Segunda',
            'data_inicio' => '2023-10-10',
            'hora_inicio' => '2023-10-10 14:44:00',
            'hora_termino' => '2023-10-10 15:44:00',
            'edital_id' => '2',
            'curso_id' => '1',
        ]);

        Turma::create([
            'nome' => 'Turma4',
            'situacao' => 'Ativo',
            'tipo' => '',
            'turno' => 'Integral',
            'modalidade' => 'EAD',
            'imagem' => '',
            'resumo' => 'Teste',
            'categoria' => 'Qualificacao',
            'nivel' => 'Intermediario',
            'faixa_etaria' => 'Infantil',
            'horas_curso' => '160',
            'contato' => '',
            'vagas' => '80',
            'dias_semana' => 'Segunda',
            'data_inicio' => '2023-10-10',
            'hora_inicio' => '2023-10-10 14:44:00',
            'hora_termino' => '2023-10-10 15:44:00',
            'edital_id' => '2',
            'curso_id' => '1',
        ]);
    }
}
