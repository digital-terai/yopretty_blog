@inject('hpslider','App\HpSlider')
<!-- Carousel  ================================================== -->
<section id="carousel" class="owl-carousel">
	@foreach ($hpslider->active()->get() as  $index => $slider)
        <div class="slide">
			<img src="{{ ImgHelper::get_cached($slider->image, ['w' => 1920, 'h' => 600, 'c' => 'cover', 'q' => 70]) }}" alt="">
            <div class="caption">
				<h2>{{ $slider->title }}</h2>
                <p>{{ $slider->description }}</p>
            </div>
        </div>
    @endforeach
</section>

@section('footerjs')
	@parent
	<script type="text/javascript">
		$('#carousel').owlCarousel({
			items: 1,
			loop: true,
		});
	</script>
@endsection
