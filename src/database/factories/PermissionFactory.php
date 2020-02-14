<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Spatie\Permission\Models\Permission;
use Faker\Generator as Faker;

$factory->define(Permission::class, function (Faker $faker) {
    return [
        'name' => 'create post',
        'guard_name' => 'web'
    ];
}, 'create post');

$factory->defineAs(Permission::class, 'show post', function (Faker $faker) {
    return [
        'name' => 'show post',
        'guard_name' => 'web'
    ];
});

$factory->defineAs(Permission::class, 'update post', function (Faker $faker) {
    return [
        'name' => 'update post',
        'guard_name' => 'web'
    ];
});

$factory->defineAs(Permission::class, 'delete post', function (Faker $faker) {
    return [
        'name' => 'delete post',
        'guard_name' => 'web'
    ];
});

$factory->defineAs(Permission::class, 'sort posts', function (Faker $faker) {
    return [
        'name' => 'sort posts',
        'guard_name' => 'web'
    ];
});

$factory->defineAs(Permission::class, 'search posts', function (Faker $faker) {
    return [
        'name' => 'search posts',
        'guard_name' => 'web'
    ];
});
