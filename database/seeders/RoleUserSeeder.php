<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = 
        [['role_id'=>1, 'user_id' => 1,],
        ['role_id'=> 1, 'user_id' => 2],
        ['role_id'=>2, 'user_id' => 3],
        ['role_id'=>2, 'user_id' => 4]];

        DB::table('role_user')->insert($role_user);
    }
}
