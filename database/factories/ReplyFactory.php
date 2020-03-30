<?php

use Faker\Generator as Faker;
use App\Models\User;
use App\Models\Topic;
use Illuminate\Support\Facades\Cache;

$factory->define(App\Models\Reply::class, function (Faker $faker) {

    $time = $faker->dateTimeThisMonth();

    // if (!($user_ids = Cache::get('user_ids'))) {
    //     $user_ids = User::all()->pluck('id')->toArray();
    //     Cache::put('user_ids', $user_ids);
    // }
    // if (!($topic_ids = Cache::get('topic_ids'))) {
    //     $topic_ids = Topic::all()->pluck('id')->toArray();
    //     Cache::put('topic_ids', $topic_ids);
    // }

    // $user_ids = cache()->remember('user_ids', 3600, function () {
    //     return User::all()->pluck('id')->toArray();
    // });
    // $topic_ids = cache()->remember('topic_ids', 3600, function () {
    //     return Topic::all()->pluck('id')->toArray();
    // });

    return [
        // 'user_id' => $faker->randomElement($user_ids),
        // 'topic_id' => $faker->randomElement($topic_ids),
        'content' => $faker->sentence(),
        'created_at' => $time,
        'updated_at' => $time,
    ];
});
