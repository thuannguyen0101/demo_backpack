@if ($crud->hasAccess('update'))
    <a href="#" onclick="Helper.add({{$entry->getKey()}})" class="btn btn-sm btn-success btn-link" style="color: white; background-color: #7c69ef"
       data-toggle="modal"
       data-target="#addModal"><i class="la la-plus"></i>{{ trans('backpack::crud.add') }}</a>
@endif
