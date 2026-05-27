<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bukus = Buku::with('kategori')
                    ->orderBy('id', 'asc')
                    ->paginate(10);

        return view('buku.index', compact('bukus'))->with('bukus', $bukus);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Kategori::all();

        return view('buku.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer|min:1800|max:2100',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        // Generate kode buku (urutkan berdasarkan nomor maksimal dari kode_buku)
        // Pakai transaction untuk mengurangi kemungkinan race condition.
        $kode = DB::transaction(function () use ($validated) {

            $maxNumber = Buku::selectRaw("MAX(CAST(SUBSTRING(kode_buku, 3) AS UNSIGNED)) AS max_num")
                ->value('max_num');

            $nextNumber = ($maxNumber ?? 0) + 1;

            return 'BK' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
        });

        $validated['kode_buku'] = $kode;

        Buku::create($validated);

        return redirect()->route('bukus.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Buku $buku)
    {
        $categories = Kategori::all();

        return view('buku.edit', compact('buku', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Buku $buku)
    {
        $validated = $request->validate([
            'kode_buku' => 'required',
            'judul' => 'required',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|integer|min:1800|max:2100',
            'stok' => 'required|integer|min:0',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);

        $buku->update($validated);

        return redirect()->route('bukus.index')
            ->with('success', 'Buku berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Buku $buku)
    {
        $buku->delete();

        return redirect('/bukus')
            ->with('success', 'Buku berhasil dihapus');
    }
}