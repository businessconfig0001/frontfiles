<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use FrontFiles\{ File, TagWho };

class FileTagWhoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $faker = Faker::create();

        $fileIds = File::pluck('id')->all();
        $tagIds = TagWho::pluck('id')->all();

        foreach(range(1, 30) as $index)
            DB::table('file_tagWho')->insert([
                'lesson_id' => $faker->randomElement($lessonIds),
                'tagWho_id' => $faker->randomElement($tagIds)
            ])
        */
    }
}