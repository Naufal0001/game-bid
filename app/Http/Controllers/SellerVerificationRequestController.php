<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerVerificationRequestController extends Controller
{
    /**
     * Tampilkan halaman pengajuan verifikasi
     */
    public function create()
    {
        $user = Auth::user();

        // Cegah ajukan ulang
        if ($user->status === 'pending_verification') {
            return redirect()
                ->route('home')
                ->with('info', 'Pengajuan verifikasi Anda sedang diproses.');
        }

        if ($user->status === 'verified') {
            return redirect()
                ->route('home')
                ->with('info', 'Akun Anda sudah terverifikasi.');
        }

        return view('verification.request');
    }

    /**
     * Simpan pengajuan verifikasi
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->status !== 'active' && $user->status !== 'rejected') {
            return redirect()->route('home');
        }

        $user->update([
            'status' => 'pending_verification',
        ]);

        return redirect()
            ->route('home')
            ->with('success', 'Pengajuan verifikasi berhasil dikirim. Tunggu persetujuan admin.');
    }
}
