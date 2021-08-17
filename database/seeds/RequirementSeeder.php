<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Array of requirements records */

        $requirements = [
            [
                'name' => 'Waste management',
                'system_id' => 1,
                'priority' => 1,
                'ios_cost' => 20.2,
                'android_cost' => 10.3,
                'web_cost' => 10.4,
                'total_cost' => 40.9,
                'memo' => null,
                'username' => 'Admin',
                'user_id' => 1,
            ],
            [
                'name' => 'Civilian report',
                'system_id' => 1,
                'priority' => 2,
                'ios_cost' => 20.2,
                'android_cost' => 33.3,
                'web_cost' => 11.4,
                'total_cost' => 64.7,
                'memo' => null,
                'username' => 'Admin',
                'user_id' => 1
            ],
            [
                'name' => 'Resource CRUD',
                'system_id' => 2,
                'priority' => 2,
                'ios_cost' => 21.2,
                'android_cost' => 13.3,
                'web_cost' => 11.4,
                'total_cost' => 45.9,
                'memo' => null,
                'username' => 'SuperAdmin',
                'user_id' => 2
            ],
            [
                'name' => 'HumanResource CRUD',
                'system_id' => 3,
                'priority' => 2,
                'ios_cost' => 21.2,
                'android_cost' => 24.3,
                'web_cost' => 25.4,
                'total_cost' => 70.9,
                'memo' => null,
                'username' => 'User',
                'user_id' => 3,
            ],
        ];

        /* Check table have data or not . If not insert record */

        if (DB::table('requirements')->count() == 0){
            DB::table('requirements')->insert($requirements);
        }
    }
}
