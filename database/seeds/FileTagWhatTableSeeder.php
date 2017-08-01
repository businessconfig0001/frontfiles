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
        $faker = Faker::create();

        $fileIds = File::pluck('id')->all();
        $tagIds = TagWhat::pluck('id')->all();

        foreach(range(1, 30) as $index)
            DB::table('file_tagWhat')->insert([
                'file_id' => $faker->randomElement($fileIds),
                'tagWhat_id'=> $faker->unique()->randomElement($tagIds)
            ]);
    }
}