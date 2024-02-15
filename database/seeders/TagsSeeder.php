<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::create([
            'nome' => 'Tecnologia da Informação',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Ciência de Dados',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Design e Criatividade',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Eletrônica e Microcontroladores',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Impressão 3D e Prototipagem',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Matemática',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Comunicação',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Internet das Coisas (IoT)',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Jogos e Realidade Virtual',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Prospecção Tecnológica',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Robótica',
            'situacao' => 'Ativo'
        ]);
        
        Tag::create([
            'nome' => 'Negócios e Empreendedorismo',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Habilidades Interpessoais',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Tecnologia e Informática',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Idiomas',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Impressão 3D',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Pilotagem e Tecnologia de Drones',
            'situacao' => 'Ativo'
        ]);

        Tag::create([
            'nome' => 'Lógica',
            'situacao' => 'Ativo'
        ]);
    }
}
