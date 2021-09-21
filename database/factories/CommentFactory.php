<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        'comment' => $faker->text(255),
        'question_id' => \App\Models\Question::all()->random()->id,
        'created_by' =>\App\User::all()->random()->id,
    ];
});
