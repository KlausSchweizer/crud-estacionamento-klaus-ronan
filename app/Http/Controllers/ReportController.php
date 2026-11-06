<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Models\Vehicle;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\Ticket;
use Spatie\Activitylog\Models\Activity;

class ReportController extends Controller
{
    public function logs(Request $request)
    {
        $logs = Activity::all();
        $pdf = Pdf::loadView('reports.log-report', ['logs' => $logs])
            ->setPaper('A4', 'portrait');

        $date = date('d-m-Y-H-i-s');
        $fileName = "log-$date.pdf";

        return $pdf->download($fileName);
    }

    public function vehicles(Request $request)
    {
        $vehicles = Vehicle::all();
        $pdf = Pdf::loadView('reports.vehicles-report', ['vehicles' => $vehicles])
            ->setPaper('A4', 'portrait');

        $date = date('d-m-Y-H-i-s');
        $fileName = "vehicles-$date.pdf";

        return $pdf->download($fileName);
    }

    public function payment(Request $request, int $ticket)
    {
        $parking = Parking::where('ticket', $ticket)->first();
        $pdf = Pdf::loadView('reports.payment-report', ['parking' => $parking])
            ->setPaper('A4', 'portrait');

        $date = date('d-m-Y-H-i-s');
        $fileName = "payment-$date.pdf";

        return $pdf->stream($fileName);
    }
}
