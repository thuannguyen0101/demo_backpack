<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProjectRequest;
use App\Traits\ResponseMessage;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;
use Exception;

class ProjectCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation {
        clone as traitClone;
    }
    use ResponseMessage;

    public function setup()
    {
        CRUD::setModel(\App\Models\Project::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/projects');
        CRUD::setEntityNameStrings(trans('title.project'), trans('title.projects'));
        $this->crud->setSubheading('');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'row_number',
                'type' => 'row_number',
                'label' => '#',
                'orderable' => false,
            ],
            [
                'name' => 'name',
                'type' => 'text',
                'label' => trans('title.name'),
                'wrapper' => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('project/' . $entry->id . '/detail');
                    }
                ]
            ],
            [
                'name' => 'totalIos',
                'type' => 'number',
                'label' => trans('title.ios_cost'),
                'decimals' => 1,
                'dec_point' => '.'
            ],
            [
                'name' => 'totalAndroid',
                'type' => 'number',
                'label' => trans('title.android_cost'),
                'decimals' => 1,
                'dec_point' => '.'
            ],
            [
                'name' => 'totalWeb',
                'type' => 'number',
                'label' => trans('title.web_cost'),
                'decimals' => 1,
                'dec_point' => '.'
            ],
            [
                'name' => 'totalCost',
                'type' => 'number',
                'label' => trans('title.total_cost'),
                'decimals' => 1,
                'dec_point' => '.'
            ],
            [
                'name' => 'username',
                'label' => trans('title.created_by')
            ],
            [
                'name' => 'created_at',
                'type' => 'datetime',
                'format' => 'l',
                'label' => trans('title.created_at')
            ]
        ]);
        $this->crud->removeButton('show');
        $this->crud->enableResponsiveTable();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProjectRequest::class);
        $this->crud->setHeading(trans('title.create_project'), 'create');
        $this->crud->addFields([
            [
                'name' => 'name',
                'type' => 'text',
                'label' => trans('title.name')
            ],
            [
                'name' => 'user_id',
                'type' => 'hidden',
                'value' => backpack_user()->id,
            ],
            [
                'name' => 'username',
                'type' => 'hidden',
                'value' => backpack_user()->name,
            ],
            [
                'name' => 'total_cost',
                'type' => 'hidden',
                'default' => 0
            ]
        ]);
        $this->crud->addSaveAction([
            'name' => 'create_project',
            'redirect' => function ($crud, $request, $itemId) {
                return 'admin/project/' . $itemId . '/systems';
            },
            'button_text' => trans('title.create'),
            'order' => 1
        ]);
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(ProjectRequest::class);
        $this->crud->setHeading(trans('title.edit_project'), 'edit');
        $this->crud->addFields([
            [
                'name' => 'name',
                'type' => 'text',
                'label' => trans('title.name')
            ]
        ]);
        $this->crud->addSaveAction([
            'name' => 'edit_project',
            'redirect' => function ($crud, $request, $itemId) {
                return 'admin/project/' . $itemId . '/systems';
            },
            'button_text' => trans('title.save'),
            'order' => 1
        ]);
    }

    public function clone($id)
    {
        $this->crud->hasAccessOrFail('clone');
        $this->crud->setOperation('clone');
        try {
            DB::beginTransaction();
            /* find project */
            $project = \App\Models\Project::find($id);
            /* duplicate project info */
            $newProject = $project->replicate();
            /* change project info */
            $newProject->name = sprintf("%s - %s", $project->name, $id);
            $newProject->username = backpack_user()->name;
            $newProject->user_id = backpack_user()->id;
            /* create project */
            $newProject->save();
            /* systems check */
            if ($project->systems->isNotEmpty()) {
                /* systems loop */
                foreach ($project->systems as $system) {
                    /* duplicate system info */
                    $newSystem = $system->replicate();
                    /* change system info */
                    $newSystem->project_id = $newProject->id;
                    $newSystem->username = backpack_user()->name;
                    $newSystem->user_id = backpack_user()->id;
                    $newSystem->memo = sprintf("%s - %s", $system->name, $system->id);;
                    /* create system */
                    $newSystem->save();
                    /* requirements check */
                    if ($system->requirements->isNotEmpty()) {
                        /* requirements loop */
                        foreach ($system->requirements as $requirement) {
                            /* duplicate requirement info */
                            $newRequirement = $requirement->replicate();
                            /* change requirement info */
                            $newRequirement->system_id = $newSystem->id;
                            $newRequirement->username = backpack_user()->name;
                            $newRequirement->user_id = backpack_user()->id;
                            $newRequirement->memo = sprintf("%s - %s", $requirement->name, $requirement->id);;
                            /* create requirement */
                            $newRequirement->save();
                            /* sub_functions check */
                            if ($requirement->subFunctions->isNotEmpty()) {
                                /* sub_functions loop */
                                foreach ($requirement->subFunctions as $subFunction) {
                                    /* subFunctions duplicate */
                                    $newSubFunctions = $subFunction->replicate();
                                    /* change subFunctions info */
                                    $newSubFunctions->requirement_id = $newRequirement->id;
                                    $newSubFunctions->username = backpack_user()->name;
                                    $newSubFunctions->user_id = backpack_user()->id;
                                    $newSubFunctions->memo = sprintf("%s - %s", $subFunction->name, $subFunction->id);;
                                    /* subFunction create */
                                    $newSubFunctions->save();
                                }
                            }
                        }
                    }
                }
            }
            DB::commit();

            return $this->success();
        } catch (Exception $exception) {
            DB::rollBack();

            return $this->error($exception);
        }
    }
}
