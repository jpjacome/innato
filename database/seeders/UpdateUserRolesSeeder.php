<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateUserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update all existing admin users
        User::where('is_admin', true)
            ->update(['role' => 'admin']);
            
        // Update all non-admin users
        User::where('is_admin', false)
            ->where(function($query) {
                $query->whereNull('role')
                    ->orWhere('role', '')
                    ->orWhere('role', '!=', 'editor');
            })
            ->update(['role' => 'regular']);
            
        // Ensure at least one admin exists
        if (User::where('role', 'admin')->count() === 0) {
            $admin = User::first();
            if ($admin) {
                $admin->update([
                    'role' => 'admin',
                    'is_admin' => true
                ]);
            } else {
                // Create admin if no users exist
                User::create([
                    'name' => 'Admin',
                    'email' => 'admin@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'admin',
                    'is_admin' => true
                ]);
            }
        }
        
        $this->command->info('User roles have been updated.');
    }
}
