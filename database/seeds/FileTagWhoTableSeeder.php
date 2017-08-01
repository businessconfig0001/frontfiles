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
        $faker = Faker::create();

        $fileIds = File::pluck('id')->all();
        $tagIds = TagWho::pluck('id')->all();

        foreach(range(1, 30) as $index)
            DB::table('file_tagWho')->insert([
                'file_id' => $faker->randomElement($fileIds),
                'tagWho_id' => $faker->unique()->randomElement($tagIds)
            ]);
    }
}