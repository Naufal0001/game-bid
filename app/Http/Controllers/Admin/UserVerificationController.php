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
        $query = User::query()
        ->where('status', 'pending');

        $request = request();

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('username', 'like', "%{$request->search}%")
                ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        // ↕️ SORT
        $sort = $request->get('sort', 'username');
        $direction = $request->get('direction', 'asc');

        $allowedSorts = ['username', 'email', 'created_at'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'username';
        }

        $users = $query
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('admin.user-verification.index', compact(
            'users',
            'sort',
            'direction'
        ));
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
