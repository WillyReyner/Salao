<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index() {

        $logs = Activity::all();

        return Inertia::render('Painel/Log', [
            'logs' => $logs,
        ]);
    }
}
