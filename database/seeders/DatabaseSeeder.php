<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1) Créer les rôles d’abord
        $this->call(RoleSeeder::class);

        // 2) Deux comptes de test
        $recruteur = User::factory()->create([
            'name' => 'othmane',
            'email'=> 'yons@gmail.com',
        ]);
        $recruteur->assignRole('recruteur');

        $chercheur = User::factory()->create([
            'name' => 'yons',
            'email'=> 'abid@gmail.com',
        ]);
        $chercheur->assignRole('chercheur');

        // 3) Utilisateurs fake (chercheur)
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('chercheur');
        });
    }
}
