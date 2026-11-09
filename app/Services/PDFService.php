<?php

namespace App\Services;

use App\Mail\SendPaymentEmail;
use App\Models\Parking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class PDFService
{
    public function payment(Parking $parking): void
    {
        $parking->loadMissing('vehicle.clients');
        $emails = $parking->vehicle?->clients->pluck('email')->filter()->unique() ?? collect();

        if ($emails->isEmpty()) {
            return;
        }

        $pdf = Pdf::loadView('reports.payment-report', ['parking' => $parking])
            ->setPaper('A4', 'portrait');
        $fileName = 'payment-' . $parking->ticket . '-' . date('d-m-Y-H-i-s') . '.pdf';

        // Mensagens individuais para não expor endereços de outros clientes.
        foreach ($emails as $email) {
            Mail::to($email)->send(new SendPaymentEmail($pdf, $fileName));
        }
    }
}
