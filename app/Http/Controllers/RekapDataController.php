<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Cuti;
use App\Models\User;
use App\Models\Lembur;
use App\Models\Counter;
use App\Models\Payroll;
use App\Exports\RekapExport;
use App\Models\MappingShift;
use App\Models\Pajak;
use App\Models\StatusPtkp;
use App\Models\TarifPph;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use RealRashid\SweetAlert\Facades\Alert;

class RekapDataController extends Controller
{
    public function index()
    {
        return view('rekapdata.index', [
            'title' => 'Rekap Data Absensi',
        ]);
    }

    public function getData()
    {
        request()->validate([
            'mulai' => 'required',
            'akhir' => 'required',
        ]);

        date_default_timezone_set('Asia/Jakarta');

        $user = User::orderBy('name', 'ASC')->paginate(10)->withQueryString();

        $mulai = request()->input('mulai');
        $akhir = request()->input('akhir');
        $title = "Rekap Data Absensi";

        return view('rekapdata.getdata', [
            'title' => $title,
            'data_user' => $user,
            'tanggal_mulai' => $mulai,
            'tanggal_akhir' => $akhir
        ]);
    }

    public function export()
    {
        return (new RekapExport($_GET))->download('List Rekap Data.xlsx');
    }

    public function payroll($id)
    {
        $user = User::find($id);
        $mulai = request()->input('mulai');
        $akhir = request()->input('akhir');
        $counter = Counter::where('name', 'Gaji')->first();
        $counter->update(['counter' => $counter->counter + 1]);
        $next_number = str_pad($counter->counter, 6, '0', STR_PAD_LEFT);
        $no_gaji = $counter->text . $next_number;

        return view('rekapdata.payroll', [
            'title' => 'Penggajian',
            'user' => $user,
            'tanggal_mulai' => $mulai,
            'tanggal_akhir' => $akhir,
            'no_gaji' => $no_gaji
        ]);
    }

