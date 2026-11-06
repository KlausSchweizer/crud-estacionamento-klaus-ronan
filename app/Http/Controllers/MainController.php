<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class MainController extends Controller
{
    public function index() {
        return view('index');
    }

    public function logs(Request $request) {
        $logs = Activity::orderBy('created_at', 'desc')->get();

        return view('logs.logs', ['logs' => $logs]);
    }
}
