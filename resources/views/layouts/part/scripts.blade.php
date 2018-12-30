<!--[if lt IE 9]>
<script src="/theme/metronic4/global/plugins/respond.min.js"></script>
<script src="/theme/metronic4/global/plugins/excanvas.min.js"></script>
<script src="/theme/metronic4/global/plugins/ie8.fix.min.js"></script>
<![endif]-->

<!-- BEGIN CORE PLUGINS -->

<!-- jQuery 3 -->
<script src="{{ asset('theme/AdminLTE/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('theme/AdminLTE/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('theme/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>

<!-- Morris.js charts -->
<script src="{{ asset('theme/AdminLTE/bower_components/raphael/raphael.min.js')}}"></script>
{{-- <script src="{{ asset('theme/AdminLTE/bower_components/morris.js/morris.min.js')}}"></script> --}}

<!-- Sparkline -->
<script src="{{ asset('theme/AdminLTE/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>

<!-- jQuery Knob Chart -->
<script src="{{ asset('theme/AdminLTE/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{ asset('theme/AdminLTE/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{ asset('theme/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{ asset('theme/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('theme/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{ asset('theme/AdminLTE/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset('theme/AdminLTE/bower_components/fastclick/lib/fastclick.js')}}"></script>
<script src="{{ asset('theme/AdminLTE/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('theme/AdminLTE/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('theme/AdminLTE/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('theme/AdminLTE/dist/js/pages/dashboard.js')}}"></script> --}}
<script src="{{ asset('colorselector/lib/bootstrap-colorselector-0.2.0/js/bootstrap-colorselector.js')}}"></script>
<script src="{{ asset('theme/AdminLTE/bower_components/chart.js2/Chart.min.js')}}"></script>
<script src="{{ asset('theme/AdminLTE/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('theme/AdminLTE/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
{{ Html::script( asset('js/sweetalert2.all.js')) }}
<script src="{{ asset('theme/AdminLTE/plugins/validate/jquery.validate.min.js')}}"></script>
<script src="{{ asset('theme/AdminLTE/plugins/validate/additional-methods.min.js')}}"></script>
<script src="{{ asset('theme/AdminLTE/plugins/pace/pace.min.js')}}""></script>
<script src="{{ asset('js/pages/main.js')}}"></script>
<script src="{{ asset('js/app.js')}}"></script>

<script>
    $('.colorselector').colorselector();
</script>
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  });

    var base_url = {!! json_encode(url('/')) !!};
    var supported_type = 'application/pdf,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    var url = $(location).attr('href');
    var aurl = url.split("/").splice(0, 4).join("/");
    var burl = url.split("/").splice(0, 5).join("/");

    $('.carousel.carousel-multi .item').each(function () {
      var next = $(this).next();
      if (!next.length) {
        next = $(this).siblings(':first');
      }
      next.children(':first-child').clone().attr("aria-hidden", "true").appendTo($(this));

      if (next.next().length > 0) {
        next.next().children(':first-child').clone().attr("aria-hidden", "true").appendTo($(this));
      }
      else {
        $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
      }
    });

    // for sidebar menu entirely but not cover treeview
    $('ul.sidebar-menu a').filter(function() {
      if (this.href == url){
        return true;
      }else if(this.href+"#" == url){
        return true;
      }else if(this.href == aurl){
        return true;
      }else if(this.href == burl){
        return true;
      }
    }).parent().addClass('active');

    var menu_status = false;
    $('ul.inside-submenu a').filter(function() {
      if (this.href == url){
        menu_status = true;
        return true;
      }else if(this.href+"#" == url && menu_status == false){
        menu_status = true;
        return true;
      }
    }).parent().addClass('active');

    if(menu_status == false){
      $('ul.inside-submenu a').filter(function() {
        if(this.href == aurl && menu_status == false){
            menu_status = true;
            return true;
        }else if(this.href == burl && menu_status == false){
            menu_status = true;
            return true;
        }
      }).parent().addClass('active');
    }

    // for treeview
    $('ul.treeview-menu a').filter(function() {
      if (this.href == url){
        return true;
      }else if(this.href+"#" == url){
        return true;
      }
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active'); 
</script>


@php
    $js_files = Request::segment(2).'.js';
    $js_exists = file_exists(base_path() . '/public/js/pages/' . $js_files);

    $suburl1 = Request::segment(1);
    $js_files2 = Request::segment(2).'.js';
    $js_exists2 = file_exists(base_path() . '/public/js/pages/'.$suburl1.'/'. $js_files);
@endphp

@if (!empty($js_files) && $js_exists)
    <script src="{{ asset ('js/pages/'.$js_files) }}"></script>
@else
    @if (!empty($js_files2) && $js_exists2)
    	<script src="{{ asset ('js/pages/'.$suburl1.'/'. $js_files) }}"></script>
    @endif
@endif
<!-- AdminLTE for demo purposes -->
<!-- <script src="/theme/AdminLTE/dist/js/demo.js"></script> -->
@section('core-plugins')
@show()
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
@section('page-level-plugins')
@show()
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN CUSTOM PAGE LEVEL PLUGINS -->
@section('custom-page-level-plugins')
@show()
<!-- END CUSTOM PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL SCRIPTS -->
@section('theme-global-scripts')
@show()
<!-- END THEME GLOBAL SCRIPTS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
@section('page-level-scripts')
@show()
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN THEME LAYOUT SCRIPTS -->

@section('theme-layout-scripts')
@show()
<!-- END THEME LAYOUT SCRIPTS -->

<!-- BEGIN PAGE SPECIFIC SCRIPTS -->
@section('page-specific-scripts')
@show()
<!-- END PAGE SPECIFIC SCRIPTS -->
