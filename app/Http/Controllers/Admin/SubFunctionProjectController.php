<?php

namespace App\Http\Controllers\Admin;

use App\Http\Enum\EnumProjects;
use App\Http\Requests\AddServiceProjectRequest;
use App\Http\Requests\SubFunctionRequest;
use App\Models\Project;
use App\Models\SubFunction;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Traits\ResponseMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SubFunctionProjectController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use ResponseMessage;

    public function setup()
    {
        $projectId = request()->route()->parameter('projectId');
        CRUD::setModel(\App\Models\SubFunction::class);
        CRUD::setRoute(config('backpack.base.route_prefix')
            . '/project/' . $projectId . '/systems/requirements/subfunctions');
        CRUD::setEntityNameStrings(trans('title.sub_function'), trans('title.add_sub_function'));
        $this->crud->setSubheading('');
    }

    protected function index()
    {
        $projectId = request()->route()->parameter('projectId');
        $project = Project::find($projectId);
        $systems = $project->systems()->paginate(4);
        $this->crud->hasAccessOrFail('list');
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name_plural);
        $type = 'subFunctions';

        return view('admin.projects.add_subfunction', $this->data)
            ->with('type', $type)
            ->with('systems', $systems)
            ->with('project', $project);
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'row_number',
                'type' => 'row_number',
                'label' => '#'
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
        $this->crud->removeButton('update');
        $this->crud->addButtonFromView('line', 'add', 'add', 'beginning');
        $this->crud->enableResponsiveTable();
        $this->addCustomCrudFilters();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(SubFunctionRequest::class);
        $this->crud->setHeading(trans('title.create_sub_function'));
        $this->crud->setCreateView('admin.projects.create_subfunction');
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

        if ( is_null(\request()->get(EnumProjects::ALLHISTORY)) ) {
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

    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->crud->setHeading(trans('title.sub_function_detail'), 'show');
        $this->crud->addColumns([
            [
                'name' => 'name',
                'type' => 'text',
                'label' => trans('title.name')
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
                'label' => trans('title.memo')
            ]
        ]);
        $this->crud->removeButton('delete');
    }

    /* Add sub function already exist to project*/
    public function storeSubFunction(AddServiceProjectRequest $request)
    {
        try {
            $subFunctionId = $request->route()->parameter('subFunctionId');
            $params = $request->except(['_token', 'parent_id','type']);
            $params['requirement_id'] = $request->parent_id;
            $params['total_cost'] = $params['ios_cost'] + $params['android_cost'] + $params['web_cost'];
            $params['memo'] = sprintf("%s - %s", $request->name, $subFunctionId);
            if ( !is_null($request->memo) ) {
                $params['memo'] = $request->memo;
            }
            $params['username'] = backpack_user()->name;
            $params['user_id'] = backpack_user()->id;
            SubFunction::create($params);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->error($exception);
        }
    }

    /* Create new sub function and add to project*/
    public function store(SubFunctionRequest $request)
    {
        try {
            $request->validated();
            $request->merge([
                'username' => backpack_user()->name,
                'user_id' => backpack_user()->id,
            ]);
            SubFunction::create($request->all());

            return redirect($this->crud->route);
        } catch (\Exception $exception) {
            return $this->error($exception);
        }
    }
}
