<?php

namespace App\Http\Controllers\Admin;

use App\Http\Enum\EnumProjects;
use App\Http\Requests\SystemRequest;
use App\Models\Project;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Route;

/**
 * Class SystemCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class SystemCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation {
        store as traitStore;
    }

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\System::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/systems');
        CRUD::setEntityNameStrings(trans('title.system'), trans('title.systems'));
        $this->crud->setSubheading('');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
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
                        return backpack_url('systems/' . $entry->id . '/show');
                    },
                ],
            ],
            [
                'name' => 'priority',
                'type' => 'select_from_array',
                'label' => trans('title.priority'),
                'options' => EnumProjects::PRIORITY,
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
                'type' => 'text',
            ]
        ]);
        $this->crud->removeButton('show');
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(SystemRequest::class);
        $this->crud->setHeading(trans('title.create_system'), 'create');
        CRUD::addFields([
            [
                'name' => 'name',
                'label' => trans('title.name'),
                'type' => 'text',
            ],
            [
                'label' => trans('title.project'),
                'type' => 'select',
                'name' => 'project_id',
                'entity' => 'project',
                'attribute' => 'name',
                'model' => "App\Models\Project",
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
                'type' => 'number',
                'label' => trans('title.web_cost'),
                'default' => 0,
                'attributes' => ["step" => "any"]
            ],
            [
                'name' => 'total_cost',
                'type' => 'hidden',
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
            ]
        ]);
        $this->crud->enableResponsiveTable();
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        CRUD::setValidation(SystemRequest::class);
        $this->crud->setHeading(trans('title.edit_system'), 'edit');
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->crud->setHeading(trans('title.system_detail'), 'show');
        $this->crud->addColumns([
            [
                'name' => 'name',
                'type' => 'text',
                'label' => trans('title.name')
            ],
            [
                'name' => 'project_id',
                'type' => 'select',
                'label' => trans('title.project'),
                'entity' => 'project',
                'attribute' => 'name',
                'model' => Project::class,
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
