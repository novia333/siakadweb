<?php
 
namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Guru;
use App\Jadwal;
use App\Absen;
use App\Kehadiran;
use App\Assignment;
use App\Mapel;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{

    public function indexSiswa()
{
    $assignments = Assignment::all(); // Ambil semua tugas
    return view('siswa.tugas', compact('assignments'));
}

    // Menampilkan semua assignment
    public function index()
    {
        $assignments = Assignment::with('mapel')->get();
        return view('guru.tugas', compact('assignments'));
    }

    // Menampilkan form untuk membuat assignment baru
    public function create()
    {
        $mapels = Mapel::all();
        return view('guru.uploadtugas', compact('mapels'));
    }

    // Menyimpan assignment baru

    public function store(Request $request)
{
    // Mendapatkan informasi guru yang sedang login
    $guru = Auth::user();

    // Validasi input form
    $request->validate([
        'title' => 'required',
        'description' => 'required',
        'deadline' => 'required|date',
        'id_mapel' => 'required|exists:mapel,id', // Validasi bahwa ID mapel yang dipilih ada dalam tabel mapels
        'file' => 'required|file|max:10240', // Menambahkan validasi untuk file dengan maksimal 10MB
        // tambahkan validasi lainnya sesuai kebutuhan
    ]);

    // Simpan file yang diunggah ke direktori penyimpanan
    $file = $request->file('file');
    $filePath = $file->store('uploads'); // Simpan file di direktori 'storage/app/uploads'

    // Menyimpan tugas dengan menggunakan guru_id yang sedang login dan path file yang diunggah
    $assignment = new Assignment([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'deadline' => $request->input('deadline'),
        'guru_id' => $guru->id,
        'id_mapel' => $request->input('id_mapel'), // Menambahkan ID mapel yang dipilih dari form
        'file_path' => $filePath, // Menyimpan path file di dalam basis data
    ]);
    $assignment->save();

    // Redirect atau lakukan tindakan lainnya setelah penyimpanan
    return redirect()->route('assignments.index');
}




    // Tambahkan fungsi update() dan destroy() jika diperlukan
    public function destroy($id)
{
    $assignment = Assignment::findOrFail($id);
    $assignment->delete();
    return redirect()->route('assignments.index')->with('success', 'Tugas berhasil dihapus');
}

    public function show(Assignment $assignment)
    {
        return view('guru.detail_tugas', compact('assignment'));
    }

    public function show2(Assignment $assignment)
{
    return view('siswa.detailtugas', compact('assignment'));
}


}
