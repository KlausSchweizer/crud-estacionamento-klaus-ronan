<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ReportController extends Controller
{
    public function logs(Request $request) {
        $logs = Activity::all();
        $pdf = Pdf::loadView('reports.log-report', ['logs' => $logs])
        ->setPaper('A4', 'portrait');

        $date = date('d-m-Y-H-i-s');
        $fileName = "log-$date.pdf";

        return $pdf->download($fileName);
    }
}
