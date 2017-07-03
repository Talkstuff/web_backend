<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Modules\Users\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'phone' => $faker->phoneNumber,
        'birth_date' => $faker->dateTimeBetween('-50 years','-18 years'),
        'username' => $faker->unique()->userName,
        'email' => $faker->unique()->safeEmail,
        'registered_date' => $faker->dateTimeThisMonth,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Modules\Users\Models\Group::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->name,
        'reserved' => $faker->boolean(),

    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Modules\Posts\Models\Post::class, function (Faker\Generator $faker) {
    return [
        'content' => $faker->paragraphs(),
    ];
});