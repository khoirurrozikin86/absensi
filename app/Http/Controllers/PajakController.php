<?php

namespace App\Http\Controllers;

use App\Models\Pajak;
use App\Models\StatusPtkp;
use Illuminate\Http\Request;
use App\Exports\PajakExport;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;

class PajakController extends Controller
{
   public function index(Request $request)
    {
        $data = Pajak::with(['user', 'status_ptkp'])
            ->orderBy('id', 'DESC');

        if ($request->tahun && !$request->bulan) {
            $data->where('tahun', $request->tahun);
        } elseif ($request->tahun && $request->bulan) {
            $data->where('tahun', $request->tahun)
                ->where('bulan', $request->bulan);
        }

        // dd($data->paginate(10)->withQueryString());
        return view('pajak.index', [
            'title' => 'Data Pajak Karyawan',
            'data' => $data->paginate(10)->withQueryString()
        ]);
    }

    public function exportDataPajak()
    {
        return (new PajakExport($_GET))->download('List Data Pajak.xlsx');
    }
    public function downloadDataPajak($id, $payroll_id)
    {
        $pdf = Pdf::loadView('pajak.download', [
            'title' => 'Penggajian',
            'data' => Pajak::find($id),
            'salary' => Payroll::find($payroll_id)
        ]);

        return $pdf->stream();
    }

    public function downloadDataPajakUser($payroll_id)
    {
        $pajak = Pajak::where('payroll_id', $payroll_id)->first();
        $pdf = Pdf::loadView('pajak.download', [
            'title' => 'Penggajian',
            'data' => $pajak,
            'salary' => Payroll::find($payroll_id)
        ]);

        return $pdf->stream();
    }
}
