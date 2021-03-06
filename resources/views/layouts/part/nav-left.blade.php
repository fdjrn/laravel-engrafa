<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar" >
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

        <ul class="sidebar-menu" data-widget="tree" id="notifToogle" >
            <notification-toogle-component :user="{{auth()->user()}}"></notification-toogle-component>

            <li data-toggle="control-sidebar">
                <a href="#control-sidebar-recent-tab" data-toggle="tab">
                    <i class="fa fa-clock-o"></i>
                    <span>Recent</span>
                    <span class="pull-right-container">
              <small class="label pull-right bg-green">5</small>
            </span>
                </a>
            </li>

            <user-bookmark-toggle :user="{{auth()->user()}}"></user-bookmark-toggle>

            <!-- search form -->
            <div class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search..." id="textSearch">
                    <span class="input-group-btn">
                  <button type="button" name="search" id="search-btn" class="btn btn-flat" onClick="searchBtn()"><i class="fa fa-search"></i>
                  </button>
                </span>
                </div>
            </div>

            <div id="searchData" class="sidebar-menu">
                <!-- <li class="treeview">
                  <a href="#">
                      <i class=""></i>
                      <span>test</span>
                  </a>
                </li> -->
            </div>

            <li class="header">
                <span>Menu</span>
            </li>
        <!-- @foreach($roleMenus as $menu)
            <li class="treeview">
              <a href="{{ $menu->url }}">
            <i class="fa {{$menu->icon}}"></i>
            <span>{{$menu->name}}</span>
          </a>
        </li>
        @endforeach -->
            @each('layouts.part.partial-menu',$roleMenus,'menu','layouts.part.partial-menu','mnsurvey')
            <li>
                <a href="{{ url('chat') }}">
                    <i class="fa fa-comment"></i> <span>Chat</span>
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