<?php

namespace Database\Seeders;

use App\Models\Municipio;
use Illuminate\Database\Seeder;

class MunicipioSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		Municipio::create([

			'nome' => 'Goiânia',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Caiapônia',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Catalão',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Ceres',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Cidade de Goiás',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Cristalina',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Formosa',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Goianésia',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Goiatuba',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Jaraguá',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Palmeiras',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Piranhas',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Porangatu',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Santa Helena',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);

		Municipio::create([
			'nome' => 'Uruana',
			'situacao' => 'Ativo',
			'uf' => '52',
		]);
	}
}
