<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 'users', 20)->create()->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
