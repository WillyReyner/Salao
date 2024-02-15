<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AreaSubarea;
use App\Models\EditalDocumento;
use App\Models\SubArea;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AreaController extends Controller
{
    public function __construct()
    {
		$this->middleware(['permission:Index Areas|Criar Areas|Editar Areas|Excluir Areas|Importar Areas|Exportar Areas']);
	}

	public function Index()
	{
		$areas = Area::with('criadoPor', 'modificadoPor')->get();
		return Inertia::render('Painel/Areas/Index', ['areas' => $areas]);
	}

	public function create()
	{
		$subAreas = SubArea::all();
		return Inertia::render('Painel/Areas/Novo', ['subAreas' => $subAreas]);
	}

	public function edit($id)
	{
		$area = Area::with('area_subareas.subareas')->find($id);
		$subareas = SubArea::with('subarea')->get();
		return Inertia::render('Painel/Areas/Editar', ['areas' => $area, 'subAreas' => $subareas]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'nome' => 'required',
		]);

		$area = Area::create([
			'nome' => $request->nome,
			'situacao' => 'Ativo',
			'created_by' => auth()->user()->id,
		]);

//		$area->subareas->delete();

		foreach ($request->input('subAreas') as $subareas) {
			AreaSubarea::insert([
				'subarea_id' => $subareas['value'],
				'area_id' => $area->id,
			]);
		}
		return redirect()->route('painel.areas')->with('response', $area);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'nome' => 'required',
		], [
			'required' => 'O campo é obrigatório',
		]);

		$area = Area::with('area_subareas.subareas')->find($id);
		$area->nome = $request->nome;

		$area->save();

		$area->area_subareas()->delete();

		if($request->has('subarea')) {
			foreach ($request->input('subarea') as $subareas) {
				AreaSubarea::insert([
					'subarea_id' => $subareas['value'],
					'area_id' => $area->id,
				]);
			}
		}
		return redirect()->route('painel.areas')->with('response', $area);
	}

	public function destroy(Request $request)
	{
		$id = $request->id;

		$Area = is_array($id) ? Area::destroy($id) : Area::findOrFail($id)->delete();

		return redirect()->route('painel.areas')->with('response', $Area);
	}

	public function subAreaDestroy(Request $request)
	{
		$id = $request->id;

		$Area = is_array($id) ? SubArea::destroy($id) : SubArea::findOrFail($id)->delete();
	}

}
