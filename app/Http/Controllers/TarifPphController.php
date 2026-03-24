<?php

namespace App\Http\Controllers;

use App\Models\TarifPph;
use Illuminate\Http\Request;

class TarifPphController extends Controller
{
    
    public function index()
    {
        $tarif_pph = TarifPph::orderBy('batas_bawah')->get();
        return view('tarifPph.index', [
            'tarif_pph' => $tarif_pph,
            'title' => 'Tarif PPH'
        ]);
    }

    public function create()
    {
        return view('tarifPph.create',['title' => 'Tambah Tarif PPH'] );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'batas_bawah' => 'required|numeric',
            'batas_atas' => 'nullable|numeric',
            'tarif' => 'required|numeric',
            'year' => 'required|numeric',
        ]);
        TarifPph::create($validated);
        return redirect('/tarif-pph')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function edit(TarifPph $tarif_pph)
    {
        return view('tarifPph.edit',[
            'tarif_pph' => $tarif_pph,
            'title' => 'Edit Tarif PPH'
        ]);
    }

    public function update(Request $request, TarifPph $tarif_pph)
    {
        $validated = $request->validate([
            'batas_bawah' => 'required|numeric',
            'batas_atas' => 'nullable|numeric',
            'tarif' => 'required|numeric',
            'year' => 'required|numeric',
        ]);
        $tarif_pph->update($validated);
        return redirect('/tarif-pph')->with('success', 'Tarif PPH berhasil diupdate');
    }

    public function destroy(TarifPph $tarif_pph)
    {
        $tarif_pph->delete();
        return redirect('/tarif-pph')->with('success', 'Tarif PPH berhasil dihapus');
    }

}
