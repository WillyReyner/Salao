<?php

namespace Database\Seeders;

use App\Models\SubArea;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class subAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
	    SubArea::create([
		    'nome' => 'SubArea 1',
		    'situacao' => 'Ativo',
	    ]);
	    SubArea::create([
		    'nome' => 'SubArea 2',
		    'situacao' => 'Ativo',
	    ]);
	    SubArea::create([
		    'nome' => 'SubArea 3',
		    'situacao' => 'Ativo',
	    ]);
	    SubArea::create([
		    'nome' => 'SubArea 4',
		    'situacao' => 'Ativo',
	    ]);
	    SubArea::create([
		    'nome' => 'SubArea 5',
		    'situacao' => 'Ativo',
	    ]);
	    SubArea::create([
		    'nome' => 'SubArea 6',
		    'situacao' => 'Ativo',
	    ]);
	    SubArea::create([
		    'nome' => 'SubArea 7',
		    'situacao' => 'Ativo',
	    ]);
	    SubArea::create([
		    'nome' => 'SubArea 8',
		    'situacao' => 'Ativo',
	    ]);
	    SubArea::create([
		    'nome' => 'SubArea 9',
		    'situacao' => 'Ativo',
	    ]);
    }
}
