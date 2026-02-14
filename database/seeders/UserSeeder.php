<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('slug', 'admin')->first();
        $biblioRole = Role::where('slug', 'bibliothecaire')->first();
        $etudiantRole = Role::where('slug', 'etudiant')->first();

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@larabook.com'],
            [
                'name' => 'Admin Larabook',
                'matricule' => 'ADM202401',
                'password' => Hash::make('password'),
            ]
        );
        $admin->roles()->syncWithoutDetaching([$adminRole->id]);

        // Bibliothécaire
        $biblio = User::firstOrCreate(
            ['email' => 'biblio@larabook.com'],
            [
                'name' => 'Marie Dupont',
                'matricule' => 'BIB202401',
                'password' => Hash::make('password'),
            ]
        );
        $biblio->roles()->syncWithoutDetaching([$biblioRole->id]);

        // Étudiants
        $etudiants = [
            [
                'name' => 'Jean Martin',
                'matricule' => 'ETU202401',
                'email' => 'jean.martin@larabook.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Sophie Bernard',
                'matricule' => 'ETU202402',
                'email' => 'sophie.bernard@larabook.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Lucas Petit',
                'matricule' => 'ETU202403',
                'email' => 'lucas.petit@larabook.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($etudiants as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                $data
            );
            $user->roles()->syncWithoutDetaching([$etudiantRole->id]);
        }
    }
}