    public function tambahPayroll(Request $request)
    {
        $cek = Payroll::where('user_id', $request['user_id'])->where('bulan', $request['bulan'])->where('tahun', $request['tahun'])->first();
        if ($cek) {
            Alert::error('Failed', 'Sudah Ada Data Pada Bulan Dan Tahun Tersebut!');
            return redirect('/rekap-data/get-data?mulai='.$request['tanggal_mulai'].'&akhir='.$request['tanggal_akhir'])->with('failed', 'Data Berhasil Disimpan');
        } else {
            $validated = $request->validate([
                'user_id' => 'required',
                'bulan' => 'required',
                'tahun' => 'required',
                'tanggal_mulai' => 'required',
                'tanggal_akhir' => 'required',
                'persentase_kehadiran' => 'required',
                'no_gaji' => 'required',
                'gaji_pokok' => 'required',
                'total_reimbursement' => 'required',
                'uang_transport' => 'required',
                'jumlah_mangkir' => 'required',
                'uang_mangkir' => 'required',
                'total_mangkir' => 'required',
                'jumlah_lembur' => 'required',
                'uang_lembur' => 'required',
                'total_lembur' => 'required',
                'jumlah_izin' => 'required',
                'uang_izin' => 'required',
                'total_izin' => 'required',
                'bonus_pribadi' => 'required',
                'bonus_team' => 'required',
                'bonus_jackpot' => 'required',
                'jumlah_terlambat' => 'required',
                'uang_terlambat' => 'required',
                'total_terlambat' => 'required',
                'jumlah_kehadiran' => 'required',
                'uang_kehadiran' => 'required',
                'total_kehadiran' => 'required',
                'saldo_kasbon' => 'required',
                'bayar_kasbon' => 'required',
                'jumlah_thr' => 'required',
                'uang_thr' => 'required',
                'total_thr' => 'required',
                'loss' => 'required',
                'tunjangan_bpjs_ketenagakerjaan' => 'required',
                'tunjangan_bpjs_kesehatan' => 'required',
                'tunjangan_pajak' => 'required',
                'potongan_bpjs_kesehatan' => 'required',
                'potongan_bpjs_ketenagakerjaan' => 'required',
                'total_penjumlahan' => 'required',
                'total_pengurangan' => 'required',
                'grand_total' => 'required',
            ]);

            $validated['gaji_pokok'] = str_replace(',', '', $validated['gaji_pokok']);
            $validated['total_reimbursement'] = str_replace(',', '', $validated['total_reimbursement']);
            $validated['uang_transport'] = str_replace(',', '', $validated['uang_transport']);
            $validated['uang_mangkir'] = str_replace(',', '', $validated['uang_mangkir']);
            $validated['total_mangkir'] = str_replace(',', '', $validated['total_mangkir']);
            $validated['uang_lembur'] = str_replace(',', '', $validated['uang_lembur']);
            $validated['total_lembur'] = str_replace(',', '', $validated['total_lembur']);
            $validated['uang_izin'] = str_replace(',', '', $validated['uang_izin']);
            $validated['total_izin'] = str_replace(',', '', $validated['total_izin']);
            $validated['bonus_pribadi'] = str_replace(',', '', $validated['bonus_pribadi']);
            $validated['bonus_team'] = str_replace(',', '', $validated['bonus_team']);
            $validated['bonus_jackpot'] = str_replace(',', '', $validated['bonus_jackpot']);
            $validated['uang_terlambat'] = str_replace(',', '', $validated['uang_terlambat']);
            $validated['total_terlambat'] = str_replace(',', '', $validated['total_terlambat']);
            $validated['uang_kehadiran'] = str_replace(',', '', $validated['uang_kehadiran']);
            $validated['total_kehadiran'] = str_replace(',', '', $validated['total_kehadiran']);
            $validated['saldo_kasbon'] = str_replace(',', '', $validated['saldo_kasbon']);
            $validated['bayar_kasbon'] = str_replace(',', '', $validated['bayar_kasbon']);
            $validated['uang_thr'] = str_replace(',', '', $validated['uang_thr']);
            $validated['total_thr'] = str_replace(',', '', $validated['total_thr']);
            $validated['tunjangan_bpjs_ketenagakerjaan'] = str_replace(',', '', $validated['tunjangan_bpjs_ketenagakerjaan']);
            $validated['tunjangan_bpjs_kesehatan'] = str_replace(',', '', $validated['tunjangan_bpjs_kesehatan']);
            $validated['tunjangan_pajak'] = str_replace(',', '', $validated['tunjangan_pajak']);
            $validated['potongan_bpjs_ketenagakerjaan'] = str_replace(',', '', $validated['potongan_bpjs_ketenagakerjaan']);
            $validated['potongan_bpjs_kesehatan'] = str_replace(',', '', $validated['potongan_bpjs_kesehatan']);
            $validated['loss'] = str_replace(',', '', $validated['loss']);
            $validated['total_penjumlahan'] = str_replace(',', '', $validated['total_penjumlahan']);
            $validated['total_pengurangan'] = str_replace(',', '', $validated['total_pengurangan']);
            $validated['grand_total'] = str_replace(',', '', $validated['grand_total']);

            

            // $user = User::find($request['user_id']);
            // $user->update([
            //     'saldo_kasbon' => $user->saldo_kasbon - $validated['bayar_kasbon'],
            //     'bonus_pribadi' => $user->bonus_pribadi - $validated['bonus_pribadi'],
            //     'bonus_team' => $user->bonus_team - $validated['bonus_team'],
            //     'bonus_jackpot' => $user->bonus_jackpot - $validated['bonus_jackpot'],
            // ]);

            // Payroll::create($validated);  
            // return redirect('/rekap-data/get-data?mulai='.$request['tanggal_mulai'].'&akhir='.$request['tanggal_akhir'])->with('success', 'Data Berhasil Disimpan');

            // baru 

            DB::beginTransaction();
            try {
                $user = User::findOrFail($request['user_id']);

                $user->update([
                    'saldo_kasbon' => $user->saldo_kasbon - $validated['bayar_kasbon'],
                    'bonus_pribadi' => $user->bonus_pribadi - $validated['bonus_pribadi'],
                    'bonus_team' => $user->bonus_team - $validated['bonus_team'],
                    'bonus_jackpot' => $user->bonus_jackpot - $validated['bonus_jackpot'],
                ]);

                $payroll = Payroll::create($validated);

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                Alert::error('Failed', 'Gagal menyimpan Payroll. Error: ' . $e->getMessage());
                return redirect('/rekap-data/get-data?mulai='.$request['tanggal_mulai'].'&akhir='.$request['tanggal_akhir'])
                    ->with('failed', 'Payroll gagal disimpan.');
            }

            // jika payroll berhasil, lanjut hitung pajak
            try {
                $user = User::findOrFail($request['user_id']);
                $this->hitungPajak($user);
            } catch (\Exception $e) {
                return redirect('/rekap-data/get-data?mulai='.$request['tanggal_mulai'].'&akhir='.$request['tanggal_akhir'])
                    ->with('success', 'Payroll berhasil disimpan, tetapi hitung pajak gagal: '.$e->getMessage());
            }

            return redirect('/rekap-data/get-data?mulai='.$request['tanggal_mulai'].'&akhir='.$request['tanggal_akhir'])
                ->with('success', 'Payroll dan Pajak berhasil disimpan.');
                }
    }

