@include('flash::notification')
<form method="POST" action="{{ url_locale('/password/email') }} ">
	{{ csrf_field() }}
	<div class="form-group">
		<input type="email" class="form-control" name="email" placeholder="{{ trans('website.email') }}" required>
	</div>
	<div class="form-group">
		<button type="submit" class="btn btn-primary btn-block">
			{{ trans('message.password_sent_reset_link') }}
		</button>
	</div>
</form>
