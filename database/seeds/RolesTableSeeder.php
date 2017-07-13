<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    //Role types
    protected $types = [
        'administrator',
        'basic',
        'organization'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->types as $type)
            DB::table('roles')->insert([
                'type' => $type
            ]);
    }
}