    public function hitungPajak(User $user)
    {
        // 1. Ambil payroll terbaru user
        $payroll = Payroll::where('user_id', $user->id)
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->latest()
            ->first();

        if (!$payroll) {
            throw new \Exception('Tidak ditemukan data payroll untuk perhitungan pajak.');
        }

        // 2. Hitung bruto
        $bruto = 
            ($payroll->gaji_pokok ?? 0) +
            ($payroll->uang_transport ?? 0) +
            ($payroll->total_lembur ?? 0) +
            ($payroll->total_kehadiran ?? 0) +
            ($payroll->total_thr ?? 0) +
            ($payroll->bonus_pribadi ?? 0) +
            ($payroll->bonus_team ?? 0) +
            ($payroll->bonus_jackpot ?? 0)+
            ($payroll->tunjangan_bpjs_kesehatan ?? 0)+
            ($payroll->tunjangan_bpjs_ketenagakerjaan ?? 0)+
            ($payroll->tunjangan_pajak ?? 0);

        // 3. Hitung pengurangan
        $pengurangan = 
            ($payroll->potongan_bpjs_kesehatan ?? 0) +
            ($payroll->potongan_bpjs_ketenagakerjaan ?? 0) +
            ($payroll->total_terlambat ?? 0) +
            ($payroll->total_mangkir ?? 0);

        $netto_bulan = $bruto - $pengurangan;
        $netto_tahun = $netto_bulan * 12;

        // 4. PTKP
        $statusPtkp = StatusPtkp::where('name', $user->status_pajak)->first();
        $ptkp = $statusPtkp ? $statusPtkp->ptkp_2016 : 0;

        // 5. PKP
        $pkp = max(0, $netto_tahun - $ptkp);
        $pkp = floor($pkp / 1000) * 1000;

        // 6. Hitung PPh21
        $tarifs = TarifPph::where('year', date('Y'))->orderBy('batas_bawah')->get();
        $pph21_setahun = 0;
        $sisa_pkp = $pkp;

        foreach($tarifs as $tarif){
            $batas_atas = $tarif->batas_atas ?? PHP_INT_MAX;
            $kena_pajak = min($sisa_pkp, $batas_atas - $tarif->batas_bawah);
            if($kena_pajak > 0){
                $pph21_setahun += $kena_pajak * ($tarif->tarif / 100);
                $sisa_pkp -= $kena_pajak;
            }
            if($sisa_pkp <= 0) break;
        }

        $pph21_perbulan = $pph21_setahun / 12;

        // 7. Simpan
        $payroll->update([
            'potongan_pajak_pph21' => $pph21_perbulan
        ]);
        Pajak::create([
            'payroll_id' => $payroll->id ?? null,
            'user_id' => $user->id,
            'status_id' => $statusPtkp->id ?? null,
            'bulan' => $payroll->bulan,
            'tahun' => $payroll->tahun,
            'penghasilan_bruto' => $bruto,
            'pengurangan' => $pengurangan,
            'penghasilan_netto_bulan' => $netto_bulan,
            'penghasilan_netto_tahun' => $netto_tahun,
            'ptkp' => $ptkp,
            'pkp' => $pkp,
            'pph21_setahun' => $pph21_setahun,
            'pph21_perbulan' => $pph21_perbulan,
        ]);
    }
    public function detailPdf()
    {
        $pdf = Pdf::loadView('rekapdata.detailPdf', [
            'title' => 'Detail PDF',
            'data' => MappingShift::dataAbsen()->get()
        ]);

        return $pdf->stream();
    }

    public function rekapPdf()
    {
        $pdf = Pdf::loadView('rekapdata.rekapPdf', [
            'title' => 'Rekap PDF',
            'data' => User::orderBy('name', 'ASC')->get()
        ]);

        return $pdf->stream();
    }
}
