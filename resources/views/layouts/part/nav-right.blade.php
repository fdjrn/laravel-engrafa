<!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- sidebar: style can be found in sidebar.less -->
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <!-- <img src="{{ asset('theme/AdminLTE/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image"> -->
          <div style="font-size: 36px; color:white;">
            <i class="fa fa-user fa-10x"></i>
          </div>
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
        </div>
      </div>

      <div class="tab-content">
        <div class="tab-pane" id="control-sidebar-notification-tab">
          <h3 class="control-sidebar-heading">
            <i class="fa fa-bell fa-fw"></i>
            <span>&nbsp;</span>
            <span> Notification</span>
            <span class="pull-right">
              <i class="fa fa-book fa-fw"></i>
              <i class="fa fa-remove fa-fw"></i>
            </span>
          </h3>
          
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-user bg-red"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">
                    User 1
                    <div class="pull-right">
                      <span>1h</span>
                      <span>&nbsp;</span>
                      <i class="label bg-yellow">3</i>
                    </div>
                  </h4>
                  <p>How About App</p>
                </div>
              </a>
            </li>

            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-calendar bg-blue"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">
                    My Calendar
                    <div class="pull-right">
                      <span>2d</span>
                      <span>&nbsp;</span>
                      <i class="label bg-yellow">1</i>
                    </div>
                  </h4>
                  <p>For Event</p>
                </div>
              </a>
            </li>

            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-cube bg-green"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">
                    Dev Team
                    <div class="pull-right">
                      <span>5d</span>
                      <span>&nbsp;</span>
                      <i class="label bg-yellow">1</i>
                    </div>
                  </h4>
                  <p>For Event</p>
                </div>
              </a>
            </li>

          </ul>
        </div>
        <!-- tab-pane -->

        <div class="tab-pane" id="control-sidebar-bookmark-tab">
          <h3 class="control-sidebar-heading">
            <i class="fa fa-bookmark fa-fw"></i>
            <span>&nbsp;</span>
            <span>Bookmark</span>
            <span class="pull-right">
              <i class="label bg-yellow">4</i>
              <i class="fa fa-remove fa-fw"></i>
            </span>
          </h3>

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
          
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:void(0)" class="text-with">
                <i class="menu-icon fa fa-file-text bg-red"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">
                    SOP 01
                    <div class="pull-right">
                      <span>1h</span>
                    </div>
                  </h4>
                  <p>Ways of working</p>
                </div>
              </a>
            </li>

            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-file-text bg-blue"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">
                    SOP 2
                    <div class="pull-right">
                      <span>1h</span>
                    </div>
                  </h4>
                  <p>Ways of working</p>
                </div>
              </a>
            </li>

            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-folder bg-green"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">
                    Folder 01
                    <div class="pull-right">
                      <span>1h</span>
                    </div>
                  </h4>
                  <p></p>
                </div>
              </a>
            </li>

            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-files-o bg-yellow"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">
                    Survey 01
                    <div class="pull-right">
                      <span>1h</span>
                    </div>
                  </h4>
                  <p></p>
                </div>
              </a>
            </li>

          </ul>
        </div>
        <!-- tab-pane -->

        <div class="tab-pane" id="control-sidebar-recent-tab">
          <h3 class="control-sidebar-heading">
            <i class="fa fa-clock fa-fw"></i>
            <span>&nbsp;</span>
            <span> Recent</span>
            <span class="pull-right">
              <small class="label bg-yellow">5</small>
              <i class="fa fa-remove fa-fw"></i>
            </span>
          </h3>
          
          <ul class="control-sidebar-menu">
            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-cube bg-red"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">
                    Dev Team
                    <div class="pull-right">
                      <span>2h</span>
                    </div>
                  </h4>
                  <p>Diagram One</p>
                </div>
              </a>
            </li>

            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-file bg-blue"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">
                    Doc 001
                    <div class="pull-right">
                      <span>2d</span>
                    </div>
                  </h4>
                  <p>Folder FIle/Doc 001</p>
                </div>
              </a>
            </li>

            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-commenting bg-green"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">
                    Dev Team
                    <div class="pull-right">
                      <span>2d</span>
                    </div>
                  </h4>
                  <p>For Event</p>
                </div>
              </a>
            </li>

            <li>
              <a href="javascript:void(0)">
                <i class="menu-icon fa fa-calendar-check-o bg-green"></i>
                <div class="menu-info">
                  <h4 class="control-sidebar-subheading">
                    Schedule
                    <div class="pull-right">
                      <span>5d</span>
                    </div>
                  </h4>
                  <p>2-3 13:00 - 15:00</p>
                </div>
              </a>
            </li>

          </ul>
        </div>
        <!-- tab-pane -->
      </div>
      <!-- tab-content -->


  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>