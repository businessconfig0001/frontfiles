<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use FrontFiles\User;

class UsersTableSeeder extends Seeder
{
    //User emails
    protected $user_mails = [
        'user1@frontfiles.com',
        'user2@frontfiles.com',
        'user3@frontfiles.com',
        'user4@frontfiles.com',
        'user5@frontfiles.com',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach($this->user_mails as $email)
            User::create([
                'email'         => $email,
                'first_name'    => $faker->firstName,
                'last_name'     => $faker->lastName,
                'avatar'        => 'http://via.placeholder.com/450x450',
                'bio'           => $faker->text,
                'location'      => 'Odivelas, Lisbon, Portugal',
                'password'      => 'secret',
                'allowed_space' => 10737418240,
                'confirmed'     => true,
            ])->assignRole('user');

    }
}
