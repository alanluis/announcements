<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    $start = $faker->dateTimeBetween('next Monday', 'next Monday +7 days');

    return [
        'subject' => $faker->sentence,
        'content' => $faker->text,
        'start_date' => $start,
        'expiration_date' => $faker->dateTimeBetween($start, $start->format('Y-m-d H:i:s').' +7 days'),
    ];
});
