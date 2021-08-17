@extends(backpack_view('blank'))

@php
    $defaultBreadcrumbs = [
      trans('title.projects') => url(config('backpack.base.route_prefix'), 'projects'),
      $crud->entity_name_plural => url($crud->route),
      trans('title.list') => false,
    ];

    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <div class="container-fluid">
        <br/><br/>
        <ul class="list-unstyled multi-steps">
            <li @if($type == \App\Http\Enum\EnumProjects::SYSTEMS) class="is-active" @endif>
                {{ trans('title.systems') }}
            </li>
            <li @if($type == \App\Http\Enum\EnumProjects::REQUIREMENTS) class="is-active" @endif>
                {{ trans('title.functions') }}
            </li>
            <li>{{ trans('title.sub_functions') }}</li>
            <li>{{ trans('title.finish') }}</li>
        </ul>
    </div>
    <div class="container-fluid">
        <h2>
            <span class="text-capitalize">{{ $crud->getHeading() ?? $crud->entity_name_plural }}</span>
            <small id="datatable_info_stack">{{ $crud->getSubheading() ?? ''}}</small>
        </h2>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="{{ $crud->getListContentClass() }}">
            <div>
                <div class="row mb-3">
                    <div class="col-6">
                        @if ( $crud->buttons()->where('stack', 'top')->count() ||  $crud->exportButtons())
                            <div class="hidden-print {{ $crud->hasAccess('create')?'with-border':'' }}">
                                @include('crud::inc.button_stack', ['stack' => 'top'])
                            </div>
                        @endif
                    </div>
                    <div class="col-6">
                        <div id="datatable_search_stack" class="float-right d-none"></div>
                    </div>
                </div>
                @if ($crud->filtersEnabled())
                    @include('crud::inc.filters_navbar')
                @endif
                <div class="overflow-hidden mt-2">
                    <table id="crudTable"
                           class="bg-white table table-striped table-hover nowrap rounded shadow-xs border-xs"
                           cellspacing="0">
                        <thead>
                        <tr>
                            @foreach ($crud->columns() as $column)
                                <th
                                        data-orderable="{{ var_export($column['orderable'], true) }}"
                                        data-priority="{{ $column['priority'] }}"
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

                            @if ($crud->buttons()->where('stack', 'line')->count())
                                <th data-orderable="false" data-priority="{{ $crud->getActionsColumnPriority() }}"
                                    data-visible-in-export="false">{{ trans('title.actions') }}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                            @foreach ($crud->columns() as $column)
                                <th>{!! $column['label'] !!}</th>
                            @endforeach

                            @if ( $crud->buttons()->where('stack', 'line')->count() )
                                <th></th>
                            @endif
                        </tr>
                        </tfoot>
                    </table>
                    @if ( $crud->buttons()->where('stack', 'bottom')->count() )
                        <div id="bottom_buttons" class="hidden-print">
                            @include('crud::inc.button_stack', ['stack' => 'bottom'])
                            <div id="datatable_button_stack" class="float-right text-right hidden-xs"></div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @include('admin.projects.detail_project')

    <div class="modal-footer" style="place-content: center;">
        <a type="button" href="{{ url()->previous() }}" class="btn btn-secondary" data-dismiss="modal">{{ trans('title.back') }}</a>
        <a href="{{ route('/project/{projectId}/systems/requirements.index',$project->id) }}" class="btn btn-primary">{{ trans('title.next') }}</a>
    </div>
@endsection

@include('admin.projects.edit_modal')
@include('admin.projects.add_modal')

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
    @include('crud::inc.datatables_logic')
    <script src="{{ asset('packages/backpack/crud/js/crud.js') }}"></script>
    <script src="{{ asset('packages/backpack/crud/js/form.js') }}"></script>
    <script src="{{ asset('packages/backpack/crud/js/list.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        <?php
        $systemArray = $systems->toArray();
        ?>
        let data = @if(!empty($systems)) @json($systemArray['data']) @else [] @endif;
        let csrf = "{{ csrf_token() }}";
        let project_id = {{ $project->id }};
    </script>
    @stack('crud_list_scripts')
@endsection
