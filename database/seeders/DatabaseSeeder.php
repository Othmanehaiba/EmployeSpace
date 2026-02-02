<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $recruteur = User::factory()->create([
            'name' => 'othmane',
            'email'=> 'yons@gmail.com',
            'photo'=> 'lkjvbsvbkfbvhqbdk',
            'bio' => 'bzkhfqbhkjhfb',
            'speciallity'=> 'ergjkfvhdbns'
            
        ]);

        $recruteur->assignRole('recruteur');

        $chercheur = User::factory()->create([
            'name' => 'yons',
            'email'=> 'abid@gmail.com',
            'photo'=> 'lkjvbsvbkfbvhqbdk',
            'bio' => 'bzkhfqbhkjhfb',
            'speciallity'=> 'ergjkfvhdbns'
            
        ]);

        $chercheur->assignRole('chercheur'); 


        User::factory(10)->create()->each(function ($user){
            $user->assignRole('chercheur');
        });
    }
}
