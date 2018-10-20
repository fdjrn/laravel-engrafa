@extends('layouts.template')

@section('doc_title', isset($documentTitle) ? $documentTitle : 'Document Title')

@section('doc_desc', isset($documentDescription) ? $documentDescription : 'Document Description')

@section('global-mandatory-styles')
@stop

@section('page-level-plugin-styles')
@stop

@section('theme-global-styles')
@stop

@section('page-level-styles')
<!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE//bower_components/select2/dist/css/select2.min.css')}}">
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
@stop

@section('page-header') 
  <h1>Chat</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="{{ url('chat')}}"><i class="fa fa-comment"></i> Chat</a></li>
@stop


@section('body-inner-content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-primary direct-chat direct-chat-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Some Text</h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <!-- Conversations are loaded here -->
        <div class="direct-chat-messages">
          <!-- Message. Default to the left -->
          <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-left">Alexander Pierce</span>
              <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
            </div>
            <!-- /.direct-chat-info -->
            <span class="direct-chat-img bg-blue">
                <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
            </span>
            <div class="direct-chat-text">
              Is this template really for free? That's unbelievable!
            </div>
            <!-- /.direct-chat-text -->
          </div>
          <!-- /.direct-chat-msg -->

          <!-- Message to the right -->
          <div class="direct-chat-msg right">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-right">Sarah Bullock</span>
              <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
            </div>
            <!-- /.direct-chat-info -->
            <span class="direct-chat-img bg-blue">
                <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
            </span>
            <div class="direct-chat-text">
              You better believe it!
            </div>
            <!-- /.direct-chat-text -->
          </div>
          <!-- /.direct-chat-msg -->

          <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-left">Alexander Pierce</span>
              <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
            </div>
            <!-- /.direct-chat-info -->
            <span class="direct-chat-img bg-blue">
                <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
            </span>
            <div class="direct-chat-text">
              Is this template really for free? That's unbelievable!
            </div>
            <!-- /.direct-chat-text -->
          </div>
          <!-- /.direct-chat-msg -->

          <!-- Message to the right -->
          <div class="direct-chat-msg right">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-right">Sarah Bullock</span>
              <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
            </div>
            <!-- /.direct-chat-info -->
            <span class="direct-chat-img bg-blue">
                <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
            </span>
            <div class="direct-chat-text">
              You better believe it!
            </div>
            <!-- /.direct-chat-text -->
          </div>
          <!-- /.direct-chat-msg -->

          <div class="direct-chat-msg">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-left">Alexander Pierce</span>
              <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
            </div>
            <!-- /.direct-chat-info -->
            <span class="direct-chat-img bg-blue">
                <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
            </span>
            <div class="direct-chat-text">
              Is this template really for free? That's unbelievable!
            </div>
            <!-- /.direct-chat-text -->
          </div>
          <!-- /.direct-chat-msg -->

          <!-- Message to the right -->
          <div class="direct-chat-msg right">
            <div class="direct-chat-info clearfix">
              <span class="direct-chat-name pull-right">Sarah Bullock</span>
              <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
            </div>
            <!-- /.direct-chat-info -->
            <span class="direct-chat-img bg-blue">
                <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
            </span>
            <div class="direct-chat-text">
              You better believe it!
            </div>
            <!-- /.direct-chat-text -->
          </div>
          <!-- /.direct-chat-msg -->
        </div>
        <!--/.direct-chat-messages-->

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <form action="#" method="post">
          <div class="input-group">
                <span class="input-group-btn">
                  <button type="button" class="btn btn-primary btn-flat">
                    <i class="fa fa-plus"></i>
                  </button>
                  <button type="button" class="btn btn-primary btn-flat">
                    <i class="fa fa-smile-o"></i>
                  </button>
                  <button type="button" class="btn btn-primary btn-flat">
                    <i class="fa fa-microphone"></i>
                  </button>
                </span>
                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
          </div>
        </form>
      </div>
      <!-- /.box-footer-->
    </div>
    <!--/.direct-chat -->
  </div>
  <!-- col-md-9 -->

  <div class="col-md-4">
    <!-- PRODUCT LIST -->
    <div class="box box-primary">
      <div class="box-header with-border">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                  <i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <ul class="products-list product-list-in-box">
          <li class="item">
            <div class="product-img">
              <span class="direct-chat-img bg-blue">
                <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
              </span>
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">Pengguna 1
              </a>
              <span class="pull-right">
                <small class="label ">
                  <i class="fa fa-circle text-success"></i>
                </small>
                <small class="label text-black">
                  <i class="fa fa-phone"></i>
                </small>
                <small class="label bg-yellow">2</small>
              </span>
              <span class="product-description">
                some text
              </span>
            </div>
          </li>
          <!-- /.item -->
          <li class="item">
            <div class="product-img">
               <span class="direct-chat-img bg-blue">
                <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
            </span>
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">Pengguna 2
              </a>
              <span class="pull-right">
                <small class="label ">
                  <i class="fa fa-circle text-success"></i>
                </small>
                <small class="label text-black">
                  <i class="fa fa-phone"></i>
                </small>
                <small class="label bg-yellow">2</small>
              </span>
              <span class="product-description">
                some text
              </span>
            </div>
          </li>
          <!-- /.item -->
          <li class="item">
            <div class="product-img">
               <span class="direct-chat-img bg-blue">
                <i class="fa fa-user" style="padding: 13px 15px;"></i><!-- /.direct-chat-img -->
            </span>
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">Pengguna 3
              </a>
              <span class="pull-right">
                <small class="label ">
                  <i class="fa fa-circle text-success"></i>
                </small>
                <small class="label text-black">
                  <i class="fa fa-phone"></i>
                </small>
                <small class="label bg-yellow">2</small>
              </span>
              <span class="product-description">
                some text
              </span>
            </div>
          </li>
          <!-- /.item -->
          <li class="item">
            <div class="product-img">
              <span class="direct-chat-img bg-blue">
                <i class="fa fa-users" style="padding: 13px 12px;"></i><!-- /.direct-chat-img -->
              </span>
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">Group 01
              </a>
              <span class="pull-right">
                <small class="label">
                  <span class="text-success">2 Pengguna</span>
                  <i class="fa fa-circle text-success"></i>
                </small>
                <small class="label text-black">
                  <i class="fa fa-phone"></i>
                </small>
                <small class="label bg-yellow">2</small>
              </span>
              <span class="product-description">
                19 Pengguna
              </span>
            </div>
          </li>
          <!-- /.item -->
          <li class="item">
            <div class="product-img">
               <span class="direct-chat-img bg-blue">
                <i class="fa fa-users" style="padding: 13px 12px;"></i><!-- /.direct-chat-img -->
            </span>
            </div>
            <div class="product-info">
              <a href="javascript:void(0)" class="product-title">Group 02
              </a>
              <span class="pull-right">
                <small class="label">
                  <span class="text-success">9 Pengguna</span>
                  <i class="fa fa-circle text-success"></i>
                </small>
                <small class="label text-black">
                  <i class="fa fa-phone"></i>
                </small>
                <small class="label bg-yellow">2</small>
              </span>
              <span class="product-description">
                20 Pengguna
              </span>
            </div>
          </li>
          <!-- /.item -->
        </ul>
      </div>
      <!-- /.box-body -->
      <div class="box-footer text-center">
        <a class="btn btn-app btn-primary" data-toggle="modal" href="#invite">
          <i class="fa fa-user-plus"></i> Undang
        </a>
        <a class="btn btn-app btn-primary" data-toggle="modal" href="#invite-group">
          <i class="fa fa-users"></i> Buat Grup Baru
        </a>
      </div>
      <!-- /.box-footer -->
    </div>
    <!-- /.box -->
  </div>
  <!-- col-md-3 -->
</div>
@stop

@section('body-modals')
<div class="modal fade" id="invite">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
         <h4><i class="fa fa-user fa-fw"></i>
        </h4>
      </div>
      <form class="form-horizontal">
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-3">Multiple</label>
            <div class="col-sm-9">
              <select class="form-control select2" multiple="multiple" data-placeholder="Users"
                      style="width: 100%;">
                <option>User 1</option>
                <option>User 2</option>
                <option>User 3</option>
                <option>User 4</option>
                <option>User 5</option>
              </select>
            </div>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label for="email" class="control-label col-sm-3">Email</label>
            <div class="col-sm-9">
              <input type="email" class="form-control" id="email" placeholder="Email">
            </div>
          </div>
          <!-- form-group -->
        </div>  
        <div class="modal-footer justify-content-start" style="text-align:center;">
          <button type="submit" class="btn btn-primary pull-right">Invite <i class="fa fa-fw fa-user-plus"></i></button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="invite-group">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>

          <h4>
          <a href="" data-toggle="tooltip" title="Upload Group Photo">
            <i class="fa fa-users fa-fw"></i>
          </a>
          Group Name
          </h4>
      </div>
      <form class="form-horizontal">
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-3">Add User</label>
            <div class="col-sm-9">
              <select class="form-control select2" multiple="multiple" data-placeholder="User"
                      style="width: 100%;">
                <option>User 1</option>
                <option>User 2</option>
                <option>User 3</option>
                <option>User 4</option>
                <option>User 5</option>
              </select>
            </div>
          </div>
          <!-- /.form-group -->
        </div>
        <div class="modal-footer justify-content-start" style="text-align:center;">
          <button type="submit" class="btn btn-primary pull-right">Create Group <i class="fa fa-fw fa-users"></i></button>
        </div>
      </div>
    </form>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
<!-- select2 -->
<script src="{{ asset('theme/AdminLTE/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>
<!-- select2 -->
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop