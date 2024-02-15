<?php

namespace Database\Seeders;

use App\Models\Escola;
use Illuminate\Database\Seeder;

class EscolasSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Escola::create([
			'nome' => 'Ruth Vilaça Correia Leite Cardoso',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Aguinaldo de Campos Netto',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Célio Domingos Mazzonetto',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => ' Goiandira Ayres do Couto',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Genervino Evangelista da Fonseca',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Carmem Dutra de Araújo',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Cotec Governador Otávio Lage',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Sebastião de Siqueira',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Jerônimo Carlos do Prado',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Irtes Alves de Castro Ribeiro',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Padre Antônio Vermey',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Fernando Cunha Júnior',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Maria Sebastiana da Silva',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Luiz Humberto de Menezes',
			'situacao' => 'Ativo',
		]);

		Escola::create([
			'nome' => 'Celso Monteiro Furtado',
			'situacao' => 'Ativo',

		]);
	}
}
