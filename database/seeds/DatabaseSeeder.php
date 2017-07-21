<?php

use Illuminate\{
    Database\Seeder, Support\Facades\DB
};

class DatabaseSeeder extends Seeder
{
    //Tables to truncate and seeded
    protected $tables = [
        'permissions'   => PermissionsTableSeeder::class,
        'roles'         => RolesTableSeeder::class,
        'users'         => UsersTableSeeder::class,
        'files'         => FilesTableSeeder::class,
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

        //Delete all data
        foreach($this->tables as $name => $class)
        {
            DB::table($name)->truncate();
            $this->command->info("Table '{$name}' truncated");
        }

        //Enable foreign keys again
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        //Populate database with data
        foreach($this->tables as $name => $class)
        {
            $this->call($class);
            $this->command->info("Table '{$name}' populated");
        }
    }
}
