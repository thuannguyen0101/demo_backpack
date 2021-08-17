<?php

use Illuminate\Database\Seeder;

class SubFunctionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Array of sub_functions records  */

        $requirements = [
            [
                'name' => 'CreateOperation',
                'requirement_id' => 1,
                'priority' => 1,
                'ios_cost' => 5.2,
                'android_cost' => 6.3,
                'web_cost' => 2.4,
                'total_cost' => 11.9,
                'memo' => null,
                'username' => 'Admin',
                'user_id' => 1,
            ],
            [
                'name' => 'UpdateOperation',
                'requirement_id' => 1,
                'priority' => 2,
                'ios_cost' => 3.2,
                'android_cost' => 5.3,
                'web_cost' => 4.4,
                'total_cost' => 12.9,
                'memo' => null,
                'username' => 'Admin',
                'user_id' => 1,
            ],
            [
                'name' => 'Resource CRUD',
                'requirement_id' => 2,
                'priority' => 2,
                'ios_cost' => 12.2,
                'android_cost' => 7.3,
                'web_cost' => 8.4,
                'total_cost' => 27.9,
                'memo' => null,
                'username' => 'SuperAdmin',
                'user_id' => 2,
            ],
            [
                'name' => 'HumanResource CRUD',
                'requirement_id' => 3,
                'priority' => 2,
                'ios_cost' => 4.2,
                'android_cost' => 2.3,
                'web_cost' => 6.4,
                'total_cost' => 12.9,
                'memo' => null,
                'username' => 'User',
                'user_id' => 3,
            ],
        ];

        /* Check table have data or not . If not insert record */

        if (DB::table('sub_functions')->count() == 0){
            DB::table('sub_functions')->insert($requirements);
        }
    }
}
