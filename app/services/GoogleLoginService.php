<?php

namespace App\Services;

use App\Models\User;
use Laravel\Socialite\Two\User as SocialiteUser;

class GoogleLoginService
{
    public function handle(SocialiteUser $googleUser)
    {
        // 1. Cek apakah user sudah ada (berdasarkan email atau google_id)
        $user = User::where('email', $googleUser->email)
                    ->orWhere('google_id', $googleUser->id)
                    ->first();

        // 2. Jika user sudah ada, update google_id-nya biar terhubung
        if ($user) {
            $user->update([
                'google_id' => $googleUser->id,
            ]);
            return $user;
        }

        // 3. Jika belum ada, buat user baru
        return User::create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'google_id' => $googleUser->id,
            'password' => null, // Password kosong
            'email_verified_at' => now(), // Anggap email langsung verified
        ]);
    }
}