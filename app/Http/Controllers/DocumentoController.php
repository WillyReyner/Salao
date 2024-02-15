<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
	// public function __construct()
	// {
	//     $this->middleware(['permission:Index Documentos|Criar Documentos|Editar Documentos|Excluir Documentos|Importar Documentos|Exportar Documentos']);
	// }

	public function store(Request $request)
	{
		$request->validate([
			'versao' => 'required',
			'situacao' => 'required',
			'tipo' => 'required',
			'data_publicacao' => 'required'
		], [
			'required' => 'O campo é obrigatório',
		]);
		
		$tipo = is_array($request->tipo) ? implode(', ', $request->tipo) : $request->tipo;
		$versao = is_array($request->versao) ? implode(', ', $request->versao) : $request->versao;

		$documento = Documento::create([
			'situacao' => $request->situacao,
			'tipo' => $tipo,
			'versao' => $versao,
			'data_publicacao' => $request->data_publicacao,
			'created_by' => auth()->user()->id,
			'edital_id' => $request->edital_id
		]);

		if ($request->file('arquivo')) {
			$pathPdf = Storage::putFile('documentos', $request->file('arquivo'));
			$documento->caminho = $pathPdf;
		}

		$documento->save();

		return redirect()->back()->with('response', $documento);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'versao' => 'required',
			'situacao' => 'required',
			'tipo' => 'required',
			'data_publicacao' => 'required'
		], [
			'required' => 'O campo é obrigatório',
		]);


		$documento = Documento::find($id);
		$documento->situacao = $request->situacao;
		$documento->tipo = $request->tipo;
		$documento->versao = $request->versao;
		$documento->data_publicacao = $request->data_publicacao;

		// if($request->file('arquivo')){
		//     $pathPdf = Storage::putFile('documentos', $request->file('arquivo'));
		//     $documento->caminho = $pathPdf;
		// }

		$documento->updated_by = auth()->user()->id;

		$documento->save();

		return redirect()->back()->with('response', $documento);
	}

	public function destroy($id)
	{
		$documento = Documento::find($id);
		$documento->delete();

		return redirect()->back()->with('response', $documento);
	}
}
