<?php

namespace App\Traits;


use App\Http\Enum\EnumProjects;
use App\Models\Requirement;
use App\Models\SubFunction;
use App\Models\System;
use App\Http\Enum\EnumType;

trait AddHelper
{
    /**
     * Store Parent Record
     * @param $param
     * @param $projectId
     * @param $model
     * @param $type
     * @return bool
     * @throws \Exception
     */
    public function storeParent($param, $projectId, $model, $type)
    {
        try {
            switch ($type) {
                /* Add system */
                case $type == EnumProjects::SYSTEMS:
                    $routerParam = EnumType::CAMELSYSTEM;
                    $parentType = EnumType::SNAKEPROJECT;
                    $currentType = EnumType::SNAKESYSTEM;
                    $childModel = Requirement::class;
                    $currentModel = System::class;
                    $addChild = true;
                    break;
                 /* Add Requirement */
                default :
                    $routerParam = EnumType::CAMELREQUIREMENT;
                    $parentType = EnumType::SNAKESYSTEM;
                    $currentType = EnumType::SNAKEREQUIREMENT;
                    $childModel = SubFunction::class;
                    $currentModel = Requirement::class;
                    $addChild = false;
                    break;
            }
            $isSuccess = true;
            $id = \request()->route()->parameter($routerParam);
            $old = $model::find($id);
            $param[$parentType] = $projectId;
            if (is_null($param['memo'])) {
                $param['memo'] = sprintf("%s - %s", $old->name, $param[$parentType]);
            }
            $param = $this->getNewAttribute($param);
            $newSystem = $currentModel::create($param);
            if (!$newSystem) {
                $isSuccess = false;

                return $isSuccess;
            }
            $oldChilds = $old->childs;
            if (is_null($oldChilds) || $oldChilds->isEmpty()) {
                return $isSuccess;
            }
            $isSuccess = $this->storeChild($oldChilds, $newSystem->id, $childModel, $currentType, $addChild);

            return $isSuccess;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    /**
     * store Child Record
     * @param $param
     * @param $parentId
     * @param $model
     * @param $parentType
     * @param bool $addChild
     * @return bool
     */
    public function storeChild($param, $parentId, $model, $parentType, bool $addChild)
    {
        $isSuccess = true;
        foreach ($param as $currentChild) {
            /* duplicate requirement info */
            $newRecord = $this->getAttribute($currentChild);
            /* modify requirement */
            $newRecord[$parentType] = $parentId;
            $newRecord = $model::create($newRecord);
            if (!$newRecord) {
                $isSuccess = false;

                return $isSuccess;
            }
            $oldChilds = $currentChild->childs;
            if (is_null($oldChilds) || $oldChilds->isEmpty()) {
                return $isSuccess;
            }
            if ($addChild) {
                $isSuccess = $this->storeChild($oldChilds, $newRecord->id, SubFunction::class, EnumType::SNAKEREQUIREMENT, false);
            }
            if (!$addChild) {
                return $isSuccess;
            }
        }

        return $isSuccess;
    }
}
