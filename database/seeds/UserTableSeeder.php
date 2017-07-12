<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    //Doctor states
    protected $admin_emails = [
        'user1@frontfiles.com',
        'user2@frontfiles.com',
        'user3@frontfiles.com',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach($this->admin_emails as $index =>$email)
        {
            \App\User::create([
                'confirmed' => true,
                'name' => $faker->name,
                'email' => $email,
                'password' => bcrypt('secret')
            ]);
        }
    }
}
