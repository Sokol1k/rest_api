<?php

use Illuminate\Database\Seeder;

class RoleHasPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Spatie\Permission\Models\Role::class, 'admin', 1)->create()->each(function ($user) {
            $user->givePermissionTo(factory(Spatie\Permission\Models\Permission::class, 'create post', 1)->create());
            $user->givePermissionTo(factory(Spatie\Permission\Models\Permission::class, 'show post', 1)->create());
            $user->givePermissionTo(factory(Spatie\Permission\Models\Permission::class, 'update post', 1)->create());
            $user->givePermissionTo(factory(Spatie\Permission\Models\Permission::class, 'delete post', 1)->create());
            $user->givePermissionTo(factory(Spatie\Permission\Models\Permission::class, 'sort posts', 1)->create());
            $user->givePermissionTo(factory(Spatie\Permission\Models\Permission::class, 'search posts', 1)->create());
        });

        factory(Spatie\Permission\Models\Role::class, 'user', 1)->create()->each(function ($user) {
            $user->givePermissionTo(Spatie\Permission\Models\Permission::findById(1));
            $user->givePermissionTo(Spatie\Permission\Models\Permission::findById(2));
            $user->givePermissionTo(Spatie\Permission\Models\Permission::findById(3));
            $user->givePermissionTo(Spatie\Permission\Models\Permission::findById(4));
            $user->givePermissionTo(Spatie\Permission\Models\Permission::findById(5));
            $user->givePermissionTo(Spatie\Permission\Models\Permission::findById(6));
        });
    }
}
