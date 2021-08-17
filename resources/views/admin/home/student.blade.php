@extends(backpack_view('blank'))

@php

  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    trans('backpack::crud.list') => false,
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
    <div class="container-fluid pagecontent" style="">
        <div class="card panel-default">
            <div class="card-header" style="color: #333; background-color: #f5f5f5; border-color: #ddd;">
                <h2 class="font-weight-bold text-center">通知作成</h2>
                <h5 class="font-weight-normal text-left">{!! $crud->getHeading() ?? $crud->entity_name_plural !!}</h5>
            </div>
            <div class="card-body">
                <ul class="listviewcontent" style="padding-right: 40px">
                    <table class="table table-hover" style="border: 1px solid">
                        <thead>
                        <tr>
                            <th scope="col">学年ID</th>
                            <th scope="col">学生氏名</th>
                            <th scope="col">欠席</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($students as $key=> $student)
                            <tr>
                                <td>
                                   {{$student->id}}

                                </td>
                                <td class="" style="font-size: 20px">{{$student->name}}</td>
                                <td></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="form-group text-center">
                        @if ($crud->hasAccess('create'))
                            <a href="{{ url($crud->route.'/create') }}" class="btn btn-primary" data-style="zoom-in"><span class="ladda-label"><i class="la la-plus"></i> {{ trans('backpack::crud.add') }} {{ $crud->entity_name }}</span></a>
                        @endif
                    </div>
                </ul>
            </div>
        </div>


    </div>
    <script !src="">
        function handleSelectStudent(cb)
        {
            $('#sendpost').prop('disabled', !enableSendPost());
        }
        function uploadCheck() {
            if (document.getElementById('radio-upload').checked) {
                document.getElementById('show-upload').style.display = 'block';
                document.getElementById('show-url').style.display = 'none';
                document.getElementById('checkRadio').value = 1;
            }
        }
        function uploadcheck() {
            if (document.getElementById('radio-url').checked) {
                document.getElementById('show-upload').style.display = 'none';
                document.getElementById('show-url').style.display = 'block';
                document.getElementById('checkRadio').value = 2;
            }
        }
        function enableSendPost()
        {
            var checkings = document.getElementsByName('tostudents[]')
            for (i = 0; i < checkings.length; i++) {
                if(checkings[i].checked)
                {
                    return true;
                }
            }

            return false;
        }
    </script>
@endsection

@section('content')



@endsection

@section('after_styles')
  <!-- DATA TABLES -->
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-fixedheader-bs4/css/fixedHeader.bootstrap4.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('packages/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}">

  <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/crud.css') }}">
  <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/form.css') }}">
  <link rel="stylesheet" href="{{ asset('packages/backpack/crud/css/list.css') }}">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <!-- CRUD LIST CONTENT - crud_list_styles stack -->
  @stack('crud_list_styles')
@endsection

@section('after_scripts')
    @include('crud::inc.datatables_logic')
  <script src="{{ asset('packages/backpack/crud/js/crud.js') }}"></script>
  <script src="{{ asset('packages/backpack/crud/js/form.js') }}"></script>
  <script src="{{ asset('packages/backpack/crud/js/list.js') }}"></script>

  <!-- CRUD LIST CONTENT - crud_list_scripts stack -->
  @stack('crud_list_scripts')
@endsection
