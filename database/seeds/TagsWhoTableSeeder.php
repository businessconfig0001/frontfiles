<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use FrontFiles\TagWho;

class TagsWhoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach(range(1, 30) as $index)
            TagWho::create(['name' => $faker->word]);
    }
}