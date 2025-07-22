<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EditorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create editor user
        User::create([
            'name' => 'Editor User',
            'email' => 'editor@innato.com',
            'password' => Hash::make('editor123'),
            'is_admin' => false,
            'role' => 'editor'
        ]);

        // Create another editor for testing
        User::create([
            'name' => 'Content Editor',
            'email' => 'content@innato.com',
            'password' => Hash::make('content123'),
            'is_admin' => false,
            'role' => 'editor'
        ]);
    }
}
