<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use FrontFiles\TagWhat;

class TagsWhatTableSeeder extends Seeder
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
            TagWhat::create(['name' => $faker->unique()->word]);
    }
}