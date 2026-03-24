@extends('templates.dashboard')
@section('isi')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Edit Tarif PPH</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('tarif-pph.update', $tarif_pph->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="batas_bawah">Batas Bawah</label>
                    <input type="number" name="batas_bawah" id="batas_bawah" class="form-control @error('batas_bawah') is-invalid @enderror" 
                        value="{{ old('batas_bawah', $tarif_pph->batas_bawah) }}" required>
                    @error('batas_bawah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="batas_atas">Batas Atas (boleh kosong)</label>
                    <input type="number" name="batas_atas" id="batas_atas" class="form-control @error('batas_atas') is-invalid @enderror" 
                        value="{{ old('batas_atas', $tarif_pph->batas_atas) }}">
                    @error('batas_atas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tarif">Tarif (%)</label>
                    <input type="number" step="0.01" name="tarif" id="tarif" class="form-control @error('tarif') is-invalid @enderror" 
                        value="{{ old('tarif', $tarif_pph->tarif) }}" required>
                    @error('tarif')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="year">Tahun</label>
                    <input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror" 
                        value="{{ old('year', $tarif_pph->year) }}" required>
                    @error('year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button class="btn btn-primary">Update</button>
                <a href="{{ redirect('tarif-pph') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection
