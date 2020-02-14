<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Spatie\Permission\Models\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name' => 'admin',
        'guard_name' => 'web'
    ];
}, 'admin');

$factory->defineAs(Role::class, 'user', function (Faker $faker) {
    return [
        'name' => 'user',
        'guard_name' => 'web'
    ];
});
