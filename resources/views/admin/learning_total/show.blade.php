@extends('crud::show')
@section('content')
<div class="row">
	<div class="{{ $crud->getShowContentClass() }}">

	<!-- Default box -->
	  <div class="">
	  	@if ($crud->model->translationEnabled())
	    <div class="row">
	    	<div class="col-md-12 mb-2">
				<!-- Change translation button group -->
				<div class="btn-group float-right">
				  <button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    {{trans('backpack::crud.language')}}: {{ $crud->model->getAvailableLocales()[request()->input('locale')?request()->input('locale'):App::getLocale()] }} &nbsp; <span class="caret"></span>
				  </button>
				  <ul class="dropdown-menu">
				  	@foreach ($crud->model->getAvailableLocales() as $key => $locale)
					  	<a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?locale={{ $key }}">{{ $locale }}</a>
				  	@endforeach
				  </ul>
				</div>
			</div>
	    </div>
	    @else
	    @endif

	    <div class="card no-padding no-border">
            <div role="header" class="bg-primary px-2 py-2">
                <span class="text-white h4 font-weight-bold">名前：{{$entry->name}}</span>
            </div>
            @foreach($entry->summaries() as $level_code => $summary)
			<table class="table table-striped mb-0">
		        <tbody>
                    <tr class="status--{{$summary['result']}}" style="">
                        <td colspan="2" class="font-weight-bold">{{$summary['level_name']}}</td>
						@if ($summary['result'] === 2)
							<td class="font-weight-bold" style="width: 40%">修了</td>
						@elseif ($summary['result'] > 1)
							<td class="font-weight-bold" style="width: 40%">学習中</td>
						@else
							<td class="font-weight-bold" style="width: 40%">未着手</td>
						@endif
						
						<td class="text-right" style="width: 20%">
                            <button class='btn btn-white btn-sm mt-n1 py-0 collapse--trigger' data-target="#levels_{{$level_code}}"><i class="las la-plus"></i></button>
                        </td>
                    </tr>
		        </tbody>
			</table>
            @include('admin.learning_total.area', ["summary" => $summary, "level_code" => $level_code])
            @endforeach
	    </div><!-- /.box-body -->
	  </div><!-- /.box -->

	</div>
</div>
@endsection
@push("after_scripts")
    <script>
        $(".collapse--trigger").on("click", function(event) {
            var $target = $(event.currentTarget.dataset.target);
            if ($target.hasClass("show")){
                event.currentTarget.innerHTML = '<i class="las la-plus"></i>';
            } else {
                event.currentTarget.innerHTML = '<i class="las la-minus"></i>';
            }
            $target.collapse("toggle");

        });
    </script>

@endpush
@push("after_styles")
	<style>
		.status--2 {
			background: rgb(248, 203, 173) !important;
		}
		.status--1 {
			background: rgb(191, 191, 191) !important;
		}
		.status--0 {
			background: rgb(169, 208, 142) !important;
		}
	</style>
@endpush
