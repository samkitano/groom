<?php

use Faker\Generator as Faker;

$factory->define(App\Faq::class, function (Faker $faker) {
    $title = $faker->unique()->sentence;

    return [
        'name' => $faker->unique()->word,
        'title' => [
            'en' => 'EN '.$title,
            'pt' => 'PT '.$title,
            'es' => 'ES '.$title,
            'fr' => 'FR '.$title,
        ],
        'slug' => [
            'en' => str_slug($title),
            'pt' => str_slug($title),
            'es' => str_slug($title),
            'fr' => str_slug($title),
        ],
        'body' => [
            'en' => str_slug($faker->text(200)),
            'pt' => str_slug($faker->text(200)),
            'es' => str_slug($faker->text(200)),
            'fr' => str_slug($faker->text(200)),
        ],
        'order' => 0,
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
    ];
});
