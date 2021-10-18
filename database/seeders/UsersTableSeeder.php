<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::factory()->count(2)->create()
            ->each(function ($role) {
                $role->users()->save(\App\Models\User::factory()->make());
            });
    }
}
