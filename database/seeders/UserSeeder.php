<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun ADMIN (Sudah ada)
        $admin = User::create([
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('password'),
            'status' => 'active',
        ]);
        $admin->assignRole('admin');

        // ==========================================
        // 2. [BARU] Buat Akun USER Custom
        // ==========================================
        $customUser = User::create([
            'username' => 'zenxlay',        // Ganti dengan username yang Anda mau
            'email'    => 'zenxlay@mail.com', // Email untuk login nanti
            'password' => Hash::make('password'), // Password login
            'status'   => 'active',
        ]);
        // Berikan role 'user'
        $customUser->assignRole('user'); 


        // 3. Buat 5 User Random (Dummy tambahan)
        User::factory(5)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}