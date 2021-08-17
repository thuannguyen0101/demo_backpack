@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('Project List') => url(config('backpack.base.route_prefix'), 'projects'),
      trans('title.list') => false,
    ];

    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <div class="container-fluid">
        <br/><br/>
        <ul class="list-unstyled multi-steps">
            <li>{{ trans('title.system') }}</li>
            <li>{{ trans('title.function') }}</li>
            <li>{{ trans('title.sub_function') }}</li>
            <li class="is-active">{{ trans('title.finish') }}</li>
        </ul>
    </div>
    <div class="container-fluid">
        <h2>
            <span class="text-capitalize">{{ $crud->getHeading() ?? $crud->entity_name_plural }}</span>
            <small id="datatable_info_stack">{{ $crud->getSubheading() ?? '' }}</small>
        </h2>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="{{ $crud->getListContentClass() }}">
            <div>
                <div class="row mb-0">
                    <div class="col-6">
                        @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
                            <div class="hidden-print {{ $crud->hasAccess('create')?'with-border':'' }}">
                                @include('crud::inc.button_stack', ['stack' => 'top'])
                            </div>
                        @endif
                    </div>
                    <div class="col-6">
                        <div id="datatable_search_stack" class="float-right"></div>
                    </div>
                </div>
                @if ($crud->filtersEnabled())
                    @include('crud::inc.filters_navbar')
                @endif
                <div class="overflow-hidden mt-2">
                    <div>
                        <table class="bg-white table-bordered table nowrap rounded shadow-xs border-xs" id="detail">
                            <thead>
                            <tr>
                                <th>{{ trans('title.system') }}</th>
                                <th>{{ trans('title.function') }}</th>
                                <th>{{ trans('title.sub_function') }}</th>
                                <th>{{ trans('title.ios_cost') }}</th>
                                <th>{{ trans('title.android_cost') }}</th>
                                <th>{{ trans('title.web_cost') }}</th>
                                <th>{{ trans('title.total_cost') }}</th>
                                <th>{{ trans('title.memo') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($systems))
                                @foreach($systems as $k => $system)
                                    <?php $action = true ?>
                                    <tr>
                                        <td @if (count($system->requirements) > 0) rowspan="{{ $system->totalRecords + 1 }}" @endif>
                                            {{ $system->name }}
                                        </td>
                                        @if(count($system->requirements) < 1)
                                            <td></td>
                                            <td></td>
                                            <td>{{ $system->ios_cost }}</td>
                                            <td>{{ $system->android_cost }}</td>
                                            <td>{{ $system->web_cost }}</td>
                                            <td>{{ $system->total_cost }}</td>
                                            <td>{{ $system->memo }}</td>
                                        @endif
                                    </tr>
                                    @if(count($system->requirements) > 0)
                                        @foreach($system->requirements as $key => $requirement)
                                            <tr>
                                                <td rowspan="{{ $requirement->totalRecords }}">
                                                    {{ $requirement->name }}
                                                </td>
                                                @if(count($requirement->subFunctions) < 1)
                                                    <td></td>
                                                    <td>{{ $requirement->ios_cost }}</td>
                                                    <td>{{ $requirement->android_cost }}</td>
                                                    <td>{{ $requirement->web_cost }}</td>
                                                    <td>{{ $requirement->total_cost }}</td>
                                                    <td>{{ $requirement->memo }}</td>
                                                @endif

                                            </tr>
                                            @if(count($requirement->subFunctions))
                                                @foreach($requirement->subFunctions as $key2 => $subFunction)
                                                    <tr>
                                                        <td>{{ $subFunction->name }}</td>
                                                        <td>{{ $subFunction->ios_cost }}</td>
                                                        <td>{{ $subFunction->android_cost }}</td>
                                                        <td>{{ $subFunction->web_cost }}</td>
                                                        <td>{{ $subFunction->total_cost }}</td>
                                                        <td>{{ $subFunction->memo }}</td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                            <tr>
                                <td>{{ trans('title.summary') }}</td>
                                <td></td>
                                <td></td>
                                <td>{{ $project->totalIos }}</td>
                                <td>{{ $project->totalAndroid }}</td>
                                <td>{{ $project->totalWeb }}</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>{{ trans('title.total') }}</td>
                                <td>{{ $project->totalCost }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer" style="place-content: center;">
                        <a type="button" href="{{ url()->previous() }}" class="btn btn-secondary" data-dismiss="modal">{{ trans('title.back') }}</a>
                        <button type="button" id="export" class="btn btn-primary" data-dismiss="modal">{{ trans('title.export') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('after_styles')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('packages/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('packages/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('packages/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/form.css') }}">
    <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/list.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    @stack('crud_list_styles')
@endsection

@section('after_scripts')
    <script src="{{ asset('packages/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('packages/backpack/crud/js/form.js') }}"></script>
    <script src="{{ asset('packages/backpack/crud/js/list.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/xlsx.js') }}"></script>
    <script>
        /* get table data & generate table to excel */
        $(document).ready(function () {
            $("#export").click(function () {
                var wscols = [{wch: 40}, {wch: 40}, {wch: 40}, {wch: 20}, {wch: 10}, {wch: 10}, {wch: 10}, {wch: 10}, {wch: 50}];
                var workbook = XLSX.utils.book_new();
                var worksheet_data = document.getElementById("detail");
                var worksheet = XLSX.utils.table_to_sheet(worksheet_data, {
                    raw: true,
                });
                worksheet['!cols'] = wscols;
                workbook.SheetNames.push("Project {{ $project->id }}");
                workbook.Sheets["Project {{ $project->id }}"] = worksheet;
                exportExcelFile(workbook);
            });
        })

        /* Export to Excel file */
        function exportExcelFile(workbook) {
            return XLSX.writeFile(workbook, "{{ $project->name }}.xlsx");
        }
    </script>
    @stack('crud_list_scripts')
@endsection
