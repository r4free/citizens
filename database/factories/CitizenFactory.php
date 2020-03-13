<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Citizen::class, function (Faker $faker) {
    $sexo = ['m','f'][random_int(0,1)];
    return [
        'name' => $faker->unique()->name($sexo == 'm'? 'male':'female'),
        'father_name' => $faker->name('male'),
        'mother_name' => $faker->name('female'),
        'gender' => $sexo,
        'studding' => random_int(0,1),
        'birthday' => $nacimento = \Carbon\Carbon::now()->subYears(random_int(10,45)),
        'disease_date' => random_int(0,1) ? $nacimento->addYears(rand(1,10 )) : null,
        'buss' => function(){
            $linhas = [];
            for ($l=500; $l<900; $l = $l + random_int(3,9)){
                array_push($linhas,$l);
            }
            return random_int(0,1) ? $linhas  : null;
        }
    ];
});
