<?php

namespace App\Http\Controllers;

use App\Models\TickedNotification;
use App\Models\Ticket;
use App\Models\ticketDestinatarios;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

class TicketController extends Controller
{
	public function __construct()
	{
		$this->middleware(['permission:Index Ticket|Criar Ticket|Editar Ticket|Excluir Ticket|Importar Ticket|Exportar Ticket']);
	}

	public function index()
	{
		$ticket = Ticket::with('criadoPor', 'modificadoPor', 'TickedNotification')->get();
		return Inertia::render('Painel/Ticket/Index', [
			'ticket' => $ticket
		]);
	}

	public function show($id)
	{
		$ticket = Ticket::find($id);
		return Inertia::render('Painel/Ticket/Detalhes', ['$ticket' => $ticket]);
	}

	public function edit(Request $request, $id)
	{
		$ticket = Ticket::with('criadoPor', 'modificadoPor')->find($id);
		return Inertia::render('Painel/Ticket/Editar', [
			'ticket' => $ticket
		]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'ticket' => 'required',
			'users' => 'required',
		], [
			'required' => 'O campo é obrigatório',
		]);

		$ticket = Ticket::create([
			'tickets' => $request->ticket,
			'orientacao' => $request->orientacao,
			'tipo_arquivo' => $request->tipo_arquivo,
			'tipo_versao' => $request->tipo_versao,
			'created_by' => auth()->user()->id,
		]);

		foreach ($request->input('users') as $user) {
			TickedNotification::insert([
				'ticket_id' => $ticket->id,
				'user_id' => $user['value'],
			]);
		}
		return redirect()->route('painel.ticket')->with('response', $ticket);
	}

	public function create()
	{
		$users = User::all();

		return Inertia::render('Painel/Ticket/Novo', ['users' => $users]);
	}

	public function update(Request $request, $id)
	{
		$request->validate([
			'nome' => 'required',
			'orientacao' => 'required',
			'tipo_arquivo' => 'required',
			'tipo_versao' => 'required',
		], [
			'required' => 'O campo é obrigatório',
		]);

		$ticket = Ticket::find($id);
		$ticket->nome = $request->nome;
		$ticket->tipo_versao = $request->tipo_versao;
		$ticket->orientacao = $request->orientacao;
		$ticket->tipo_arquivo = $request->tipo_arquivo;

		$ticket->updated_by = auth()->user()->id;

		$ticket->save();

		$ticket->ticket()->delete();

		foreach ($request->input('users') as $user) {
			TickedNotification::insert([
				'ticket_id' => $ticket->id,
				'user_id' => $user
			]);
		}

		return redirect()->route('painel.ticket')->with('response', $ticket);
	}

	public function destroy(Request $request)
	{
		$id = $request->id;

		$ticketNotification = TickedNotification::where('ticket_id', $id)->delete();

		$ticket = is_array($id) ? Ticket::destroy($id) : Ticket::findOrFail($id)->delete();

		return redirect()->route('painel.ticket')->with('response', [$ticket, $ticketNotification]);
	}

	public function log(Request $request, $id)
	{
		$ticket = Ticket::with('criadoPor', 'modificadoPor')->findOrFail($id);
		$logs = Activity::where('subject_type', Ticket::class)
			->where('subject_id', $ticket->id)
			->with('causer')
			->get();
		return Inertia::render('Painel/Ticket/Log', [
			'tipoArquivo' => $ticket,
			'logs' => $logs,
		]);
	}

	public function read($id)
	{
		$ticket = Ticket::find($id);
		$ticket->read = 1;
		$ticket->TickedNotification()->delete();
		return redirect()->route('painel.ticket')->with('response', $ticket);
	}
}
