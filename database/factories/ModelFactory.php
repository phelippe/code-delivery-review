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

$factory->define(CodeDelivery\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(CodeDelivery\Models\Category::class, function (Faker\Generator $faker){
    return [
        'name' => $faker->word,
    ];
});

$factory->define(CodeDelivery\Models\Product::class, function (Faker\Generator $faker){
    return [
        'name' => $faker->word,
        'description' => $faker->sentence,
        'price' => $faker->numberBetween(10,50)
    ];
});

$factory->define(CodeDelivery\Models\Client::class, function (Faker\Generator $faker){
    return [
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'city' => $faker->city,
        'state' => $faker->state,
        'zipcode' => $faker->postcode
    ];
});

$factory->define(CodeDelivery\Models\Order::class, function(Faker\Generator $faker) {
    return [
        #'client_id' => $faker->randomElement(\CodeDelivery\Models\User::all()->lists('id')),
        'client_id' => \CodeDelivery\Models\Client::all()->lists('id')->random(1),
        #'user_deliveryman_id' => $faker->randomElement(\CodeDelivery\Models\User::all()->lists('id')),
        'user_deliveryman_id' => \CodeDelivery\Models\User::all()->lists('id')->random(1),
        'total' => $faker->randomFloat(6),
        'status' => $faker->numberBetween(1,6),
    ];
});

$factory->define(CodeDelivery\Models\OrderItem::class, function(Faker\Generator $faker) {
    return [
        'product_id' => \CodeDelivery\Models\Product::all()->lists('id')->random(1),
        'order_id' => \CodeDelivery\Models\Order::all()->lists('id')->random(1),
        'price' => $faker->randomFloat(6),
        'qtd' => $faker->randomNumber(6),
    ];
});