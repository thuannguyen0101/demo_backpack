@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('title.projects') => url(config('backpack.base.route_prefix'), 'projects'),
      trans('title.project_detail') => false,
    ];
    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <section class="container-fluid d-print-none">
        <a href="javascript: window.print();" class="btn float-right"><i class="la la-print"></i></a>
        <h2>
            <span class="text-capitalize">{{ $crud->getHeading() ?? $crud->entity_name_plural }}</span>
            @if ($crud->hasAccess('list'))
                <small class=""><a href="{{ url('admin/projects') }}" class="font-sm"><i
                                class="la la-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div>
        <table id="detail"
               class="table table-bordered table-striped">
            <thead>
            <tr>
                {{-- Table columns --}}
                @foreach ($crud->columns() as $column)
                    <th
                            data-orderable="{{ var_export($column['orderable'], true) }}"
                            data-priority="{{ $column['priority'] }}"
                            {{-- If it is an export field only, we are done. --}}
                            @if(isset($column['exportOnlyField']) && $column['exportOnlyField'] === true)
                            data-visible="false"
                            data-visible-in-table="false"
                            data-can-be-visible-in-table="false"
                            data-visible-in-modal="false"
                            data-visible-in-export="true"
                            data-force-export="true"
                            @else
                            data-visible-in-table="{{var_export($column['visibleInTable'] ?? false)}}"
                            data-visible="{{var_export($column['visibleInTable'] ?? true)}}"
                            data-can-be-visible-in-table="true"
                            data-visible-in-modal="{{var_export($column['visibleInModal'] ?? true)}}"
                            @if(isset($column['visibleInExport']))
                            @if($column['visibleInExport'] === false)
                            data-visible-in-export="false"
                            data-force-export="false"
                            @else
                            data-visible-in-export="true"
                            data-force-export="true"
                            @endif
                            @else
                            data-visible-in-export="true"
                            data-force-export="false"
                            @endif
                            @endif
                    >
                        {!! $column['label'] !!}
                    </th>
                @endforeach
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
                            <div>
                                <button class="btn btn-xs btn-default btnEdit"
                                        onclick="editSystems({{ $system->id }})"
                                        data-toggle="modal"
                                        data-target="#editModal"> {{ trans('title.edit') }}
                                </button>
                                <button class="btn btn-xs btn-default btnDelete"
                                        onclick="Helper.delete('{{\App\Http\Enum\EnumProjects::SYSTEMS}}', {{ $system->id }})"
                                        data-toggle="modal"
                                        data-target="#deleteModal"> {{ trans('title.delete') }}
                                </button>
                            </div>
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
                                    <div>
                                        <button class="btn btn-xs btn-default btnEdit"
                                                onclick="editRequirement({{ $requirement->id }})"
                                                data-toggle="modal"
                                                data-target="#editModal"> {{ trans('title.edit') }}
                                        </button>
                                        <button class="btn btn-xs btn-default btnDelete"
                                                onclick="Helper.delete('{{\App\Http\Enum\EnumProjects::REQUIREMENTS}}', {{ $requirement->id }})"
                                                data-toggle="modal"
                                                data-target="#deleteModal"> {{ trans('title.delete') }}
                                        </button>
                                    </div>
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
                                        <div>
                                            <button class="btn btn-xs btn-default btnEdit"
                                                    onclick="editSubFunction({{ $subFunction->id }})"
                                                    data-toggle="modal"
                                                    data-target="#editModal"> {{ trans('title.edit') }}
                                            </button>
                                            <button class="btn btn-xs btn-default btnDelete" data-toggle="modal"
                                                    data-target="#deleteModal"
                                                    onclick="Helper.delete('{{\App\Http\Enum\EnumProjects::SUBFUNCTIONS}}', {{ $subFunction->id }})">
                                                {{ trans('title.delete') }}
                                            </button>
                                        </div>
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
                                    <div>
                                        <button class="btn btn-xs btn-default btnEdit"
                                                onclick="editRequirement({{ $requirement->id }})"
                                                data-toggle="modal"
                                                data-target="#editModal"> {{ trans('title.edit') }}
                                        </button>
                                        <button class="btn btn-xs btn-default btnDelete" data-toggle="modal"
                                                data-target="#deleteModal"
                                                onclick="Helper.delete('{{\App\Http\Enum\EnumProjects::REQUIREMENTS}}', {{ $requirement->id }})">
                                            {{ trans('title.delete') }}
                                        </button>
                                    </div>
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
                            <div>
                                <button class="btn btn-xs btn-default btnEdit"
                                        onclick="editSystems({{ $system->id }})"
                                        data-toggle="modal"
                                        data-target="#editModal"> {{ trans('title.edit') }}
                                </button>
                                <button class="btn btn-xs btn-default btnDelete" data-toggle="modal"
                                        data-target="#deleteModal"
                                        onclick="Helper.delete('{{\App\Http\Enum\EnumProjects::SYSTEMS}}', {{ $system->id }})">
                                    {{ trans('title.delete') }}
                                </button>
                            </div>
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
@endsection

@include('admin.projects.edit_modal')

@section('after_scripts')
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        let data = @if(!empty($systems)) @json($systems) @else [] @endif;
        var type = "";
        let csrf = "{{ csrf_token() }}";
        let projectId = "{{ $project->id }}"
    </script>
    @stack('crud_list_scripts')
@endsection
