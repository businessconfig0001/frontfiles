<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use FrontFiles\{ File, Tag };

class FileTagTableSeeder extends Seeder
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
        $tagIds = Tag::pluck('id')->all();

        foreach(range(1, 30) as $index)
            DB::table('lesson_tag')->insert([
                'lesson_id' => $faker->randomElement($lessonIds),
                'tag_id'    => $faker->randomElement($tagIds)
            ])
        */
    }

}