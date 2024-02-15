<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Edital;
use Carbon\Carbon;

class VerificarEditais extends Command
{
    protected $signature = 'editais:verificar';

    protected $description = 'Verificar os editais e atualizar a situação se o prazo expirou';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $editais = Edital::where('situacao', 'Ativo')->get();

        foreach ($editais as $edital) {
            $dataAtual = Carbon::now();
            $dataFimEdital = Carbon::parse($edital->dt_fim_edital);

            if ($dataFimEdital->isPast()) {
                // O prazo expirou, atualize a situação para 'Expirado'
                $edital->update(['situacao' => 'Expirado']);
                $this->info("Edital {$edital->id} atualizado para 'Expirado'");
            }
        }
    }
}
