<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Tata Kelola IT</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @include('layouts.part.styles')

  @section('custom-scripts')
  @show()
    
  @include('general.favicon')

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b></b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Tata Kelola IT</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      @include('layouts.part.nav-top')
    </nav>
  </header>
  
  @include('layouts.part.nav-left')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      @section('page-header') @show()
      <ol class="breadcrumb">
        <!-- BEGIN PAGE BREADCRUMBS -->
        @section('page-breadcrumb') @show()
        <!-- END PAGE BREADCRUMBS -->
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      @section('body-inner-content') @show()
      @include('survey.survey-create-modal')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2018- <a href="#">Engrafa</a>.</strong> All rights
    reserved.
  </footer>

  
</div>
<!-- ./wrapper -->
@section('body-modals')
@show()
<!-- <script src="{{ asset('js/app.js')}}"></script> -->
</body>
</html>

@include('layouts.part.scripts')
