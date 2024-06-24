<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    // Menampilkan daftar submission untuk siswa
    public function index()
    {
        $submissions = auth()->user()->submissions()->latest()->paginate(10);
        return view('siswa.tugas', compact('submissions'));
    }

    // Menampilkan detail submission tertentu
    public function show(Submission $submission)
    {
        return view('submissions.show', compact('submission'));
    }

    // Menampilkan formulir untuk mengumpulkan submission
    public function create(Submission $submission)
    {
        return view('submissions.create', compact('submission'));
    }

    // Menyimpan submission yang diunggah oleh siswa
    public function store(Request $request, Submission $submission)
    {
        // Validasi request jika diperlukan

        // Simpan submission
        $submission->fill($request->all());
        $submission->save();

        // Redirect ke halaman submission setelah berhasil mengumpulkan
        return redirect()->route('submissions.show', $submission)->with('success', 'Submission berhasil diunggah');
    }
}
