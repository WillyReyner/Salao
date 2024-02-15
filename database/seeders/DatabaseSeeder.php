<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Seed the application's database.
	 */
	public function run(): void
	{
		$this->call(PermissionSeeder::class);
		$this->call(AdminSeeder::class);
		$this->call(DocumentosExigidosSeed::class);
		$this->call(TagsSeeder::class);
		$this->call(HabilitadaSeeder::class);
		$this->call(MunicipioSeeder::class);
		$this->call(EditaisModeloSeeder::class);
		$this->call(subAreaSeeder::class);
		//	$this->call(EscolasSeeder::class);
		// $this->call(TurmasSeeder::class);
	}
}
