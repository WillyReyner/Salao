<?php

namespace Database\Seeders;

use App\Models\Habilitacao;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HabilitadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Habilitacao::create([
            'nome' => 'Violinista',
            'situacao' => 'Ativo'
        ]);
        Habilitacao::create([
            'nome' => 'Violaocelo',
            'situacao' => 'Ativo'
        ]);
        Habilitacao::create([
            'nome' => 'Musicistico',
            'situacao' => 'Ativo'
        ]);
        Habilitacao::create([
            'nome' => 'Canto',
            'situacao' => 'Ativo'
        ]);
        Habilitacao::create([
            'nome' => 'Cantoria',
            'situacao' => 'Ativo'
        ]);
        Habilitacao::create([
            'nome' => 'Baterista',
            'situacao' => 'Ativo'
        ]);
        Habilitacao::create([
            'nome' => 'Percussão',
            'situacao' => 'Ativo'
        ]);
        Habilitacao::create([
            'nome' => 'Flautista',
            'situacao' => 'Ativo'
        ]);
    }
}
