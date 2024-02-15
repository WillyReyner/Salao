<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Escola;
use App\Models\Edital;
use App\Models\Municipio;
use App\Models\Curso;
use App\Models\Turma;
use Illuminate\Support\Facades\Storage;

class TurmaApiController extends Controller
{

    public function index()
    {
        $escolas = Escola::all();
        $editais = Edital::all();
        $cursos = Curso::all();
        $turmas = Turma::with('edital', 'curso','criadoPor','modificadoPor')->get();

        return response()->json([
            'turmas' => $turmas,
            'escolas' => $escolas,
            'editais' => $editais,
            'cursos' => $cursos,
        ]);
    }

    public function show($id)
    {
        $turma = Turma::with('inscricoes', 'edital', 'curso','criadoPor', 'modificadoPor')->find($id);
        return response()->json([
            'turma' => $turma,
        ]);
    }

    public function edit($id)
    {
        $cursos = Curso::all();
        $editais = Edital::all();
        $turma = Turma::with('edital', 'curso','criadoPor', 'modificadoPor')->find($id);

        return response()->json([
            'turma' => $turma,
            'cursos' => $cursos,
            'editais' => $editais,
        ]);
    }

    public function create()
    {
        $cursos = Curso::all();
        $editais = Edital::all();

        return response()->json([
            'cursos' => $cursos,
            'editais' => $editais,
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'categoria' => 'required',
            'dias_semana' => 'required',
            'nivel' => 'required',
            'faixa_etaria' => 'required',
            'resumo' => 'required',
            'edital_id' => 'required',
            'curso_id' => 'required',
            'vagas' => 'required',
            'turno' => 'required',
            'hora_inicio' => 'required',
            'hora_termino' => 'required',
            'data_inicio' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);

            // // Analise de Dados turno
            // if($request->turno === 'Manha'){ $turnonome = 'M'; }
            // elseif( $request->turno === 'Tarde'){ $turnonome = 'T'; }
            // else{ $turnonome = 'N'; }

            // //Analise de dados dias da semana
            // if( $request->dias_semana === 'Domingo'){ $dias_semana_id = '1'; }
            // elseif( $request->dias_semana === 'Segunda' ){ $dias_semana_id = '2'; }
            // elseif( $request->dias_semana === 'Terça' ){ $dias_semana_id = '3'; }
            // elseif( $request->dias_semana === 'Quarta' ){ $dias_semana_id = '4'; }
            // elseif( $request->dias_semana === 'Quinta' ){ $dias_semana_id = '5'; }
            // elseif( $request->dias_semana === 'Sexta' ){ $dias_semana_id = '6'; }
            // else{ $dias_semana_id = '7'; }

            // //Analise de dados hora inicial e termino das turmas
            // $horario_inicial = $request->hora_inicio;
            // $partes = explode(":", $horario_inicial);
            // $hora_i = $partes[0];
            
            // $horario_final = $request->hora_termino;
            // $partes = explode(":", $horario_final);
            // $hora_f = $partes[0];

            // if ($hora_i >= 7 && $hora_f < 12) {
            //     $turno_t = 'M';
            // } elseif ($hora_i >= 12 && $hora_f < 17) {
            //     $turno_t = 'T';
            // } elseif ($hora_i >= 17 && $hora_f < 22) {
            //     $turno_t = 'N';
            // } else {
            //     $turno_t = 'Outro';
            // }
            
            // if( $turno_t === 'M' && $hora_i == '07' && $hora_f  == '08'){ $horario_id = '1'; }
            // elseif( $turno_t === 'M' && $hora_i == '08' && $hora_f  == '09' ){ $horario_id = '2'; }
            // elseif( $turno_t === 'M' && $hora_i == '09' && $hora_f  == '10' ){ $horario_id = '3'; }
            // elseif( $turno_t === 'M' && $hora_i == '10' && $hora_f  == '11' ){ $horario_id = '4'; }
            // elseif( $turno_t === 'M' && $hora_i == '11' && $hora_f  == '12' ){ $horario_id = '5'; }

            // if( $turno_t === 'T' && $hora_i == '12' && $hora_f  == '13'){ $horario_id = '1'; }
            // elseif( $turno_t === 'T' && $hora_i == '13' && $hora_f  == '14' ){ $horario_id = '2'; }
            // elseif( $turno_t === 'T' && $hora_i == '14' && $hora_f  == '15' ){ $horario_id = '3'; }
            // elseif( $turno_t === 'T' && $hora_i == '15' && $hora_f  == '16' ){ $horario_id = '4'; }
            // elseif( $turno_t === 'T' && $hora_i == '16' && $hora_f  == '17' ){ $horario_id = '5'; }

            // if( $turno_t === 'N' && $hora_i == '17' && $hora_f  == '18'){ $horario_id = '1'; }
            // elseif( $turno_t === 'N' && $hora_i == '18' && $hora_f  == '19' ){ $horario_id = '2'; }
            // elseif( $turno_t === 'N' && $hora_i == '19' && $hora_f  == '20' ){ $horario_id = '3'; }
            // elseif( $turno_t === 'N' && $hora_i == '20' && $hora_f  == '21' ){ $horario_id = '4'; }
            // elseif( $turno_t === 'N' && $hora_i == '21' && $hora_f  == '22' ){ $horario_id = '5'; }
            
            
            // $curso = Curso::find($request->curso_id);
            // $cursonome = $curso->nome;

            //Gravação no banco de dados

             $turma = Turma::create([
            'nome' => $request->nome,
            'situacao' => 'Ativo',
            'categoria' => $request->categoria,
            'dias_semana' => implode(', ', $request->dias_semana),
            'nivel' => $request->nivel,
            'faixa_etaria' => $request->faixa_etaria,
            'modalidade' => $request->modalidade,
            'horas_curso' => $request->horas_curso,
            'resumo' => $request->resumo,
            'edital_id' => $request->edital_id,
            'curso_id' => $request->curso_id,
            'vagas' => $request->vagas,
            'turno' => implode(', ', $request->turno),
            'hora_inicio' => date('Y-m-d H:i:s', strtotime($request->hora_inicio)),
            'hora_termino' => date('Y-m-d H:i:s', strtotime($request->hora_termino)),
            'data_inicio' => $request->data_inicio,
            'created_by' => auth()->user()->id,
            ]);
        
            // Salvar a instância no banco de dados
            $turma->save();
        
            if($request->file('imagem')){
                $path = Storage::putFile('turmas/'.$turma->id, $request->file('imagem'));
                $turma->imagem = $path;
            }

            return response()->json(['message' => 'Turma criada com sucesso', 'turma' => $turma], 201);
    }
    
    public function update(Request $request, $id) {
        $request->validate([
            'categoria' => 'required',
            'dias_semana' => 'required',
            'nivel' => 'required',
            'faixa_etaria' => 'required',
            'resumo' => 'required',
            'edital_id' => 'required',
            'curso_id' => 'required',
            'vagas' => 'required',
            'turno' => 'required',
            'hora_inicio' => 'required',
            'hora_termino' => 'required',
            'data_inicio' => 'required',
        ], [
            'required' => 'O campo é obrigatório',
        ]);

        // if($request->turno === 'Manha'){ $turnonome = 'M'; }
        // elseif( $request->turno === 'Tarde'){ $turnonome = 'T'; }
        // else{ $turnonome = 'N'; }

        // //Analise de dados dias da semana
        // if( $request->dias_semana === 'Domingo'){ $dias_semana_id = '1'; }
        // elseif( $request->dias_semana === 'Segunda' ){ $dias_semana_id = '2'; }
        // elseif( $request->dias_semana === 'Terça' ){ $dias_semana_id = '3'; }
        // elseif( $request->dias_semana === 'Quarta' ){ $dias_semana_id = '4'; }
        // elseif( $request->dias_semana === 'Quinta' ){ $dias_semana_id = '5'; }
        // elseif( $request->dias_semana === 'Sexta' ){ $dias_semana_id = '6'; }
        // else{ $dias_semana_id = '7'; }

        // //Analise de dados hora inicial e termino das turmas
        // $horario_inicial = $request->hora_inicio;
        // $partes = explode(":", $horario_inicial);
        // $hora_i = $partes[0];
        
        // $horario_final = $request->hora_termino;
        // $partes = explode(":", $horario_final);
        // $hora_f = $partes[0];

        // if ($hora_i >= 7 && $hora_f < 12) {
        //     $turno_t = 'M';
        // } elseif ($hora_i >= 12 && $hora_f < 17) {
        //     $turno_t = 'T';
        // } elseif ($hora_i >= 17 && $hora_f < 22) {
        //     $turno_t = 'N';
        // } else {
        //     $turno_t = 'Outro';
        // }
        
        // if( $turno_t === 'M' && $hora_i == '07' && $hora_f  == '08'){ $horario_id = '1'; }
        // elseif( $turno_t === 'M' && $hora_i == '08' && $hora_f  == '09' ){ $horario_id = '2'; }
        // elseif( $turno_t === 'M' && $hora_i == '09' && $hora_f  == '10' ){ $horario_id = '3'; }
        // elseif( $turno_t === 'M' && $hora_i == '10' && $hora_f  == '11' ){ $horario_id = '4'; }
        // elseif( $turno_t === 'M' && $hora_i == '11' && $hora_f  == '12' ){ $horario_id = '5'; }

        // if( $turno_t === 'T' && $hora_i == '12' && $hora_f  == '13'){ $horario_id = '1'; }
        // elseif( $turno_t === 'T' && $hora_i == '13' && $hora_f  == '14' ){ $horario_id = '2'; }
        // elseif( $turno_t === 'T' && $hora_i == '14' && $hora_f  == '15' ){ $horario_id = '3'; }
        // elseif( $turno_t === 'T' && $hora_i == '15' && $hora_f  == '16' ){ $horario_id = '4'; }
        // elseif( $turno_t === 'T' && $hora_i == '16' && $hora_f  == '17' ){ $horario_id = '5'; }

        // if( $turno_t === 'N' && $hora_i == '17' && $hora_f  == '18'){ $horario_id = '1'; }
        // elseif( $turno_t === 'N' && $hora_i == '18' && $hora_f  == '19' ){ $horario_id = '2'; }
        // elseif( $turno_t === 'N' && $hora_i == '19' && $hora_f  == '20' ){ $horario_id = '3'; }
        // elseif( $turno_t === 'N' && $hora_i == '20' && $hora_f  == '21' ){ $horario_id = '4'; }
        // elseif( $turno_t === 'N' && $hora_i == '21' && $hora_f  == '22' ){ $horario_id = '5'; }
        
        
        // $curso = Curso::find($request->curso_id);
        // $cursonome = $curso->nome;

        $turma = Turma::find($id);
        $turma->nome = $request->nome;
        $turma->categoria = $request->categoria;
        $turma->nivel = $request->nivel;
        $turma->faixa_etaria = $request->faixa_etaria;
        $turma->turno = $request->turno;
        $turma->modalidade = $request->modalidade;
        $turma->horas_curso = $request->horas_curso;
        $turma->resumo = $request->resumo;
        $turma->vagas = $request->vagas;
        $turma->data_inicio = $request->data_inicio;
        $turma->dias_semana = $request->dias_semana;
        $turma->edital_id = $request->edital_id;
        $turma->curso_id = $request->curso_id;
        $turma->hora_inicio = $request->hora_inicio;
        $turma->hora_termino = $request->hora_termino;
        $turma->updated_by = auth()->user()->id;

        $turma->save();

        return response()->json(['message' => 'Turma atualizada com sucesso', 'turma' => $turma]);
    }


    public function destroy(Request $request) {

        $id = $request->id;

        $turma = is_array($id) ? Turma::destroy($id) : Turma::findOrFail($id)->delete();

        return response()->json(['message' => 'Turma(s) excluída(s) com sucesso']);
    }

    public function reuse(Request $request){

        // Analise de Dados turno
        if($request->turno === 'Manha'){ $turnonome = 'M'; }
        elseif( $request->turno === 'Tarde'){ $turnonome = 'T'; }
        else{ $turnonome = 'N'; }
        //Analise de dados dias da semana
        if( $request->dias_semana === 'Domingo'){ $dias_semana_id = '1'; }
        elseif( $request->dias_semana === 'Segunda' ){ $dias_semana_id = '2'; }
        elseif( $request->dias_semana === 'Terça' ){ $dias_semana_id = '3'; }
        elseif( $request->dias_semana === 'Quarta' ){ $dias_semana_id = '4'; }
        elseif( $request->dias_semana === 'Quinta' ){ $dias_semana_id = '5'; }
        elseif( $request->dias_semana === 'Sexta' ){ $dias_semana_id = '6'; }
        else{ $dias_semana_id = '7'; }
        //Analise de dados hora inicial e termino das turmas
        $horario_inicial = $request->hora_inicio;
        $partes = explode(":", $horario_inicial);
        $hora_i = $partes[0];
        
        $horario_final = $request->hora_termino;
        $partes = explode(":", $horario_final);
        $hora_f = $partes[0];

        if ($hora_i >= 7 && $hora_f < 12) { $turno_t = 'M'; } 
        elseif ($hora_i >= 12 && $hora_f < 17) { $turno_t = 'T'; } 
        elseif ($hora_i >= 17 && $hora_f < 22) { $turno_t = 'N'; } 
        else { $turno_t = 'Outro'; }
        
        if( $turno_t === 'M' && $hora_i == '07' && $hora_f  == '08'){ $horario_id = '1'; }
        elseif( $turno_t === 'M' && $hora_i == '08' && $hora_f  == '09' ){ $horario_id = '2'; }
        elseif( $turno_t === 'M' && $hora_i == '09' && $hora_f  == '10' ){ $horario_id = '3'; }
        elseif( $turno_t === 'M' && $hora_i == '10' && $hora_f  == '11' ){ $horario_id = '4'; }
        elseif( $turno_t === 'M' && $hora_i == '11' && $hora_f  == '12' ){ $horario_id = '5'; }

        if( $turno_t === 'T' && $hora_i == '12' && $hora_f  == '13'){ $horario_id = '1'; }
        elseif( $turno_t === 'T' && $hora_i == '13' && $hora_f  == '14' ){ $horario_id = '2'; }
        elseif( $turno_t === 'T' && $hora_i == '14' && $hora_f  == '15' ){ $horario_id = '3'; }
        elseif( $turno_t === 'T' && $hora_i == '15' && $hora_f  == '16' ){ $horario_id = '4'; }
        elseif( $turno_t === 'T' && $hora_i == '16' && $hora_f  == '17' ){ $horario_id = '5'; }

        if( $turno_t === 'N' && $hora_i == '17' && $hora_f  == '18'){ $horario_id = '1'; }
        elseif( $turno_t === 'N' && $hora_i == '18' && $hora_f  == '19' ){ $horario_id = '2'; }
        elseif( $turno_t === 'N' && $hora_i == '19' && $hora_f  == '20' ){ $horario_id = '3'; }
        elseif( $turno_t === 'N' && $hora_i == '20' && $hora_f  == '21' ){ $horario_id = '4'; }
        elseif( $turno_t === 'N' && $hora_i == '21' && $hora_f  == '22' ){ $horario_id = '5'; }
        
        $edital = Edital::find($request->edital_id);
        if ($edital) { 
            $edital->increment('contagem_editais', 1); 
        }

        $curso = Curso::find($request->curso_id);
        $cursonome = $curso->nome;
        $turma = Turma::create([
        'nome' => "$request->edital_id Edital - EFG/UDEPI - $cursonome - $request->categoria - $request->modalidade - $dias_semana_id$turnonome",
        'situacao' => 'Ativo',
        'categoria' => $request->categoria,
        'dias_semana' => $request->dias_semana,
        'nivel' => $request->nivel,
        'faixa_etaria' => $request->faixa_etaria,
        'modalidade' => $request->modalidade,
        'horas_curso' => $request->horas_curso,
        'resumo' => $request->resumo,
        'edital_id' => $request->edital_id,
        'curso_id' => $request->curso_id,
        'vagas' => $request->vagas,
        'turno' => $request->turno,
        'hora_inicio' => $request->hora_inicio,
        'hora_termino' => $request->hora_termino,
        'data_inicio' => $request->data_inicio,
        'created_by' => auth()->user()->id,
        ]);

        $turma->save();
        
        return response()->json(['message' => 'Turma reautilizada com sucesso', 'turma' => $turma], 201);
    }
}
