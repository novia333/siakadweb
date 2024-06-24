<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Absensi;

class AbsensiController extends Controller
{
    public function store(Request $request)
    {
        $this->validate($request, [
            'tanggal' => 'required|date',
            // validasi lainnya
        ]);

        $absensi = new Absensi;
        $absensi->guru_id = $request->guru_id; // Menggunakan guru_id dari middleware
        $absensi->tanggal = $request->tanggal;
        // isi field lainnya
        $absensi->save();

        return redirect()->back()->with('success', 'Absensi berhasil disimpan!');
    }
    
}

