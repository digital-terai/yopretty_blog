@extends('admin.master')
@section('title', 'Admin Control Panel')
@section('content')
	<main id="home-buttons" class="container-fluid">
		<h1>MaguttiCms Admin</h1>
		<div class="row">
			<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
				<a href="{{ URL::to('') }}" target="_new">
					<div class="button">
						{{icon('globe')}}
						<h3>Website </h3>
					</div>
				</a>
			</div>
			@foreach (config('maguttiCms.admin.list.section') as $_code => $section)
				@if (isset($section['menu']['home']) && $section['menu']['home'] && Auth::guard('admin')->user()->canViewSection($section))
					<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
						<a href="{{ ma_get_admin_list_url($section['model']) }}">
							<div class="button">
									{{icon($section['icon'])}}
									<h3>{{ trans('admin.models.'.$_code) }}</h3>
							</div>
						</a>
					</div>
				@endif
			@endforeach
		</div>
	</main>
@endsection
