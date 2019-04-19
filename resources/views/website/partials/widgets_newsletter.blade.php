{{ Form::open(array('id' => 'form-newsletter', 'name' => 'form-newsletter', 'class'=>'form-inline', 'action' => '\App\maguttiCms\Website\Controllers\APIController@subscribeNewsletter')) }}
<div class="input-group">
    <input class="form-control"
       type="text"
       id="email"
       name="email"
       placeholder="{!! trans('website.newsletters_placeholder') !!} ">

    <div class="input-group-btn">
        <button id="btn-newsletter-subscribe" class="btn btn-newsletter btn-full" type="button"> {{  trans('website.send')}}</button>
    </div>
</div>
{{ Form::close() }}
