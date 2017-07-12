<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    //Tables to truncate
    protected $toTruncate = [
        'users',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Disable foreign keys checks to avoid errors
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //delete all data
        foreach($this->toTruncate as $table)
        {
            DB::table($table)->truncate();
            $this->command->info("Database table '{$table}' truncated");
        }
        //Enable foreign keys again
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call(UserTableSeeder::class);
        $this->command->info('Users created');


    }
}
