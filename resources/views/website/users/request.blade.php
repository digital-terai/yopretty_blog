@extends('website.app')
@section('content')
<section data-role="info-block">
    <div id="page_section">
        <div class="container">
            <div class="row mb0">
                @include('website.partials.pagetitle')
                <div class="col-sm-12 mb0 text-center">{!! $article->description !!}</div>
            </div><!-- /row -->
        </div> <!-- /container -->
    </div>
</section>
@endsection
