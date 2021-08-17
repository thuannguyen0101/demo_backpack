<?php

namespace App\Http\Controllers\Admin;

use App\Http\Enum\EnumProjects;
use App\Http\Requests\RequirementRequest;
use App\Models\System;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RequirementCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RequirementCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Requirement::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/requirements');
        CRUD::setEntityNameStrings(trans('title.function'), trans('title.functions'));
        $this->crud->setSubheading('');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'name' => 'row_number',
            'type' => 'row_number',
            'label' => '#',
            'orderable' => false,
        ])->makeFirstColumn();

        CRUD::addColumns([
            [
                'name' => 'name',
                'label' => trans('title.name'),
                'type' => 'text',
                'wrapper' => [
                    'href' => function ($crud, $column, $entry, $related_key) {
                        return backpack_url('requirements/' . $entry->id . '/show');
                    }
                ]
            ],
            [
                'name' => 'priority',
                'label' => trans('title.priority'),
                'type' => 'select_from_array',
                'options' => EnumProjects::PRIORITY
            ],
            [
                'name' => 'ios_cost',
                'type' => 'number',
                'label' => trans('title.ios_cost'),
                'decimals' => 1,
                'dec_point' => '.'
            ],
            [
                'name' => 'android_cost',
                'type' => 'number',
                'label' => trans('title.android_cost'),
                'decimals' => 1,
                'dec_point' => '.'
            ],
            [
                'name' => 'web_cost',
                'type' => 'number',
                'label' => trans('title.web_cost'),
                'decimals' => 1,
                'dec_point' => '.'
            ],
            [
                'name' => 'total_cost',
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
            ],
            [
                'name' => 'memo',
                'label' => trans('title.memo'),
                'type' => 'text'
            ]
        ]);
        $this->crud->removeButton('show');
        $this->crud->enableResponsiveTable();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(RequirementRequest::class);
        $this->crud->setHeading(trans('title.create_function'), 'create');
        CRUD::addFields([
            [
                'name' => 'name',
                'label' => trans('title.name'),
                'type' => 'text',
            ],
            [
                'label' => trans('title.systems'),
                'type' => 'select',
                'name' => 'system_id',
                'entity' => 'system',
                'attribute' => 'name',
                'model' => "App\Models\System",
            ],
            [
                'name' => 'priority',
                'label' => trans('title.priority'),
                'type' => 'select_from_array',
                'options' => EnumProjects::PRIORITY,
            ],
            [
                'name' => 'ios_cost',
                'label' => trans('title.ios_cost'),
                'type' => 'number',
                'default' => 0,
                'attributes' => ["step" => "any"]
            ],
            [
                'name' => 'android_cost',
                'label' => trans('title.android_cost'),
                'type' => 'number',
                'default' => 0,
                'attributes' => ["step" => "any"]
            ],
            [
                'name' => 'web_cost',
                'label' => trans('title.web_cost'),
                'type' => 'number',
                'default' => 0,
                'attributes' => ["step" => "any"]
            ],
            [
                'name' => 'total_cost',
                'label' => trans('title.total_cost'),
                'type' => 'hidden'
            ],
            [
                'name' => 'user_id',
                'type' => 'hidden',
                'value' => backpack_user()->id
            ],
            [
                'name' => 'username',
                'type' => 'hidden',
                'value' => backpack_user()->name
            ],
        ]);
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(RequirementRequest::class);
        $this->crud->setHeading(trans('title.edit_function'), 'edit');
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->crud->setHeading(trans('title.function_detail'), 'show');
        $this->crud->addColumns([
            [
                'name' => 'name',
                'type' => 'text',
                'label' => trans('title.name')
            ],
            [
                'name' => 'system_id',
                'type' => 'select',
                'label' => trans('title.system'),
                'entity' => 'system',
                'attribute' => 'name',
                'model' => System::class,
            ],
            [
                'name' => 'priority',
                'label' => trans('title.priority'),
                'type' => 'select_from_array',
                'options' => EnumProjects::PRIORITY,
            ],
            [
                'name' => 'ios_cost',
                'label' => trans('title.ios_cost'),
            ],
            [
                'name' => 'android_cost',
                'label' => trans('title.android_cost'),
            ],
            [
                'name' => 'web_cost',
                'label' => trans('title.web_cost'),
            ],
            [
                'name' => 'total_cost',
                'label' => trans('title.total_cost'),
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
            ],
            [
                'name' => 'memo',
                'label' => trans('title.memo')
            ]
        ]);
        $this->crud->removeButton('delete');
    }
}
