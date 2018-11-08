@if (!empty($menu->role))

	@if ((count($menu->children) > 0))
		<li class="treeview">
		  <a href="{{ $menu->url }}">
		    <i class="fa {{$menu->icon}}"></i>
		    <span>{{$menu->name}}</span>
		    <span class="pull-right-container">
	          <i class="fa fa-angle-left pull-right"></i>
	        </span>
		  </a>
	@else
		<li class="">
			<a href="{{$menu->url}}">
				<i class="fa {{$menu->icon}}"></i>
				<span>{{$menu->name}}</span>
			</a>
	@endif

		@if (count($menu->children) > 0)

			<ul class="treeview-menu">

			@foreach($menu->children as $menu)

				@include('layouts.part.partial-menu', $menu)

			@endforeach

			</ul>

		@endif

	</li>
@endif