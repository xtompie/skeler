<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Page;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Page::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(6, true),
        'subtitle' => $faker->paragraph(3, true),
        'body' => $faker->text(600),
    ];
});
