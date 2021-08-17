<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        /* Array of project records */

        $projects = [
            [
                'name' => 'Enviroment Enterprise Planning Resource',
                'ios_cost' => 50.2,
                'android_cost' => 60.3,
                'web_cost' => 30.4,
                'total_cost' => 140.9,
                'user_id' => 1,
                'username' => 'Admin'
            ],
            [
                'name' => 'Education Managerment',
                'ios_cost' => 50.2,
                'android_cost' => 60.3,
                'web_cost' => 30.4,
                'total_cost' => 140.9,
                'user_id' => 1,
                'username' => 'Admin'
            ],
            [
                'name' => 'Entertainment System',
                'ios_cost' => 40.2,
                'android_cost' => 50.3,
                'web_cost' => 20.4,
                'total_cost' => 110.9,
                'user_id' => 1,
                'username' => 'Admin'
            ],
        ];

        /* Check table have data or not . If not insert record */

        if (DB::table('projects')->count() == 0){
            DB::table('projects')->insert($projects);
        }
    }
}
