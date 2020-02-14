<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class, 'admin', 1)->create()->each(function ($user) {
            $user->assignRole('admin');
        });
    }
}
