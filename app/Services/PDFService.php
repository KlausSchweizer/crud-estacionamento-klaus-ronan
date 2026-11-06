<?php

namespace App\Services;

use App\Mail\SendPaymentEmail;
use App\Models\Parking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PDFService
{
    public function payment(Parking $parking)
    {
        if ($parking->email == null) {
            return;
        }
        $email = $parking->email;
        $pdf = Pdf::loadView('reports.payment-report', ['parking' => $parking])
            ->setPaper('A4', 'portrait');

        $date = date('d-m-Y-H-i-s');
        $fileName = "payment-$date.pdf";

        Mail::to($email)->send(new SendPaymentEmail($pdf, $fileName));
    }
}
