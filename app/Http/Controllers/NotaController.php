<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TokoInfo;
use Barryvdh\DomPDF\Facade\Pdf;

class NotaController extends Controller
{
    public function generatePDF(Transaksi $transaksi)
    {
        $tokoInfo = TokoInfo::first();

        $pdf = Pdf::loadView('nota.pdf', [
            'transaksi' => $transaksi,
            'tokoInfo' => $tokoInfo
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('nota-' . $transaksi->id . '.pdf');
    }
}
