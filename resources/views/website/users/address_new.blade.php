@extends('website.app')
@section('content')
<!--=== Content Part ===-->
<main class="container">
    <h1>{{trans('store.address.new')}}</h1>
	@include('flash::notification')
    <form class="" action="" method="post">
		{{ csrf_field() }}
		<input type="hidden" name="previous" value="{{$previous}}">
		<div class="row form-group">
			<div class="col-xs-12 col-sm-6">
				<div class="row form-group">
					<div class="col-xs-12 col-sm-6">
						<input class="form-control" type="text" name="street" placeholder="{{trans('store.address.fields.street')}}" required>
					</div>
					<div class="col-xs-12 col-sm-6">
						<input class="form-control" type="text" name="number" placeholder="{{trans('store.address.fields.number')}}" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-xs-12 col-sm-6">
						<input class="form-control" type="text" name="zip_code" placeholder="{{trans('store.address.fields.zip_code')}}" required>
					</div>
					<div class="col-xs-12 col-sm-6">
						<input class="form-control" type="text" name="city" placeholder="{{trans('store.address.fields.city')}}" required>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-xs-12 col-sm-6">
						<input class="form-control" type="text" name="province" placeholder="{{trans('store.address.fields.province')}}" required>
					</div>
					<div class="col-xs-12 col-sm-6">
						<select class="form-control" name="country_id" required>
							@foreach ($countries as $_country)
								<option value="{{$_country->id}}">{{$_country->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<input class="form-control" type="text" name="vat" placeholder="{{trans('store.address.fields.vat')}}">
			</div>
			<div class="col-xs-12 col-sm-6">
				<input class="form-control form-group" type="text" name="phone" placeholder="{{trans('store.address.fields.phone')}}">
				<input class="form-control form-group" type="text" name="mobile" placeholder="{{trans('store.address.fields.mobile')}}">
				<input class="form-control form-group" type="email" name="email" placeholder="{{trans('store.address.fields.email')}}">
			</div>
		</div>
		<button type="submit" class="btn btn-primary">
			{{trans('store.address.save')}}
		</button>
    </form>
</main>
@endsection
