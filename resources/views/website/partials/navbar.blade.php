<!-- header -->
<nav class="navbar navbar-fixed-top compensate-for-scrollbar" role="navigation">
	<!-- Topbar -->
	<!-- End Topbar -->
	<div  class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
				<span class="sr-only">Toggle navigation</span>
				{{icon('bars', 'fa-lg')}}
			</button>
			<a class="call-action" href="tel:{{ config('maguttiCms.website.option.app.phone') }}">
				{{icon('phone', 'fa-lg')}}
			</a>
			<a class="navbar-brand" href="{{url_locale('/') }}">
				<img src="{{asset('website/images/logo.png')}}" alt="{{ config('maguttiCms.website.option.app.name') }}">
			</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->

		<div class="collapse navbar-collapse navbar-responsive-collapse">
			<ul class="nav navbar-nav navbar-right">
				{{-- pages --}}

                <?php
                $menu = App\Article::menuItems()->get();
                $top = $menu->where('parent_id',0);
                ?>
				@foreach( $top as $index => $page)
					<?php
						if ($page->slug == 'home')
							$page_link = '/';
						else if ($page->link)
							$page_link = $page->link;
						else
						$page_link = $page->getPermalink();
						$page_title = ($page->menu_title) ? $page->menu_title : $page->title;
                   		$children = $menu->where('parent_id',$page->id) ;

                    ?>

						@if($children->count()>0)
						<li class="dropdown {{ (!empty($article) && ($article->id == $page->id || $article->parent_id == $page->id)) ? 'active' : '' }}">
							<a href="#" class=" nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ $page_title }} <span class="caret"></span></a>
							<ul class="dropdown-menu">

								@foreach ($children as $index => $child)
									<?php
										if ($child->slug == 'home')
											$child_link = '/';
										else if ($child->link)
											$child_link = $child->link;
										else
											$child_link = $child->getPermalink();
										$child_title = ( $child->menu_title ) ? $child->menu_title : $child->title;
									?>
									<li class="{{ (!empty($article) && $child->id == $article->id) ? 'active' : '' }}">
										<a href="{{ $child_link }}">{{ $child_title }}</a>
									</li>
								@endforeach
							</ul>
						</li>
					@else
						<li class="{{ (!empty($article) && $article->id == $page->id) ? 'active' : '' }}">
							<a href="{{ $page_link }}">{{ $page_title }}</a>
						</li>
					@endif

				@endforeach
				{{-- modal search --}}
				<li class="" data-toggle="modal"
					data-target="#fsModalSearch">
					<a href="#">{{icon('search', 'fa-lg')}}</a>
				</li>
				{{-- login --}}
				@if (!Auth::guard()->check())
					<li><a href="{{url_locale('users/login')}}">Login</a></li>
				@else
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							{{Auth::guard()->user()->name}}
							{{HtmlHelper::createFAIcon('caret-down', 'ml5')}}
						</a>
						<ul class="dropdown-menu" role="menu">
							<li>
								<a href="{{url_locale('users/dashboard')}}">
									{{icon('list')}}Dashboard</a>
							</li>
							<li class="dropdown">
								<a href="{{url_locale('users/profile')}}">
									{{icon('user')}}Profile</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="{{url_locale('users/logout')}}">
									{{icon('sign-out')}}Logout</a>
							</li>
						</ul>
					</li>
				@endif

				@if (StoreHelper::isStoreEnabled())
					@php $count = StoreHelper::getCartItemCount() @endphp
					<li>
						<a href="{{url_locale('cart')}}">
							{{icon(config('maguttiCms.store.cart.icon'), 'cart-icon')}}
							<span class="cart-count">{{($count)? $count: ''}}</span>
						</a>
					</li>
				@endif

				{{-- languages --}}
				@if (sizeOf(LaravelLocalization::getSupportedLocales()) > 1)
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
							<img class="flag" src="{{asset('website/images/flags/'.LaravelLocalization::getCurrentLocale().'.png')}}" alt="{{LaravelLocalization::getCurrentLocale()}} language"> {{HtmlHelper::createFAIcon('caret-down', 'ml5')}}
						</a>
						<ul class="dropdown-menu" role="menu">

							@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

									@if(LaravelLocalization::getCurrentLocale() != $localeCode)
										<li>
											@if (isset($article) && !$article->ignore_slug_translation)
												@php $article_locale = (isset($locale_article)) ? $locale_article : $article @endphp
												<a href="{{LaravelLocalization::getLocalizedURL($localeCode, $article_locale->getPermalink($localeCode)) }}">
													<img class="flag mr10" src="{{asset('website/images/flags/'.$localeCode.'.png')}}" alt="{{LaravelLocalization::getCurrentLocale()}} language"> {{ $properties['native'] }}
												</a>
											@else
												<a href="{{LaravelLocalization::getLocalizedURL($localeCode) }}">
													<img class="flag mr10" src="{{asset('website/images/flags/'.$localeCode.'.png')}}" alt="{{LaravelLocalization::getCurrentLocale()}} language"> {{ $properties['native'] }}
												</a>
											@endif
										</li>
									@endif

							@endforeach
						</ul>
					</li>
				@endif
			</ul>
		</div><!--/navbar-collapse-->
	</div>
</nav>