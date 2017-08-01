<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use FrontFiles\{ File, TagWhat };

class FileTagWhatTableSeeder extends Seeder
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
        $tagIds = TagWhat::pluck('id')->all();

        foreach(range(1, 30) as $index)
            DB::table('file_tagWhat')->insert([
                'lesson_id' => $faker->randomElement($lessonIds),
                'tagWhat_id'=> $faker->randomElement($tagIds)
            ])
        */
    }
}