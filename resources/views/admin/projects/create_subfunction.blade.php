@extends(backpack_view('blank'))

@php
    use App\Models\System;
    $defaultBreadcrumbs = [
      $crud->entity_name_plural => url($crud->route),
      trans('title.create') => false,
    ];

    // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
    $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
    $projectId = request()->route()->parameter('projectId');
    $systems = System::where('project_id', '=', $projectId)->get();
@endphp

@section('header')
    <section class="container-fluid">
        <h2>
            <span class="text-capitalize">{{ $crud->getHeading() ?? $crud->entity_name_plural }}</span>
            <small>{{ $crud->getSubheading() ?? trans('title.add').' '.$crud->entity_name }}.</small>

            @if ($crud->hasAccess('list'))
                <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i
                                class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('title.back_to_all') }}
                        <span>{{ $crud->entity_name_plural }}</span></a></small>
            @endif
        </h2>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="{{ $crud->getCreateContentClass() }}">
            @include('crud::inc.grouped_errors')
            <form method="post" action="{{ url($crud->route) }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">{{ trans('title.name') }}</label>
                            <input class="form-control" id="name" name="name" type="text" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="addSystem">{{ trans('title.system') }}</label>
                            <select class="form-control" id="addSystem">
                                @foreach($systems as $system)
                                    <option value="{{ $system->id }}">{{ $system->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="addParent">{{ trans('title.function') }}</label>
                            <select class="form-control" name="requirement_id" id="addParent">
                                @foreach($systems as $system)
                                    @foreach($system->requirements as $requirement)
                                        <option value="{{ $requirement->id }}"
                                                name="{{ $requirement->system_id }}">{{ $requirement->name }}</option>
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="priority">{{ trans('title.priority') }}</label>
                            <select name="priority" id="priority" class="form-control">
                                <option value="high">{{ trans('title.high') }}</option>
                                <option value="medium">{{ trans('title.medium') }}</option>
                                <option value="low">{{ trans('title.low') }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ios">{{ trans('title.ios_cost') }}</label>
                            <input class="form-control" id="ios" type="number" step="any" name="ios_cost"
                                   value="{{ old('ios_cost') }}">
                        </div>
                        <div class="form-group">
                            <label for="android">{{ trans('title.android_cost') }}</label>
                            <input class="form-control" id="android" type="number" step="any" name="android_cost"
                                   value="{{ old('android_cost') }}">
                        </div>
                        <div class="form-group">
                            <label for="web">{{ trans('title.web_cost') }}</label>
                            <input class="form-control" id="web" type="number" step="any" name="web_cost"
                                   value="{{ old('web_cost') }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success" id="save">
                    <span class="la la-save" role="presentation" aria-hidden="true"></span> &nbsp;
                    <span>{{ $saveAction['active']['label'] }}</span>
                </button>
                @if(!$crud->hasOperationSetting('showCancelButton') || $crud->getOperationSetting('showCancelButton') == true)
                    <a href="{{ $crud->hasAccess('list') ? url($crud->route) : url()->previous() }}"
                       class="btn btn-default"><span class="la la-ban"></span>
                        &nbsp;{{ trans('title.cancel') }}</a>
                @endif
            </form>
        </div>
    </div>
@endsection

@section('after_scripts')
    @stack('crud_fields_scripts')
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
        $(document).ready(function () {
            /* Backpack validate message */
            @if ($crud->inlineErrorsEnabled() && $errors->any())
                window.errors = {!! json_encode($errors->messages()) !!};

            $.each(errors, function (property, messages) {
                var normalizedProperty = property.split('.').map(function (item, index) {
                    return index === 0 ? item : '[' + item + ']';
                }).join('');

                var field = $('[name="' + normalizedProperty + '[]"]').length ?
                    $('[name="' + normalizedProperty + '[]"]') :
                    $('[name="' + normalizedProperty + '"]'),
                    container = field.parents('.form-group');

                container.addClass('text-danger');
                container.children('input, textarea, select').addClass('is-invalid');

                $.each(messages, function (key, msg) {
                    // highlight the input that errored
                    var row = $('<div class="invalid-feedback d-block">' + msg + '</div>');
                    row.appendTo(container);

                    // highlight its parent tab
                    @if ($crud->tabsEnabled())
                    var tab_id = $(container).closest('[role="tabpanel"]').attr('id');
                    $("#form_tabs [aria-controls=" + tab_id + "]").addClass('text-danger');
                    @endif
                });
            });
            @endif
        })
    </script>
    @stack('crud_list_scripts')
@endsection