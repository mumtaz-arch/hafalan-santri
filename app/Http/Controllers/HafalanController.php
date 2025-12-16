<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hafalan;
use App\Http\Controllers\SeoController;

class HafalanController extends Controller
{
    public function index()
    {
        $hafalans = Hafalan::orderBy('nomor_surah')->paginate(20);
        $seoData = SeoController::getHafalanListSeoData();
        return view('hafalan.index', compact('hafalans', 'seoData'));
    }

    public function create()
    {
        return view('hafalan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_surah' => 'required|string|max:255',
            'nomor_surah' => 'required|integer|min:1|max:114|unique:hafalans,nomor_surah',
            'jumlah_ayat' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ], [
            'nama_surah.required' => 'Nama surah wajib diisi',
            'nomor_surah.required' => 'Nomor surah wajib diisi',
            'nomor_surah.unique' => 'Nomor surah sudah ada',
            'nomor_surah.min' => 'Nomor surah minimal 1',
            'nomor_surah.max' => 'Nomor surah maksimal 114',
            'jumlah_ayat.required' => 'Jumlah ayat wajib diisi',
            'jumlah_ayat.min' => 'Jumlah ayat minimal 1',
        ]);

        Hafalan::create($request->all());

        return redirect()->route('hafalan.index')->with('success', 'Hafalan berhasil ditambahkan!');
    }

    public function show(Hafalan $hafalan)
    {
        // Use eager loading to prevent N+1 queries when accessing related submissions and users
        $submissions = $hafalan->voiceSubmissions()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        $seoData = SeoController::getHafalanDetailSeoData($hafalan);

        return view('hafalan.show', compact('hafalan', 'submissions', 'seoData'));
    }

    public function edit(Hafalan $hafalan)
    {
        return view('hafalan.edit', compact('hafalan'));
    }

    public function update(Request $request, Hafalan $hafalan)
    {
        $request->validate([
            'nama_surah' => 'required|string|max:255',
            'nomor_surah' => 'required|integer|min:1|max:114|unique:hafalans,nomor_surah,' . $hafalan->id,
            'jumlah_ayat' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ], [
            'nama_surah.required' => 'Nama surah wajib diisi',
            'nomor_surah.required' => 'Nomor surah wajib diisi',
            'nomor_surah.unique' => 'Nomor surah sudah ada',
            'nomor_surah.min' => 'Nomor surah minimal 1',
            'nomor_surah.max' => 'Nomor surah maksimal 114',
            'jumlah_ayat.required' => 'Jumlah ayat wajib diisi',
            'jumlah_ayat.min' => 'Jumlah ayat minimal 1',
        ]);

        $hafalan->update($request->all());

        return redirect()->route('hafalan.index')->with('success', 'Hafalan berhasil diperbarui!');
    }

    public function destroy(Hafalan $hafalan)
    {
        // Check if there are any submissions for this hafalan
        if ($hafalan->voiceSubmissions()->count() > 0) {
            return redirect()->route('hafalan.index')->with('error', 'Tidak dapat menghapus hafalan yang sudah memiliki submission!');
        }

        $hafalan->delete();

        return redirect()->route('hafalan.index')->with('success', 'Hafalan berhasil dihapus!');
    }
}