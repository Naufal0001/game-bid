<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $query = User::query();
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

        $allowedSorts = ['username', 'email', 'status', 'created_at'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'username';
        }

        $query->orderBy($sort, $direction);

        // 📄 PAGINATION
        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users', 'sort', 'direction'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:active,suspended'
        ]);

        // Jangan suspend admin
        if ($user->hasRole('admin')) {
            return back()->with('error', 'Admin tidak dapat disuspend.');
        }

        $user->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status user berhasil diperbarui.');
    }
}
