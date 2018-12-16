<!-- BEGIN GLOBAL MANDATORY STYLES -->

<!-- iTAX FONT ICON -->
@section('global-mandatory-styles')
@show()
<!-- END GLOBAL MANDATORY STYLES -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
@section('page-level-plugin-styles')
@show()
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN THEME GLOBAL STYLES -->
@section('theme-global-styles')
@show()
<!-- END THEME GLOBAL STYLES -->

<!-- BEGIN PAGE LEVEL STYLES -->
@section('page-level-styles')
@show()
<!-- END PAGE LEVEL STYLES -->

<!-- RESPONSIVE STYLES -->
<!-- <link href="/templates/itax/css/responsive.css" rel="stylesheet"
        type="text/css" /> -->
<!-- END THEME LAYOUT STYLES -->

<!-- BEGIN THEME LAYOUT STYLES -->
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE/dist/css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE/bower_components/morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE/bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- SELECT2 -->
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE/bower_components/select2/dist/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('colorselector/lib/bootstrap-colorselector-0.2.0/css/bootstrap-colorselector.css')}}" />
  <!-- Theme style -->
  <link rel="stylesheet" href=" {{ asset('theme/AdminLTE/plugins/pace/pace.min.css')}}">
  <link rel="stylesheet" href=" {{ asset('theme/AdminLTE/dist/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href=" {{ asset('theme/AdminLTE/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <link rel="stylesheet" href=" {{ asset('theme/AdminLTE/plugins/sweetalert/sweetalert.css')}}">
  <link rel="stylesheet" href=" {{ asset('css/main.css')}}">

<!-- SMARTGOV & RESPONSIVE STYLES -->
@section('theme-layout-styles')
@show()
<!-- END THEME LAYOUT STYLES -->
