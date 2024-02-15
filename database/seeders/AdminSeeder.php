<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => env('MASTER_ACCOUNT_NAME', 'Willy Reyner Carneiro'),
            'email' => env('MASTER_ACCOUNT_EMAIL', 'willy_reyner@hotmail.com'),
            'cpf' => env('MASTER_ACCOUNT_CPF', '01935442104'),
            'email_verified_at' => now(),
            'password' => Hash::make(env('MASTER_ACCOUNT_PASSWORD', 'willy123')),
        ])->assignRole('admin');
        User::create([
            'name' => env('SECRETARY_ACCOUNT_NAME', 'Secretaria'),
            'email' => env('SECRETARY_ACCOUNT_EMAIL', 'willy1_reyner@hotmail.com'),
            'cpf' => env('SECRETARY_ACCOUNT_CPF', '01935442105'),
            'email_verified_at' => now(),
            'password' => Hash::make(env('SECRETARY_ACCOUNT_PASSWORD', 'willy123')),
        ])->assignRole('secretaria');
        User::create([
            'name' => env('USER_ACCOUNT_NAME', 'Usuario'),
            'email' => env('USER_ACCOUNT_EMAIL', 'willy2_reyner@hotmail.com'),
            'cpf' => env('USER_ACCOUNT_CPF', '01935442106'),
            'email_verified_at' => now(),
            'password' => Hash::make(env('USER_ACCOUNT_PASSWORD', 'willy123')),
        ])->assignRole('usuario');
    }
}
