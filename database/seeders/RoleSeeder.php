<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['nom' => 'Administrateur', 'slug' => 'admin'],
            ['nom' => 'Bibliothécaire', 'slug' => 'bibliothecaire'],
            ['nom' => 'Étudiant', 'slug' => 'etudiant'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['slug' => $role['slug']], $role);
        }
    }
}
