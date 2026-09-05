<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = DB::table('berita')
            ->orderByDesc('tanggal_publish')
            ->orderByDesc('id')
            ->paginate(10);

        return view('admin.berita.index', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'required|image|max:10240', // Maksimal 10MB
            'konten' => 'required|string',
            'tanggal_publish' => 'required|date',
        ], [
            'judul.required' => 'Judul berita wajib diisi.',
            'gambar.required' => 'Foto berita wajib di-upload.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 10MB.',
            'konten.required' => 'Isi berita/caption wajib diisi.',
            'tanggal_publish.required' => 'Tanggal publish wajib diisi.',
        ]);

        $imageName = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Buat direktori jika belum ada
            $destinationPath = public_path('uploads/berita');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            
            $file->move($destinationPath, $imageName);
        }

        DB::table('berita')->insert([
            'judul' => $request->judul,
            'gambar' => 'uploads/berita/' . $imageName,
            'konten' => $request->konten,
            'tanggal_publish' => $request->tanggal_publish,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $berita = DB::table('berita')->find($id);

        if (!$berita) {
            return redirect()->route('admin.berita.index')->with('error', 'Berita tidak ditemukan.');
        }

        return view('admin.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $berita = DB::table('berita')->find($id);

        if (!$berita) {
            return redirect()->route('admin.berita.index')->with('error', 'Berita tidak ditemukan.');
        }

        $request->validate([
            'judul' => 'required|string|max:255',
            'gambar' => 'nullable|image|max:10240', // Maksimal 10MB
            'konten' => 'required|string',
            'tanggal_publish' => 'required|date',
        ], [
            'judul.required' => 'Judul berita wajib diisi.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 10MB.',
            'konten.required' => 'Isi berita/caption wajib diisi.',
            'tanggal_publish.required' => 'Tanggal publish wajib diisi.',
        ]);

        $updateData = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            'tanggal_publish' => $request->tanggal_publish,
            'updated_at' => now(),
        ];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $imageName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            $destinationPath = public_path('uploads/berita');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            
            $file->move($destinationPath, $imageName);

            // Hapus gambar lama jika ada
            if ($berita->gambar && File::exists(public_path($berita->gambar))) {
                File::delete(public_path($berita->gambar));
            }

            $updateData['gambar'] = 'uploads/berita/' . $imageName;
        }

        DB::table('berita')->where('id', $id)->update($updateData);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $berita = DB::table('berita')->find($id);

        if (!$berita) {
            return redirect()->route('admin.berita.index')->with('error', 'Berita tidak ditemukan.');
        }

        // Hapus gambar dari server
        if ($berita->gambar && File::exists(public_path($berita->gambar))) {
            File::delete(public_path($berita->gambar));
        }

        DB::table('berita')->where('id', $id)->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus.');
    }
}
