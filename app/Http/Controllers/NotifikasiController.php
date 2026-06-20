<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends BaseController
{
    public function index()
    {
        $response = Http::get("{$this->backendUrl}/api/konfirmasi-ruangan/list/" . Auth::id());
        $notifikasis = $response->json() ?? [];

        return view('user.notifikasi.index', [
            'title' => 'Kumpulan Notifikasi',
            'notifikasis' => $notifikasis
        ]);
    }

    public function jawab(Request $request)
    {
        $response = Http::post("{$this->backendUrl}/api/konfirmasi-ruangan/submit", [
            'jadwal_ruangan_id' => $request->jadwal_ruangan_id,
            'tanggal' => $request->tanggal,
            'status' => $request->status,
        ]);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Berhasil menyimpan konfirmasi ruangan.');
        }

        return redirect()->back()->with('error', 'Gagal menyimpan konfirmasi.');
    }

    public function adminIndex()
    {
        $response = Http::get("{$this->backendUrl}/api/konfirmasi-ruangan/all");
        $notifikasis = $response->json() ?? [];

        return view('admin.notifikasi.index', [
            'title' => 'Riwayat Konfirmasi Ruangan',
            'notifikasis' => $notifikasis
        ]);
    }
}
