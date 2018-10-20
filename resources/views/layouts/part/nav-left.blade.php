<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ asset('theme/AdminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>User</p>
        </div>
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">        
        <li class="treeview">
          <a href="{{ url('dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
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
          <a href="#">
            <i class="fa fa-user-plus"></i>
            <span>Invite People</span>
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
        <li class="treeview">
          <a href="{{ url('index')}}">
            <i class="fa fa-folder-open"></i>
            <span>Index</span>
          </a>
        </li>
        <li class="treeview">
          <a href="{{route('survey')}}">
            <i class="fa fa-files-o"></i>
            <span>Survey</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-plus"></i>
            <span>Create New Team</span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-calendar"></i>
            <span>Calendar</span>
          </a>
        </li>
        <li class="header">
        <span></span>
        </li>
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
        <li class="treeview">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Setting</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  @include('layouts.part.nav-right')