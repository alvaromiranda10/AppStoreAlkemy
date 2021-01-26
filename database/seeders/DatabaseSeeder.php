<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Wish_list;
use App\Models\Application;
use Illuminate\Database\Seeder;
use App\Models\Historical_price;
use Database\Seeders\RoleUserSeeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // CATEGORY
        Category::factory(5)->state(new Sequence(
            ['name' => 'music'], 
            ['name' => 'educational'],
            ['name' => 'action'],
            ['name' => 'social'],
            ['name' => 'strategy']
        ))->create();
        //ROLE
        Role::factory(2)
        ->state(new Sequence(
            ['name' => 'developer'],
            ['name' => 'client']
            ))->create();
        // USER DEVELOPER
        User::factory(2)
        ->state(new Sequence(
            ['email' => 'developer@gmail.com'],
            ['email' => 'alvaro@gmail.com'],
            ))->create();
        // APLICATION  HAS HISTORIC PRICE
        Application::factory(40)
                    ->has(Historical_price::factory()
                    ->count(1)
                    ->state(function (array $attributes, Application $application){
                        return ['price' => $application->price];
                    })
                    )
                    ->create();

        //USER CLIENT HAS CART Y WHISLIST
        User::factory(2)
        ->state(new Sequence(
            ['email' => 'client@gmail.com'],
            ['email' => 'martin@gmail.com']
        ))
        ->has(Cart::factory()
        ->count(1)
        ->state(function(array $attributes, User $user){
            return ['user_id' => $user->id];
        })
        )
        ->has(Wish_list::factory()
        ->count(1)
        ->state(function (array $attributes, User $user){
            return ['user_id' => $user->id];
        })
        )
        ->create();
        // USER HAS ROLE
        $this->call([RoleUserSeeder::class]);
    }
}
