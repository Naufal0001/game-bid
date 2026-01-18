<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserVerificationController extends Controller
{
    /**
     * List user yang mengajukan verifikasi
     */
    public function index()
    {
        $users = User::where('status', 'pending_verification')->get();

        return view('admin.user-verification.index', compact('users'));
    }

    /**
     * Approve user menjadi seller
     */
    public function approve(User $user)
    {
        // Update status
        $user->update([
            'status' => 'verified',
        ]);

        // Berikan permission seller
        $user->givePermissionTo([
            'create item',
            'create auction',
            'edit own auction',
            'delete own auction',
        ]);

        return back()->with('success', 'User berhasil diverifikasi sebagai seller.');
    }

    /**
     * Reject pengajuan verifikasi
     */
    public function reject(User $user)
    {
        $user->update([
            'status' => 'rejected',
        ]);

        // Pastikan permission seller dicabut
        $user->revokePermissionTo([
            'create item',
            'create auction',
            'edit own auction',
            'delete own auction',
        ]);

        return back()->with('success', 'Pengajuan verifikasi ditolak.');
    }
}
