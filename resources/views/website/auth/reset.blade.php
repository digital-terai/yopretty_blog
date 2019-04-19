@extends('website.app')
@section('content')
	<main class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-sm-push-3 col-md-4 col-md-push-4">
				<h1 class="text-center">{{ trans('message.password_reset') }}</h1>
				@include('website.auth.form.reset')
			</div>
		</div>
	</main>
@endsection
