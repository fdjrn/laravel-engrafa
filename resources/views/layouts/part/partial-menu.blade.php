@if (!empty($menu->role))

	@if ((count($menu->children) > 0))
		<li class="treeview">
		  <a id="{{$menu->id_url}}" href="{{$menu->url}}">
		    <i class="fa {{$menu->icon}}"></i>
		    <span>{{$menu->name}}</span>
		    <span class="pull-right-container">
	          <i class="fa fa-angle-left pull-right"></i>
	        </span>
		  </a>
	@else
		@if ($menu->id_url == "mn_create_new_team")
			<li>
				<a id="{{$menu->id_url}}" href="{{$menu->url}}">
					<i class="fa {{$menu->icon}}"></i>
					<span>{{$menu->name}}</span>
				</a>
			@foreach($mnsurvey as $survey)
			<li style="background-color: #2c3b41;">
				<a href="{{route('survey',['id'=> $survey->id])}}">
					<span>&nbsp;&nbsp;&nbsp;</span><i class="fa fa-file-text-o"></i><span>{{$survey->name}}</span>
				</a>
			@endforeach
		@elseif ($menu->id_url == "mn_survey")
			<li>
				<a id="{{$menu->id_url}}" href="{{$menu->url}}">
					<i class="fa {{$menu->icon}}"></i>
					<span>{{$menu->name}}</span>
				</a>
			@foreach($mnsurvey as $survey)
			<li style="background-color: #2c3b41;">
				<a href="/survey/{{$survey->id}}">
					<span>&nbsp;&nbsp;&nbsp;</span><i class="fa fa-file-text-o"></i><span>{{$survey->name}}</span>
				</a>
			@endforeach
		@else
		<li class="">
			<a id="{{$menu->id_url}}" href="{{$menu->url}}">
				<i class="fa {{$menu->icon}}"></i>
				<span>{{$menu->name}}</span>
			</a>
		@endif
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