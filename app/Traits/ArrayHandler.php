<?php

namespace App\Traits;


trait ArrayHandler
{
    /**
     * Take Attribute from Model Collection to Array
     * @param $data
     * @return array
     * @throws \Exception
     */
    protected function getAttribute($data)
    {
        try {
            $newData = collect($data->toArray())->except('id', 'created_at', 'updated_at', 'requirement_id', 'system_id');
            $newData['username'] = backpack_user()->name;
            $newData['user_id'] = backpack_user()->id;
            $newData['memo'] = sprintf("%s - %s", $data->name, $data->id);
            $newData = $newData->toArray();

            return $newData;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * Take Attribute from Array and modify
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    protected function getNewAttribute($data)
    {
        try {
            $data['total_cost'] = $data['ios_cost'] + $data['android_cost'] + $data['web_cost'];
            $data['username'] = backpack_user()->name;
            $data['user_id'] = backpack_user()->id;

            return $data;
        }catch (\Exception $exception) {
            throw $exception;
        }
    }
}
