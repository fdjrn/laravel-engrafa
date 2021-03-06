<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark" width="300px">
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
    <div class="tab-content" id="notif">

        <notification-component :user="{{auth()->user()}}"></notification-component>

        <user-bookmark :user="{{ Auth::user() }}"></user-bookmark>

        <div class=" tab-pane" id="control-sidebar-recent-tab">
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
{{--
<script>
    import BookmarkComponent from "../../../assets/js/components/bookmark/BookmarkComponent";

    export default {
        components: {BookmarkComponent}
    }
</script>--}}
