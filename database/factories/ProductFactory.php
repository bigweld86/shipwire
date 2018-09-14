<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'product_name' => $faker->sentence($nbWords = 4, $variableNbWords = true),
        'product_description' => $faker->paragraph($nbSentences = 6, $variableNbSentences = true),
        'product_price' => $faker->numberBetween($min=500, $max=2000),
        'product_width' => $faker->numberBetween($min=1, $max=300),
        'product_length' => $faker->numberBetween($min=1, $max=300),
        'product_height' => $faker->numberBetween($min=1, $max=300),
        'product_weight' => $faker->numberBetween($min=1, $max=1000),
    ];
});