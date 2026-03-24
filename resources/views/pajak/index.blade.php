@extends('templates.dashboard')
@section('isi')
<div class="row">
    <div class="col-md-12 project-list">
        <div class="card">
            <div class="row">
                <div class="col-md-6 mt-2 p-0 d-flex">
                    <h4>{{ $title }}</h4>
                </div>
                <div class="col-md-6 p-0">
                    <a href="{{ url('/data-pajak/export') }}{{ $_GET ? '?' . $_SERVER['QUERY_STRING'] : '' }}" class="btn btn-sm btn-success me-2">
                        <i class="fa fa-file-excel me-2"></i> Export
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header pb-0">
                <form action="{{ url('/pajak-pph21') }}">
                    <div class="row mb-2">
                        <div class="col-5">
                            <input type="number" placeholder="Tahun..." class="form-control" value="{{ request('tahun') }}" name="tahun">
                        </div>
                        <div class="col-5">
                            <select name="bulan" class="form-control">
                                <option value="">Pilih Bulan</option>
                                @php
                                    $bulanList = [
                                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                    ];
                                @endphp
                                @foreach($bulanList as $key => $val)
                                    <option value="{{ $key }}" {{ request('bulan') == $key ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-2">
                            <button type="submit" class="border-0 mt-3" style="background-color: transparent;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="table-responsive" style="border-radius: 10px">
                    <table class="table table-bordered" style="vertical-align: middle">
                        <thead>
                            <tr>
                                <th class="text-center sticky-left">No.</th>
                                <th class="sticky-left" style="min-width: 230px;">Nama</th>
                                <th class="text-center">Bulan</th>
                                <th class="text-center">Tahun</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Bruto</th>
                                <th class="text-center">Netto / Bln</th>
                                <th class="text-center">Netto / Thn</th>
                                <th class="text-center">PTKP</th>
                                <th class="text-center">PKP</th>
                                <th class="text-center">PPH Setahun</th>
                                <th class="text-center">PPH Sebulan</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $key => $pajak)
                                <tr>
                                    <td class="text-center sticky-left">
                                        {{ ($data->currentpage()-1) * $data->perpage() + $key + 1 }}.
                                    </td>
                                    <td class="sticky-left">{{ $pajak->user->name ?? '-' }}</td>
                                    <td class="text-center">{{ $bulanList[$pajak->bulan] ?? '-' }}</td>
                                    <td class="text-center">{{ $pajak->tahun }}</td>
                                    <td class="text-center">{{ $pajak->status_ptkp->name ?? '-' }}</td>
                                    <td class="text-end">{{ number_format($pajak->penghasilan_bruto) }}</td>
                                    <td class="text-end">{{ number_format($pajak->penghasilan_netto_bulan) }}</td>
                                    <td class="text-end">{{ number_format($pajak->penghasilan_netto_tahun) }}</td>
                                    <td class="text-end">{{ number_format($pajak->ptkp) }}</td>
                                    <td class="text-end">{{ number_format($pajak->pkp) }}</td>
                                    <td class="text-end">{{ number_format($pajak->pph21_setahun) }}</td>
                                    <td class="text-end">{{ number_format($pajak->pph21_perbulan) }}</td>
                                    <td>
                                            <ul class="action">
                                                <li class="me-2">
                                                    <a href="{{ url('/data-pajak/'.$pajak->id.'/'.$pajak->payroll_id.'/download') }}" target="_blank"><i style="color:blue" class="fa fa-solid fa-print"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">Tidak Ada Data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end me-4 mt-4">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
