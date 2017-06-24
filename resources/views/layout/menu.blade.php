<!-- Menu -->
<div class="span2 col main-left hide hidden-phone menu-large">
	<div class="rrow scroll-y-left">
		<div class="iScrollWrapper">
			<ul>
				@foreach($menus as $menu)
					@if(count($menu['children']))
						<?php
							$current=false;
							foreach($menu['children'] as $menu_child){
						 	 	if($menu_child['link'] != '' && Request::is($menu_child['link'].'*') ){
						 	 		$current=true;
						 	 	}
						 	}
						?>
						<li class="hasSubmenu2 {{$current?'currentScroll':''}}">
							<a data-toggle="collapse"  href="#{{ Str::slug($menu['name']).$menu['id'] }}"><i class="{{ $menu['icon_class'] }} menu"></i><span>{{ $menu['name'] }}</span></a>
							<ul class="{{$current?'in':''}} collapse" id="{{ Str::slug($menu['name']).$menu['id'] }}">
								@foreach($menu['children'] as $menu_child)
									<li class="{{ ( $menu_child['link'] != '' && Request::is($menu_child['link'].'*') )?'active':'' }}"><a href="{{ URL.'/'.$menu_child['link'] }}"><i class="{{ $menu_child['icon_class'] }} menu"></i><span>{{ $menu_child['name'] }}</span></a></li>
								@endforeach
							</ul>
						</li>
					@else
						<li><a href="{{URL.'/'.$menu['url']}}"><i class="{{ $menu['icon_class'] }} menu"></i><span>{{ $menu['name'] }}</span></a></li>
					@endif
				@endforeach
			</ul>
		</div>
		<span class="navarrow hide">
		<span><i class="fa fa-university menu"></i></span>
		</span>
	</div>
</div>

<!-- End Menu -->