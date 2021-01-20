<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Category::factory(4)->state(new Sequence(
            ['name' => 'music'], 
            ['name' => 'educational'],
            ['name' => 'action'],
            ['name' => 'social']
        ))->create();
        User::factory(2)
            ->state(new Sequence(
                ['email' => 'developer@gmail.com'],
                ['email' => 'client@gmail.com']
            ))
            ->has(Role::factory()->state(new Sequence(
                ['name' => 'developer'],
                ['name' => 'client']
            )))
            ->create();
    }
}
