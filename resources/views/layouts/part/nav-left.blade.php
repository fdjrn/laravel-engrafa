<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <!-- <img src="{{ asset('theme/AdminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image"> -->
          <div style="font-size: 36px; color:grey;">
            <i class="fa fa-user fa-10x"></i>
          </div>
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->

      <ul class="sidebar-menu" data-widget="tree">        
        <li class="treeview">  
            <a href="#control-sidebar-notification-tab" data-toggle="tab">
              <div data-toggle="control-sidebar">
                <i class="fa fa-bell"></i>
                <span>&nbsp;</span>
                <span>Notifications</span>
                <span class="pull-right-container">
                  <small class="label pull-right bg-green">5</small>
                </span>
              </div>
            </a>
        </li>
        <li>
          <a href="#control-sidebar-recent-tab" data-toggle="tab">
            <div data-toggle="control-sidebar">
              <i class="fa fa-clock-o"></i> 
              <span>&nbsp;</span>
              <span>Recent</span>
              <span class="pull-right-container">
                <small class="label pull-right bg-green">5</small>
              </span>
          </div>
          </a>
        </li>
        <li class="treeview">
          <a href="#control-sidebar-bookmark-tab" data-toggle="tab">
            <div data-toggle="control-sidebar">
              <i class="fa fa-bookmark"></i>
              <span>&nbsp;</span>
              <span>Bookmark</span>
              <span class="pull-right-container">
                <small class="label pull-right bg-green">2</small>
              </span>
            </div> 
          </a>
        </li>
        <!-- search form -->
	      <form action="#" method="get" class="sidebar-form">
	        <div class="input-group">
	          <input type="text" name="q" class="form-control" placeholder="Search...">
	          <span class="input-group-btn">
	                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
	                </button>
	              </span>
	        </div>
	      </form>
        <!-- @foreach($roleMenus as $menu)
        <li class="treeview">
          <a href="{{ $menu->url }}">
            <i class="fa {{$menu->icon}}"></i>
            <span>{{$menu->name}}</span>
          </a>
        </li>
        @endforeach -->
        @each('layouts.part.partial-menu',$roleMenus,'menu','layouts.part.partial-menu','mnsurvey')
        <li class="treeview">
          <a href="{{ url('chat') }}">
            <i class="fa fa-comment"></i> <span>Chat</span>
          </a>
        </li>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                  <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                  </button>
                </span>
          </div>
        </form>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>User 1</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-user"></i>
            <span>User 2</span>
          </a>
        </li>
        <li class="header">
    		<span>Setting</span>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-info-circle"></i>
            <span>Information</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  @include('layouts.part.nav-right')