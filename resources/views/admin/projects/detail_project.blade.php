<div>
    <table id="detail"
           class="table table-bordered table-striped">
        <thead>
        <tr>
            <th> #</th>
            <th>{{ trans('title.system') }}</th>
            <th>{{ trans('title.function') }}</th>
            <th>{{ trans('title.sub_function') }}</th>
            <th>{{ trans('title.ios_cost') }}</th>
            <th>{{ trans('title.android_cost') }}</th>
            <th>{{ trans('title.web_cost') }}</th>
            <th>{{ trans('title.total_cost') }}</th>
            <th>{{ trans('title.actions') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($systems as $system)
            @if(($system->requirements)->isNotEmpty())
                <tr>
                    <td></td>
                    <td>{{ $system->name }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        @if($type == \App\Http\Enum\EnumProjects::SYSTEMS)
                            <div>
                                <button class="btn btn-xs btn-default btnEdit" onclick="editSystems({{ $system->id }})"
                                        data-toggle="modal"
                                        data-target="#editModal"> {{ trans('title.edit') }}
                                </button>
                                <button class="btn btn-xs btn-default btnDelete" data-toggle="modal"
                                        data-target="#deleteModal"
                                        onclick="Helper.delete('{{\App\Http\Enum\EnumProjects::SYSTEMS}}',{{ $system->id }})">
                                    {{ trans('title.delete') }}
                                </button>
                            </div>
                        @endif
                    </td>
                </tr>
                @foreach($system->requirements as $requirement)
                    @if(($requirement->subFunctions)->isNotEmpty())
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $requirement->name }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                @if($type == \App\Http\Enum\EnumProjects::REQUIREMENTS)
                                    <div>
                                        <button class="btn btn-xs btn-default btnEdit"
                                                onclick="editRequirement({{ $requirement->id }})"
                                                data-toggle="modal"
                                                data-target="#editModal"> {{ trans('title.edit') }}
                                        </button>
                                        <button class="btn btn-xs btn-default btnDelete" data-toggle="modal"
                                                data-target="#deleteModal"
                                                onclick="Helper.delete('{{\App\Http\Enum\EnumProjects::REQUIREMENTS}}',{{ $requirement->id }})">
                                            {{ trans('title.delete') }}
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        @foreach($requirement->subFunctions as $subFunction)
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>{{ $subFunction->name }}</td>
                                <td>{{ $subFunction->ios_cost }}</td>
                                <td>{{ $subFunction->android_cost }}</td>
                                <td>{{ $subFunction->web_cost }}</td>
                                <td>{{ $subFunction->total_cost }}</td>
                                <td>
                                    @if($type == \App\Http\Enum\EnumProjects::SUBFUNCTIONS)
                                        <div>
                                            <button class="btn btn-xs btn-default btnEdit"
                                                    onclick="editSubFunction({{ $subFunction->id }})"
                                                    data-toggle="modal"
                                                    data-target="#editModal"> {{ trans('title.edit') }}
                                            </button>
                                            <button class="btn btn-xs btn-default btnDelete" data-toggle="modal"
                                                    data-target="#deleteModal"
                                                    onclick="Helper.delete('{{\App\Http\Enum\EnumProjects::SUBFUNCTIONS}}',{{ $subFunction->id }})">
                                                {{ trans('title.delete') }}
                                            </button>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td></td>
                            <td></td>
                            <td>{{ $requirement->name }}</td>
                            <td></td>
                            <td>{{ $requirement->ios_cost }}</td>
                            <td>{{ $requirement->android_cost }}</td>
                            <td>{{ $requirement->web_cost }}</td>
                            <td>{{ $requirement->total_cost }}</td>
                            <td>
                                @if($type == \App\Http\Enum\EnumProjects::REQUIREMENTS)
                                    <div>
                                        <button class="btn btn-xs btn-default btnEdit"
                                                onclick="editRequirement({{ $requirement->id }})"
                                                data-toggle="modal"
                                                data-target="#editModal"> {{ trans('title.edit') }}
                                        </button>
                                        <button class="btn btn-xs btn-default btnDelete" data-toggle="modal"
                                                data-target="#deleteModal"
                                                onclick="Helper.delete('{{\App\Http\Enum\EnumProjects::REQUIREMENTS}}',{{ $requirement->id }})">
                                            {{ trans('title.delete') }}
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            @else
                <tr>
                    <td></td>
                    <td>{{ $system->name }}</td>
                    <td></td>
                    <td></td>
                    <td>{{ $system->ios_cost }}</td>
                    <td>{{ $system->android_cost }}</td>
                    <td>{{ $system->web_cost }}</td>
                    <td>{{ $system->total_cost }}</td>
                    <td>
                        @if($type == \App\Http\Enum\EnumProjects::SYSTEMS)
                            <div>
                                <button class="btn btn-xs btn-default btnEdit" onclick="editSystems({{ $system->id }})"
                                        data-toggle="modal"
                                        data-target="#editModal"> {{ trans('title.edit') }}
                                </button>
                                <button class="btn btn-xs btn-default btnDelete" data-toggle="modal"
                                        data-target="#deleteModal"
                                        onclick="Helper.delete('{{\App\Http\Enum\EnumProjects::SYSTEMS}}',{{ $system->id }})">
                                    {{ trans('title.delete') }}
                                </button>
                            </div>
                        @endif
                    </td>
                </tr>
            @endif
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td>{{ trans('title.summary') }}</td>
            <td></td>
            <td></td>
            <td></td>
            <td>{{ $project->totalIos }}</td>
            <td>{{ $project->totalAndroid }}</td>
            <td>{{ $project->totalWeb }}</td>
            <td>{{ $project->totalCost }}</td>
            <td></td>
        </tr>
        </tfoot>
    </table>
</div>

<div class="row">
    <div class="col-4 offset-8" id="detail-pagination">{!! $systems->render() !!}</div>
</div>
