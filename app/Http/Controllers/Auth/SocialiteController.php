<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Import Model User di sini
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        // Menggunakan stateless() agar tidak error di localhost
        $gUser = Socialite::driver('google')->stateless()->user();

        // Ambil username dari email (contoh: 'budi@gmail.com' jadi 'budi')
        $generatedUsername = explode('@', $gUser->getEmail())[0];

        $user = User::updateOrCreate(
            [
                'email' => $gUser->getEmail(), // Cek apakah email sudah ada
            ], 
            [
                'name'      => $gUser->getName(),
                'username'  => $generatedUsername, // SOLUSI ERROR: Isi username otomatis
                'google_id' => $gUser->getId(),
                'password'  => bcrypt('12345678'), // SOLUSI ERROR: Isi password dummy (karena database mewajibkan ada password)
            ]
        );

        Auth::login($user);

        return redirect('/home');
    }
}