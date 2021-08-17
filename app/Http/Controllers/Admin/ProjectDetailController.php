<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EditServiceProjectRequest;
use App\Models\Project;
use App\Models\Requirement;
use App\Models\SubFunction;
use App\Models\System;
use App\Traits\ResponseMessage;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

class ProjectDetailController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use ResponseMessage;

    public function setup()
    {
        $projectId = request()->route()->parameter('projectId');
        CRUD::setModel(\App\Models\Project::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/project' . $projectId . '/detail');
        CRUD::setEntityNameStrings(trans('title.project'), trans('title.projects'));
    }

    public function index()
    {
        $this->crud->hasAccessOrFail('list');
        $projectId = request()->route()->parameter('projectId');
        $project = Project::find($projectId);
        $this->crud->setHeading($project->name);
        $this->crud->setTitle(trans('title.project_detail'));
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name_plural);
        $systems = $project->systems;

        return view('custom.detail_project', $this->data)
            ->with('systems', $systems)
            ->with('project', $project);
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
            [
                'name' => 'row_number',
                'type' => 'row_number',
                'label' => '#',
            ],
            [
                'name' => 'name',
                'type' => 'text',
                'label' => trans('title.systems'),
            ],
            [
                'label' => trans('title.functions'),
            ],
            [
                'label' => trans('title.sub_functions'),
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
                'label' => trans('title.actions')
            ]
        ]);
        $this->crud->enableResponsiveTable();
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * edit system in project
     */
    public function updateSystem(EditServiceProjectRequest $request)
    {
        try {
            $systemId = $request->route()->parameter('systemId');
            $params = $request->except('_token');
            $params['total_cost'] = $params['ios_cost'] + $params['android_cost'] + $params['web_cost'];
            System::find($systemId)->update($params);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * edit requirement in system
     */
    public function updateRequirement(EditServiceProjectRequest $request)
    {
        try {
            $requirementId = $request->route()->parameter('requirementId');
            $params = $request->except('_token');
            $params['total_cost'] = $params['ios_cost'] + $params['android_cost'] + $params['web_cost'];
            Requirement::find($requirementId)->update($params);

            return $this->success();
        } catch (\Exception $exception) {
            return $this->error($exception);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * edit subFunction in requirement
     */
    public function updateSubFunction(EditServiceProjectRequest $request)
    {
        try {
            $subFunctionId = $request->route()->parameter('subFunctionId');
            $request->merge([
                'total_cost' => $request->ios_cost + $request->android_cost + $request->web_cost
            ]);
            SubFunction::find($subFunctionId)->update($request->all());

            return $this->crud->route;
        } catch (\Exception $exception) {
            return $this->error($exception);
        }
    }

    /* Project Final View */
    public function finalIndex(){
        $projectId = request()->route()->parameter('projectId');
        $this->crud->hasAccessOrFail('list');
        $project = Project::find($projectId);
        $this->crud->setHeading($project->name);
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? mb_ucfirst($this->crud->entity_name_plural);
        $systems = $project->systems;

        return view('admin.projects.final',$this->data,compact(['systems','project']));
    }
}
