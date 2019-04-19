@include('flash::notification')
<div class="row">
	{{ Form::open(array('action' => '\App\maguttiCms\Website\Controllers\WebsiteFormController@getContactUsForm')) }}
	@if(isset($request_product_id))
		{{ Form::hidden('request_product_id', $request_product_id, ['class' => 'form-control']) }}
	@endif

	    <div class="col-xs-12 mb10">
			<div class="color-3 text-center mb15">{!! trans('website.message.required_field') !!}</div>
	    </div>
		@if(isset($product))
			<div class="col-xs-12 mb10">
				{!! trans('website.message.product_request') !!} {{$product->title}}.
			</div>
		@endif
		<div class="col-xs-12">
		    <div class="form-group">
		        {{ Form::label('email',trans('website.email'), ['class' => 'required']) }}
		        {{ Form::email('email', null,  ['class' => 'form-control', 'required']) }}
		        {{ $errors->first('email') }}
		    </div>
	    </div>
		<div class="col-xs-12">
		    <div class="form-group">
		        {{ Form::label('name', trans('website.name'), ['class' => 'required']) }}
		        {{ Form::text('name', null,  ['class' => 'form-control', 'required']) }}
		        {{ $errors->first('name') }}
		    </div>
	    </div>
		<div class="col-xs-12">
		    <div class="form-group">
		        {{ Form::label('surname',trans('website.surname'), ['class' => 'required']) }}
		        {{ Form::text('surname', null,  ['class' => 'form-control', 'required']) }}
		        {{ $errors->first('surname') }}
		    </div>
	    </div>
		<div class="col-xs-12">
		    <div class="form-group">
		        {{ Form::label('company',trans('website.employer')) }}
		        {{ Form::text('company', null,  ['class' => 'form-control']) }}
		        {{ $errors->first('company') }}
		    </div>
	    </div>
		<div class="col-xs-12">
		    <div class="form-group">
		        {{ Form::label('subject', trans('website.subject'), ['class' => 'required']) }}
		        {{ Form::text('subject', null,  ['class' => 'form-control', 'required']) }}
		        {{ $errors->first('subject') }}
		    </div>
	    </div>
		<div class="col-xs-12">
		    <div class="form-group">
		        {{ Form::label('message', trans('website.message_email'), ['class' => 'required']) }}
		        {{ Form::textarea('message', null,  ['class' => 'form-control', 'rows' => 5, 'required']) }}
		        {{ $errors->first('message') }}
		    </div>
	    </div>
		<div class="col-xs-12">
		    <div class="form-group">
				<div class="form-checkbox">
					<input type="checkbox" class="form-input" name="privacy" value="1" id="privacy" required>
					<label for="privacy">
						<a href="https://www.iubenda.com/privacy-policy/{{ Setting::getOption('iubenda_code_'.LaravelLocalization::getCurrentLocale()) }}" class="iubenda-nostyle no-brand iubenda-embed " title="{{ trans('website.privacy')}}">
							{{trans('website.message.privacy')}}
						</a>
					</label>
					{{ $errors->first('privacy') }}
				</div>
		    </div>
	    </div>
		<div class="col-xs-12">
		    <div class="form-group ">
		        {{ Form::submit(trans('website.send'), array('class' => 'btn btn-lg btn-primary btn-block')) }}
	    	</div>
	    </div>
	{{ Form::close() }}
</div>
