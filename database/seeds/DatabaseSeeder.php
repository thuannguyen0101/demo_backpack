<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        /* Calling seeder */

         $this->call([
             ProjectSeeder::class,
             SystemSeeder::class,
             RequirementSeeder::class,
             SubFunctionsSeeder::class,
             SubFunctionsSeeder::class
         ]);

    }
}
