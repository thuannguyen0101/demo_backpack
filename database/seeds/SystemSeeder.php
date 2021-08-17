<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Array of systems records */

        $systems = [
            [
                'name' => 'Enviroment Managerment',
                'project_id' => 1,
                'priority' => 2,
                'ios_cost' => 50.2,
                'android_cost' => 60.3,
                'web_cost' => 30.4,
                'total_cost' => 140.9,
                'user_id' => 1,
                'username' => 'Admin',
                'memo' => null,
            ],
            [
                'name' => 'Resource Managerment',
                'project_id' => 1,
                'priority' => 2,
                'ios_cost' => 50.2,
                'android_cost' => 60.3,
                'web_cost' => 30.4,
                'total_cost' => 140.9,
                'user_id' => 1,
                'username' => 'Admin',
                'memo' => null,
            ],
            [
                'name' => 'Human Resource Management',
                'project_id' => 1,
                'priority' => 3,
                'ios_cost' => 50.2,
                'android_cost' => 60.3,
                'web_cost' => 30.4,
                'total_cost' => 140.9,
                'user_id' => 1,
                'username' => 'Admin',
                'memo' => null,
            ],
            [
                'name' => 'Student Managerment',
                'project_id' => 2,
                'priority' => 2,
                'ios_cost' => 50.2,
                'android_cost' => 60.3,
                'web_cost' => 30.4,
                'total_cost' => 140.9,
                'user_id' => 1,
                'username' => 'Admin',
                'memo' => null,
            ],
            [
                'name' => 'Exam Managerment',
                'project_id' => 2,
                'priority' => 2,
                'ios_cost' => 50.2,
                'android_cost' => 60.3,
                'web_cost' => 30.4,
                'total_cost' => 140.9,
                'user_id' => 1,
                'username' => 'Admin',
                'memo' => null,
            ],
            [
                'name' => 'Exam System',
                'project_id' => 3,
                'priority' => 2,
                'ios_cost' => 50.2,
                'android_cost' => 60.3,
                'web_cost' => 30.4,
                'total_cost' => 140.9,
                'user_id' => 1,
                'username' => 'Admin',
                'memo' => null,
            ],
        ];

        /* Check table have data or not . If not insert record */

        if (DB::table('systems')->count() == 0){
            DB::table('systems')->insert($systems);
        }

    }
}
