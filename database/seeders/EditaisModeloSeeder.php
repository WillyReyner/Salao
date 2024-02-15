<?php

namespace Database\Seeders;

use App\Models\EditalModelo;
use App\Models\TipoArquivo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EditaisModeloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
	    EditalModelo::create([
		    'nome' => 'Qualificação em Circo - Adulto (14 anos acima)',
	    ]);
		EditalModelo::create([
			'nome' => 'Qualificação em Circo - Infantojuvenil (08 à 13 anos)',
		]);
		EditalModelo::create([
			'nome' => 'Capacitação em Circo - Adulto (14 anos acima)',
		]);
		EditalModelo::create([
			'nome' => 'Capacitação em Circo - Infantojuvenil (08 à 13 anos)',
		]);
		EditalModelo::create([
			'nome' => 'Coletivo de Artes Visuais',
		]);
		EditalModelo::create([
			'nome' => 'Técnico de Nível Médio em Artes Visuais',
		]);
		EditalModelo::create([
			'nome' => 'Qualificação em Artes Visuais - Adulto (14 anos acima)',
		]);
		EditalModelo::create([
			'nome' => 'Qualificação em Artes Visuais -  Infantojuvenil (08 à 13 anos)',
		]);
		EditalModelo::create([
			'nome' => 'Capacitação em Artes Visuais - Adulto (14 anos acima)',
		]);
		EditalModelo::create([
			'nome' => 'Capacitação em Artes Visuais - Infantojuvenil (08 à 13 anos)',
		]);
		EditalModelo::create([
			'nome' => 'Capacitação em Arte Educação',
		]);
		EditalModelo::create([
			'nome' => 'Qualificação em Arte Educação',
		]);
		EditalModelo::create([
			'nome' => 'Produção Cênica - Portador de Diploma',
		]);
		EditalModelo::create([
			'nome' => 'Produção Cênica',
		]);
		EditalModelo::create([
			'nome' => 'Capacitação em Música - Infantojuvenil (08 à 13 anos)',
		]);
		EditalModelo::create([
			'nome' => 'Qualificação em Música - Adulto (14 anos acima)',
		]);
		EditalModelo::create([
			'nome' => 'Qualificação em Música - Infantojuvenil (08 à 13 anos)',
		]);
		EditalModelo::create([
			'nome' => 'Qualificação em Performance Musical',
		]);
		EditalModelo::create([
			'nome' => 'Corpos de Baile',
		]);
		EditalModelo::create([
			'nome' => 'Técnico de Nível Médio em Dança Contemporânea',
		]);
		EditalModelo::create([
			'nome' => 'Técnico de Nível Médio em Dança Ballet Clássico',
		]);
		EditalModelo::create([
			'nome' => 'Qualificação em Danças Urbanas - Adulto (14 anos acima)',
		]);
		EditalModelo::create([
			'nome' => 'Qualificação em Ballet - Adulto (14 anos acima)',
		]);
		EditalModelo::create([
			'nome' => 'Qualificação em Danças Urbanas - Infantojuvenil (08 à 13 anos)',
		]);
		EditalModelo::create([
			'nome' => 'Qualificação em Ballet - Infantojuvenil (08 à 13 anos)',
		]);
		EditalModelo::create([
			'nome' => 'Corpo Circense',
		]);
		EditalModelo::create([
			'nome' => 'Técnico de Nível Médio em Artes Circense',
		]);
	    EditalModelo::create([
		    'nome' => 'Capacitação em Música - Adulto (14 anos acima)',
	    ]);
	    EditalModelo::create([
		    'nome' => 'Técnico de Nível Médio em Música',
	    ]);
	    EditalModelo::create([
		    'nome' => 'Grupos Sinfônicos',
	    ]);
	    EditalModelo::create([
		    'nome' => 'Capacitação em Teatro - Infantojuvenil (08 à 13 anos)',
	    ]);
	    EditalModelo::create([
		    'nome' => 'Capacitação em Teatro - Adulto (14 anos acima)',
	    ]);
	    EditalModelo::create([
		    'nome' => 'Qualificação em Teatro - Infantojuvenil (08 à 13 anos)',
	    ]);
	    EditalModelo::create([
		    'nome' => 'Qualificação em Teatro - Adulto (14 anos acima)',
	    ]);
	    EditalModelo::create([
		    'nome' => 'Técnico de Nível Médio em Teatro',
	    ]);
	    EditalModelo::create([
		    'nome' => 'Corpo Cênico',
	    ]);
	    EditalModelo::create([
		    'nome' => 'Cursos em Tecnologia e  Inovação',
	    ]);
	    EditalModelo::create([
		    'nome' => 'Cursos de longa duração',
	    ]);
	    EditalModelo::create([
		    'nome' => 'Cursos de curta duração',
	    ]);
	    EditalModelo::create([
		    'nome' => 'Cursos de média duração',
	    ]);
    }
}
