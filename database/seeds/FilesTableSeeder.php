<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use FrontFiles\{ User, File };

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $userIds = User::pluck('id')->all();

        foreach (range(1,100) as $x){
            $short_id = File::generateUniqueShortID(8);
            $extension = 'mp4';
            $name = $short_id . '.' . $extension;

            File::create([
                'user_id'       => $faker->randomElement($userIds),
                'short_id'      => $short_id,
                'drive'         => $faker->randomElement(['azure', 'dropbox']),
                'type'          => 'video',
                'extension'     => $extension,
                'size'          => 383631,
                'original_name' => $faker->word,
                'name'          => $name,
                'url'           => 'http://techslides.com/demos/sample-videos/small.mp4',
                'title'         => $faker->sentence,
                'description'   => $faker->paragraph,
                'where'         => 'Odivelas, Lisbon, Portugal',
                'latitude'      => 38.795369,
                'longitude'     => -9.18518,
                'when'          => $faker->dateTimeThisMonth,
                'why'           => $faker->sentence,
            ]);
        }
    }
}
