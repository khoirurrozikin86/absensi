<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Bukti Pemotongan Pajak PPH 21</title>
  <style>
    body { font-family: Arial, sans-serif; font-size: 13px; }
    .container { max-width: 800px; margin: auto; }
    .header { text-align: center; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    td { padding: 6px; }
    .bold { font-weight: bold; }
    .line { border-top: 1px solid #000; margin: 20px 0; }
    .section-title { font-style: italic; text-decoration: underline; font-size: 14px; margin-top: 20px; }
  </style>
</head>
<body>
  @php
    use Carbon\Carbon;
    $settings = App\Models\settings::first();
    $logo_path = storage_path('app/public/' . $settings->logo);
    if (file_exists($logo_path)) {
        $logo_mime = mime_content_type($logo_path);
        $logo_data = base64_encode(file_get_contents($logo_path));
    } else {
        $logo_mime = null;
        $logo_data = null;
    }

    $bulanNama = \Carbon\Carbon::createFromDate(null, $data->bulan, 1)->translatedFormat('F');
  @endphp

  <div class="container">
    @if($logo_data)
      <img src="data:{{ $logo_mime }};base64,{{ $logo_data }}" style="width: 80px; float:right">
    @endif

    <h3>{{ $settings->name }}</h3>
    <small>{{ $settings->alamat }} | {{ $settings->email }} - {{ $settings->phone }}</small>
    <hr>

    <div class="header">
      <h4>Bukti Pemotongan Pajak (PPH 21)</h4>
      <p>Periode: {{ $bulanNama }} {{ $data->tahun }}</p>
    </div>

    <table>
      <tr>
        <td width="30%">Nama Pegawai</td>
        <td>: {{ $data->User->name }}</td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>: {{ $data->User->jabatan->nama_jabatan ?? '-' }}</td>
      </tr>
      <tr>
        <td>Status PTKP</td>
        <td>: {{ $data->status_ptkp->name }}</td>
      </tr>
    </table>

    <div class="section-title">RINCIAN PEMOTONGAN PAJAK</div>

    <table style="width: 100%;">
      <thead style="font-size: 16px;">
        <tr>
          <th style="text-align: left;">Komponen</th>
          <th style="text-align: right;">Jumlah (Rp)</th>
          <th style="text-align: center;">Keterangan</th>
        </tr>
      </thead>
      <tbody>
        {{-- Penghasilan Kena Pajak --}}
        <tr><td colspan="3"><strong>(Penghasilan Kena Pajak)</strong></td></tr>
        <tr><td>Gaji Pokok</td><td style="text-align: right;">{{ number_format($salary->gaji_pokok) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>Uang Transport</td><td style="text-align: right;">{{ number_format($salary->uang_transport) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>Lembur</td><td style="text-align: right;">{{ number_format($salary->total_lembur) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>Bonus Kehadiran</td><td style="text-align: right;">{{ number_format($salary->total_kehadiran) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>THR</td><td style="text-align: right;">{{ number_format($salary->total_thr) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>Bonus Pribadi</td><td style="text-align: right;">{{ number_format($salary->bonus_pribadi) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>Bonus Team</td><td style="text-align: right;">{{ number_format($salary->bonus_team) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>Bonus Jackpot</td><td style="text-align: right;">{{ number_format($salary->bonus_jackpot) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>Tunjangan BPJS Kesehatan</td><td style="text-align: right;">{{ number_format($salary->tunjangan_bpjs_kesehatan) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>Tunjangan BPJS Ketenagakerjaan</td><td style="text-align: right;">{{ number_format($salary->tunjangan_bpjs_ketenagakerjaan) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>Tunjangan Pajak</td><td style="text-align: right;">{{ number_format($salary->tunjangan_pajak) }}</td><td style="text-align: center;">YA</td></tr>

        {{-- Penghasilan Tidak Kena Pajak --}}
        <tr><td colspan="3"><strong>(Penghasilan Tidak Kena Pajak)</strong></td></tr>
        <tr><td>Reimbursement</td><td style="text-align: right;">{{ number_format($salary->total_reimbursement) }}</td><td style="text-align: center;">TIDAK</td></tr>

        {{-- Pengurangan Pajak --}}
        <tr><td colspan="3"><strong>(Pengurangan Pajak)</strong></td></tr>
        <tr><td>Potongan BPJS Kesehatan</td><td style="text-align: right;">{{ number_format($salary->potongan_bpjs_kesehatan) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>Potongan BPJS Ketenagakerjaan</td><td style="text-align: right;">{{ number_format($salary->potongan_bpjs_ketenagakerjaan) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>Potongan Terlambat</td><td style="text-align: right;">{{ number_format($salary->total_terlambat) }}</td><td style="text-align: center;">YA</td></tr>
        <tr><td>Potongan Mangkir</td><td style="text-align: right;">{{ number_format($salary->total_mangkir) }}</td><td style="text-align: center;">YA</td></tr>

        {{-- Ringkasan --}}
        <tr><td colspan="3"><hr></td></tr>
        <tr>
          <td><strong>Total Bruto (Kena Pajak)</strong></td>
          <td style="text-align: right;"><strong>Rp {{ number_format($data->penghasilan_bruto) }}</strong></td>
          <td></td>
        </tr>
        <tr>
          <td><strong>Total Pengurangan</strong></td>
          <td style="text-align: right;"><strong>Rp {{ number_format($data->pengurangan) }}</strong></td>
          <td></td>
        </tr>
        <tr>
          <td><strong>Penghasilan Netto Sebulan</strong></td>
          <td style="text-align: right;"><strong>Rp {{ number_format($data->penghasilan_netto_bulan) }}</strong></td>
          <td></td>
        </tr>
        <tr>
          <td><strong>Penghasilan Netto Setahun</strong></td>
          <td style="text-align: right;"><strong>Rp {{ number_format($data->penghasilan_netto_tahun) }}</strong></td>
          <td></td>
        </tr>
        <tr>
          <td><strong>PTKP</strong></td>
          <td style="text-align: right;"><strong>Rp {{ number_format($data->ptkp) }}</strong></td>
          <td></td>
        </tr>
        <tr>
          <td><strong>PKP</strong></td>
          <td style="text-align: right;"><strong>Rp {{ number_format($data->pkp) }}</strong></td>
          <td></td>
        </tr>
        <tr>
          <td><strong>PPH 21 Setahun</strong></td>
          <td style="text-align: right;"><strong>Rp {{ number_format($data->pph21_setahun) }}</strong></td>
          <td></td>
        </tr>
        <tr>
          <td><strong>PPH 21 Sebulan</strong></td>
          <td style="text-align: right;"><strong>Rp {{ number_format($data->pph21_perbulan) }}</strong></td>
          <td></td>
        </tr>
      </tbody>
    </table>


    <div class="line"></div>
    <p style="font-size: 12px; text-align:right">Dicetak pada: {{ now()->translatedFormat('d F Y, H:i') }}</p>
  </div>
</body>
</html>
