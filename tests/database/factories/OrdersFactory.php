<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */


use ChrisRhymes\PolicyCollect\Tests\Models\Order;
use ChrisRhymes\PolicyCollect\Tests\Models\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'user_id' => factory(User::class)
    ];
});
