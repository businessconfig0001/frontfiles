<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use FrontFiles\Video;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1,30) as $x)
            Video::create([
                'user_id' => $faker->numberBetween(1, 5),
                'short_id' => $faker->randomNumber(8),
                'filename' => $faker->streetName,
                'url' => $faker->url,
                'title' => $faker->sentence,
                'description' => $faker->paragraph,
                'what' => $faker->sentence,
                'where' => $x > 5 ? $faker->city : 'Lisbon',
                'when' => $faker->dateTimeThisMonth,
                'who' => $faker->name
            ]);
    }
}
