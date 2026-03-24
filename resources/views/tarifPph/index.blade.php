@extends('templates.dashboard')
@section('isi')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Data Tarif PPH</h5>
            <a href="{{ route('tarif-pph.create') }}" class="btn btn-primary">+ Tambah Tarif PPH</a>
        </div>
        
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ url('/tarif-pph') }}" class="d-flex mb-3">
                <input type="text" class="form-control me-2" name="search" value="{{ request('search') }}" placeholder="Cari...">
                <button type="submit" class="btn btn-secondary" style="border-radius: 10px">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Batas Bawah</th>
                        <th>Batas Atas</th>
                        <th>Tarif (%)</th>
                        <th>Tahun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($tarif_pph as $d)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>Rp {{ number_format($d->batas_bawah) }}</td>
                            <td>
                                @if($d->batas_atas)
                                    Rp {{ number_format($d->batas_atas) }}
                                @else
                                    <span class="badge bg-success">Tak Terbatas</span>
                                @endif
                            </td>
                            <td>{{ $d->tarif }}%</td>
                            <td>{{ $d->year }}</td>
                            <td>
                                <a href="{{ route('tarif-pph.edit', $d->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-solid fa-edit"></i>
                                </a>
                                <form action="{{ route('tarif-pph.destroy', $d->id) }}" method="post" class="d-inline">
                                    @csrf @method('delete')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                        <i class="fa fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<br>
@endsection
