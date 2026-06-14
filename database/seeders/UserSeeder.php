<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'      => 'Admin',
            'email'     => 'admin@bookstore.com',
            'password'  => Hash::make('admin123'),
            'role'      => 'admin',
            'is_active' => true,
        ]);

        User::create([
            'name'      => 'John User',
            'email'     => 'user@bookstore.com',
            'password'  => Hash::make('user123'),
            'role'      => 'user',
            'is_active' => true,
        ]);

        User::factory(10)->create(['role' => 'user']);
    }
}
