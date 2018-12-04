@extends('layouts.template')

@section('doc_title', isset($documentTitle) ? $documentTitle : 'Document Title')

@section('doc_desc', isset($documentDescription) ? $documentDescription : 'Document Description')

@section('global-mandatory-styles')
@stop

@section('page-level-plugin-styles')
<!-- fullCalendar -->
  {{Html::css('theme/AdminLTE/bower_components/fullcalendar/dist/fullcalendar.min.css')}}
  {{Html::css('theme/AdminLTE/bower_components/fullcalendar/dist/fullcalendar.print.min.css')}}
<!-- Bootstrap time Picker -->
  {{Html::css('theme/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.css')}}
<!-- bootstrap datepicker -->
  {{Html::css('theme/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}
@stop

@section('theme-global-styles')
@stop

@section('page-level-styles')
<style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }
  </style>
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
@stop

@section('page-header') 
  <h1>Schedule</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="{{route('calendar')}}"><i class="fa fa-calendar"></i> Schedule</a></li>
@stop


@section('body-inner-content')
<div class="row">
  <div class="col-md-8">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Calendar
          <span class="pull-right">
            <a href="#new-schedule" id="add-schedule">
              <i class="fa fa-plus"></i>
            </a>
            <i class="fa fa-fw"></i>
            <a href="">
              <i class="fa fa-bars"></i>
            </a>
            <i class="fa fa-fw"></i>
          </span>
        </h4>
      </div>
      <div class="box-body">
        <div id="calendar"></div>
      </div>
      <div class="box-footer">
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Schedule</h4>
      </div>
      <div class="box-body" style="height: 600px; overflow-y: scroll;">
         <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Name</th>
                    <th>Start Date</th>
                  </tr>
                  </thead>
                  <tbody id="list-schedules">
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
      </div>
      <div class="box-footer" id="list-schedule-footer">
      </div>
    </div>
  </div>

</div>
@stop

@section('body-modals')
<div class="modal fade" id="new-schedule">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4>
          Event
          <span class="pull-right" color="red">
            <a href="#" id="cancel" data-dismiss="modal" data-target="new-schedule"> Cancel</a>
          </span>
        </h4>
      </div>
      <!-- modal-header -->
      <form class="form-horizontal" action="{{ route('calendar.store') }}" method="POST" id="addScheduleForm" name="addScheduleForm">
        @csrf
        <div class="modal-body">
          <div class="box-body">
              <div class="alert alert-danger alert-dismissible" style="display:none" id="alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              </div>
              <div class="form-group">
                  <label class="col-sm-3 control-label" for="eventName">
                    New Event
                    <span style="color: red">
                      <i class="fa fa-asterisk"></i>
                    </span>
                  </label>
                  <div class="col-sm-9">
                    <div class='input-group'>
                      <input type="text" id="eventName" name="eventName" class="form-control" placeholder="New Event Name">
                        <span class="input-group-addon">
                          <select name="eventColor" class="colorselector">
                            <option value="A0522D" data-color="#A0522D">sienna</option>
                            <option value="CD5C5C" data-color="#CD5C5C" selected="selected">indianred</option>
                            <option value="FF4500" data-color="#FF4500">orangered</option>
                            ...
                            <option value="DC143C" data-color="#DC143C">crimson</option>
                            <option value="FF8C00" data-color="#FF8C00">darkorange</option>
                            <option value="C71585" data-color="#C71585">mediumvioletred</option>
                          </select>
                        </span>
                    </div>
                  </div>
              </div>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="dateForm">
                From
                <span style="color: red">
                  <i class="fa fa-asterisk"></i>
                </span>
              </label>
              <div class="col-sm-5">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="dateFrom" name="dateFrom"
                  value="{{date('Y-m-d')}}">
                </div>
                <!-- /.input group -->
              </div>
              <div class="col-sm-4">
                <div class="bootstrap-timepicker">
                  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="timeFrom" id="timeFrom">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
            </div>
           <div class="form-group">
              <label class="col-sm-3 control-label" for="dateTo">
                To
                <span style="color: red">
                  <i class="fa fa-asterisk"></i>
                </span>
              </label>
              <div class="col-sm-5">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="dateTo" name="dateTo"
                  value="{{date('Y-m-d')}}">
                </div>
                <!-- /.input group -->
              </div>
              <div class="col-sm-4">
                <div class="bootstrap-timepicker">
                  <div class="input-group">
                    <input type="text" class="form-control timepicker" name="timeTo" id="timeTo">

                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                  </div>
                  <!-- /.input group -->
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="location">Location</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="location" name="location" placeholder="New Event">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label" for="name">Detail</label>
              <div class="col-sm-9">
                <textarea name="detail" id="detail" class="form-control"></textarea>
              </div>
            </div>
          </div>
        <div class="modal-footer justify-content-start" style="text-align:center;">
          <button type="submit" class="btn btn-primary pull-right">OK</button>
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
  <!-- fullCalendar -->
  {{ Html::css('theme/AdminLTE/bower_components/moment/moment.js')}}
  {{ Html::css('theme/AdminLTE/bower_components/fullcalendar/dist/fullcalendar.min.js')}}"

  <!-- bootstrap time picker -->
  {{Html::css('theme/AdminLTE/plugins/timepicker/bootstrap-timepicker.min.js')}}"

  {{ Html::script('js/pages/schedule/calendar.min.js') }}
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop