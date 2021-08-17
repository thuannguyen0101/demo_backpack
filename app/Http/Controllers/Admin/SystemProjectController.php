<?php

namespace App\Http\Controllers\Admin;

use App\Http\Enum\EnumProjects;
use App\Http\Requests\AddServiceProjectRequest;
use App\Http\Requests\SystemRequest;
use App\Models\Project;
use App\Models\Requirement;
use App\Models\SubFunction;
use App\Models\System;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Traits\ResponseMessage;
use App\Traits\ArrayHandler;
use App\Traits\AddHelper;

class SystemProjectController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    use ResponseMessage;
    use ArrayHandler;
    use AddHelper;

    public function setup()
    {
        $projectId = request()->route()->parameter('projectId');
        CRUD::setModel(\App\Models\System::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/project/' . $projectId . '/systems');
        CRUD::setEntityNameStrings(trans('title.system'), trans('title.add_system'));
        $this->crud->setSubheading('');
    }

    protected function index()
    {
        $this->crud->hasAccessOrFail('list');
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name_plural);
        $projectId = request()->route()->parameter('projectId');
        $project = Project::find($projectId);
        $systems = Project::find($projectId)->systems()->paginate(4);
        $type = "systems";

        return view('admin.projects.add_system', $this->data)->with('type', $type)->with('systems', $systems)->with('project', $project);
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
                'limit' => 255
            ],
            [
                'name' => 'priority',
                'label' => trans('title.priority'),
                'type' => 'select_from_array',
                'options' => EnumProjects::PRIORITY,
                'allows_null' => false,
                'default' => 'medium'
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
                'type' => 'text',
                'label' => trans('title.created_by'),
            ],
            [
                'name' => 'created_at',
                'type' => 'datetime',
                'format' => 'l',
                'label' => trans('title.created_at'),
            ],
            [
                'name' => 'memo',
                'type' => 'text',
                'label' => trans('title.memo'),
            ]
        ]);
        $this->crud->addButtonFromView('line', 'add', 'add_button', 'beginning');
        $this->crud->removeButton('update');
        $this->crud->enableResponsiveTable();
        $this->addCustomCrudFilters();
    }

    protected function addCustomCrudFilters()
    {
        CRUD::filter('model')
            ->type('dropdown')
            ->label(trans('title.type'))
            ->values(EnumProjects::TYPE_PROJECTS)
            ->whenActive(function ($value) {
                if ($value == EnumProjects::SYSTEMS) {
                    CRUD::setModel(\App\Models\System::class);
                } else if ($value == EnumProjects::REQUIREMENTS) {
                    CRUD::setModel(\App\Models\Requirement::class);
                } else if ($value == EnumProjects::SUBFUNCTIONS) {
                    CRUD::setModel(\App\Models\SubFunction::class);
                }
            })->apply();

        if (is_null(\request()->get(EnumProjects::ALLHISTORY))) {
            $this->crud->addClause(EnumProjects::HIGH);
        }

        $this->crud->addFilter([
            'type' => 'simple',
            'name' => EnumProjects::ALLHISTORY,
            'label' => trans('title.all_history'),
        ], false, function () {});

        $this->crud->addFilter([
            'type' => 'text',
            'name' => 'name',
            'label' => trans('title.name')
        ],
            false,
            function ($value) {
                $this->crud->addClause('where', 'name', 'LIKE', "%$value%");
            }
        );
    }

    protected function setupCreateOperation()
    {
        $this->crud->setHeading(trans('title.create_system'));
        $projectId = request()->route()->parameter('projectId');
        CRUD::setValidation(SystemRequest::class);
        CRUD::addFields([
            [
                'name' => 'name',
                'label' => trans('title.name'),
                'type' => 'text',
            ],
            [
                'label' => trans('title.project'),
                'type' => 'select',
                'name' => 'project_id_show',
                'default' => $projectId,
                'entity' => 'project',
                'attribute' => 'name',
                'attributes' => [
                    'placeholder' => 'Some text when empty',
                    'class' => 'form-control some-class',
                    'readonly' => 'readonly',
                    'disabled' => 'disabled',
                ],
                'model' => "App\Models\Project",
            ],
            [
                'type' => 'hidden',
                'name' => 'project_id',
                'default' => $projectId,
            ],
            [
                'type' => 'hidden',
                'name' => 'total_cost',
            ],
            [
                'type' => 'hidden',
                'name' => 'user_id',
                'default' => backpack_user()->id,
            ],
            [
                'type' => 'hidden',
                'name' => 'username',
                'default' => backpack_user()->name,
            ],
            [
                'name' => 'priority',
                'label' => trans('title.priority'),
                'type' => 'select_from_array',
                'options' => EnumProjects::PRIORITY,
                'allows_null' => false,
                'default' => 'medium'
            ],
            [
                'name' => 'ios_cost',
                'label' => trans('title.ios_cost'),
                'type' => 'number',
                'default' => 0,
                'attributes' => ["step" => "any"],
            ],
            [
                'name' => 'android_cost',
                'label' => trans('title.android_cost'),
                'type' => 'number',
                'default' => 0,
                'attributes' => ["step" => "any"],
            ],
            [
                'name' => 'web_cost',
                'type' => 'number',
                'label' => trans('title.web_cost'),
                'default' => 0,
                'attributes' => ["step" => "any"],
            ],
        ]);
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

    /**
     * Directional request
     * @param AddServiceProjectRequest $request
     * @return JsonResponse
     */
    public function requestHandle(AddServiceProjectRequest $request)
    {
        try {
            $type = $request->type;
            DB::beginTransaction();
            $projectId = $request->parent_id;
            $param = $request->except(['_token', 'type', 'parent_id']);
            if ($type == EnumProjects::SUBFUNCTIONS) {
                $isCreated = $this->storeParent($param, $projectId, SubFunction::class,EnumProjects::SYSTEMS);
            } elseif ($type == EnumProjects::REQUIREMENTS) {
                $isCreated = $this->storeParent($param, $projectId, Requirement::class,EnumProjects::SYSTEMS);
            } else {
                $isCreated = $this->storeParent($param, $projectId, System::class,EnumProjects::SYSTEMS);
            }
            if (!$isCreated) {
                DB::rollBack();

                return $this->error(new \Exception(trans('title.error.system.create'), 500));
            }
            DB::commit();

            return $this->success();
        } catch (\Exception $exception) {
            DB::rollBack();

            return $this->error($exception);
        }
    }
}
