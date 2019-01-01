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

  <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
<!-- provide the csrf token -->
<meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('page-header') 
  <h1>Dashboard</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="{{ url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
@stop


@section('body-inner-content')

      <!-- bagian untuk menampilkan message lemparan dari controller -->
      @if (session('message'))
      <div id="success-msg">
          <div class="alert @if (session('success') == true) alert-success @else alert-danger @endif alert-dismissible fade in" role="alert">
              <button type="button" class="close" data-dismiss="alert" >
                  <span aria-hidden="true">×</span>
              </button>
              <strong>{{ session('message') }}.</strong>
          </div>
      </div>
      @endif
      <!-- end message -->

      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              @foreach ($dashboards as $item)
                <li class="dropdown btn-group @if ($item == reset($dashboards)) active @endif">
                  <a class="btn btn-dashboard" href="#tab_{{ $item->id }}" data-toggle="tab" id="{{ $item->id }}">{{ $item->name }}</a>
                  @if ($item->created_by || $item->user)
                  <a data-toggle="dropdown" class="btn dropdown-toggle">
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu" role="menu">
                      <li><a href="#tab-dropdown1" data-toggle="modal" data-target="#modal-choose-chart" data-iddashboard="{{ $item->id }}">Add To Dashboard</a></li>
                      <li><a id="delete-dashboard-{{ $item->id }}">Delete Dashboard</a></li>
                  </ul>
                  @endif
                </li>
              @endforeach
                @if ($user_role == "1-Super Admin")
                  <li class="pull-right"><a href="#" data-toggle="modal" data-target="#modal-insert-dashboard" class=""><i class="fa fa-plus"></i> Tambah Dashboard</a></li>
                @endif
              </ul>
            <div class="tab-content">

            <!-- foreach untuk grafiknya -->
            @if (empty($dashboards))
              <div class="text-center">
                (empty dashboard)
              </div>
            @else
            @foreach ($dashboards as $item)
              <div class="tab-pane container-fluid @if ($item == reset($dashboards)) active @endif" id="tab_{{ $item->id }}">
                  <div class="row">
                    <!-- Default box -->
                      <div class="box">
                        <div class="box-header">
                          <h3 class="box-title">{{ $item->name }}</h3>

                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
                                    title="FullScreen" onclick="openFullscreen({{ $item->id }})">
                              <i class="fa fa-arrows-alt"></i></button>
                              <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
                                    title="PDF">
                              <i class="fa fa-file-pdf-o"></i></button>
                              <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share" data-iddashboard="{{ $item->id }}"
                                    title="Share">
                              <i class="fa fa-share"></i></button>
                              <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
                                    title="Print">
                              <i class="fa fa-print"></i></button>
                          </div>
                        </div>

                        <div class="box-body" id="box-{{ $item->id }}">
                          
                        </div>
                        <!-- /.box-body -->
                      </div>
                      <!-- /.box -->
                  </div>
                  <!-- /.row -->
              </div>
            @endforeach
            @endif
            <!-- end foreach untuk grafik -->
              
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- END CUSTOM TABS -->
@stop

@section('body-modals')
<!-- modal edit dashboard -->
<div class="modal fade" id="modal-dashboard-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Survey</h4>
      </div>
      <form class="form-horizontal" method="POST" action="{{ route('dashboard.post.chart') }}">
        <!-- menyisipkan field id -->
        <input type="hidden" class="form-control" id="id" name="id">

        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-3">Title</label>
            <div class="col-sm-9">
              <!-- menyisipkan field dashboard_survey_id -->
              <input type="text" class="form-control" id="title" placeholder="Title" name="title">
            </div>
          </div>

          <!-- select -->
          <div id="select-container"></div>

          <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
              <div class="checkbox">
                <a href="#" class="btn btn-success" id="add-compare"><i class="fa fa-plus"> Add Comparison</i></a>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
            @if (empty($chart_type))
              <div class="col-md-12 align-self-center text-center">Data Chart Kosong</div>
            @else
              @foreach ($chart_type as $item)
                <div class="col-md-6 align-self-center">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <input type="radio" name="chart" value="{{ $item->chart_type }}"/>
                      <h3 class="box-title">Grafik {{ $item->name }}</h3>
                      <div class="box-tools pull-right">
                      </div>
                    </div>
                    @if ($item->chart_type == "1-Batang")
                      <div class="box-body styled-1">
                          <canvas id="grafik-batang-edit" width="400" height="400"></canvas>
                      </div>
                    @elseif ($item->chart_type == "2-Spider")
                      <div class="box-body styled-1">
                          <canvas id="grafik-radar-edit" width="400" height="400"></canvas>
                      </div>
                    @endif
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col-->
              @endforeach
            @endif
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          {{ Form::token() }}
          <button type="submit" class="btn btn-primary pull-right">Done</button>
        </div>
      </div>
    </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-share" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      {{-- <form role="form" class="form-horizontal"> --}}
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-3">
              Share To
            </label>
            <div class="col-sm-9">
                <input type="hidden" class="form-control" id="id_dashboard" name="id_dashboard">
                <select id="share_to" name="share_to[]" class="form-control select2" multiple data-placeholder="Tambah Users"
                        style="width: 100%;">
                </select>
            </div>
          </div>
        
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-primary" id="ajaxSubmit">Share</button>
      </div>
      {{-- </form> --}}
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-choose-chart" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('dashboard.post.chart') }}" method="post" autocomplete="off" class="form-horizontal" id="form-modal-survey">
        <div class="modal-header">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-3 control-label">Survey</label>
              <div class="col-sm-9">
                <input type="hidden" class="form-control" id="id_dashboard" name="id_dashboard">
                {{ Form::text('name', '' , ['class'=>'form-control', 'id'=>'survey', 'required'=>'required','placeholder'=>'Nama Survey']) }}
              </div>
            </div>
        </div>
        <div class="modal-body">
          <div class="row">
          @if (empty($chart_type))
            <div class="col-md-12 align-self-center text-center">Data Chart Kosong</div>
          @else
            @foreach ($chart_type as $item)
              <div class="col-md-6 align-self-center">
                <!-- Default box -->
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <input type="radio" name="chart" value="{{ $item->chart_type }}"/>
                    <h3 class="box-title">Grafik {{ $item->name }}</h3>
                    <div class="box-tools pull-right">
                    </div>
                  </div>
                  @if ($item->chart_type == "1-Batang")
                    <div class="box-body styled-1">
                        <canvas id="grafik-batang" width="400" height="400"></canvas>
                    </div>
                  @elseif ($item->chart_type == "2-Spider")
                    <div class="box-body styled-1">
                        <canvas id="grafik-radar" width="400" height="400"></canvas>
                    </div>
                  @endif
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col-->
            @endforeach
          @endif
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-choose-survey">Next</button>
        </div>
      <!-- </form> -->
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-choose-survey" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Choose Survey</h4>
      </div>

      <div class="form-horizontal">

        <div class="modal-body">
          <!-- select -->
          <div class="form-group">
            <label class="control-label col-sm-3">Pilih Survey</label>
            <div class="col-sm-9">
              <select class="form-control" name="survey[]">
                @foreach ($surveys as $item)
                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="ck-comparison">
                    Comparison
                </label>
              </div>
            </div>
          </div>

          <fieldset style="display:none">
          <div class="form-group">
            <label class="control-label col-sm-3">Pilih Survey</label>
            <div class="col-sm-9">
              <select class="form-control select-compare" name="survey[]" disabled>
                  @foreach ($surveys as $item)
                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                  @endforeach
              </select>
            </div>
          </div>
          </fieldset>
          
        </div>

        <div class="modal-footer justify-content-between">
          {{ Form::token() }}
          <button type="submit" class="btn btn-primary pull-right">Done</button>
        </div>

      </div> <!-- /div class form-horizontal-->

      </form>
    </div><!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
  
  <div class="modal fade" id="modal-insert-dashboard" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <form action="{{ route('dashboard.post') }}" method="post" autocomplete="off">
            <div class="form-group">
              <label for="name-dashboard" class="col-sm-3 control-label">Nama Dashboard</label>
              <div class="col-sm-9">
                {{ Form::text('name', '' , ['class'=>'form-control', 'id'=>'name-dashboard', 'required'=>'required']) }}
              
              <div class="modal-footer justify-content-between">
                {{ Form::token() }}
                <button type="submit" class="btn btn-primary pull-right">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
  <script src="{{ asset('js/pages/dashboard/Chart.js')}}"></script>
  <script src="{{ asset('js/pages/dashboard/sweetalert2.all.min.js')}}"></script>
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
  <script>
    $(document).ready(function() {
        
        var dashboard_id = $('.btn.btn-dashboard').attr('id');
        $('#box-' + dashboard_id).empty();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          $.ajax({
            type: "POST",
            url: base_url+'/ajax_get_dashboard',
            data: { _token: CSRF_TOKEN, id : dashboard_id },
            dataType: "JSON",
            success: function (data) {
              console.log(data);
              if (data.charts) {
                data.charts.forEach(element => {
                  var survey = [];
                  data.labels.forEach(surveys => {
                    if (surveys.charts_id==element.id){
                      survey.push(surveys.surveys_id);
                    }
                  });
                  if (element.chart_type=="1-Batang") {
                    if (survey.length>1) {
                      var div_class = '<div class="col-md-12 align-self-center">';
                      var chart_type = '<canvas id="grafik-batang-'+element.id+'" width="50" height="50"></canvas>';
                    } else if (survey.length==1) {
                      var div_class = '<div class="col-md-4 align-self-center">';
                      var chart_type = '<canvas id="grafik-batang-'+element.id+'" width="400" height="400"></canvas>';
                    }
                  } else if (element.chart_type=="2-Spider") {
                    if (survey.length>1) {
                      var div_class = '<div class="col-md-12 align-self-center">';
                      var chart_type = '<canvas id="grafik-spider-'+element.id+'" width="400" height="400"></canvas>';
                    } else if (survey.length==1) {
                      var div_class = '<div class="col-md-4 align-self-center">';
                      var chart_type = '<canvas id="grafik-spider-'+element.id+'" width="400" height="400"></canvas>';
                    }
                  }

                  $('#box-' + dashboard_id).append(div_class +
                            '<!-- Default box -->'+
                            '<div class="box box-primary">'+
                              '<div class="box-header with-border">'+
                                '<h3 class="box-title">'+element.name+'</h3>'+

                                '<div class="box-tools pull-right">'+
                                  '<button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"'+
                                          'title="Share">'+
                                    '<i class="fa fa-share"></i></button>'+
                                    '<button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-dashboard-edit"'+
                                          'title="Edit" data-chart_id="'+element.id+'" data-dashboard_id="'+dashboard_id+'">'+
                                    '<i class="fa fa-gear"></i></button>'+
                                '</div>'+
                              '</div>'+
                              '<div class="box-body">'+
                                  '{{-- Grafik Here --}}'+
                                  chart_type +
                              '</div>'+
                              '<!-- /.box-body -->'+
                            '</div>'+
                            '<!-- /.box -->'+
                          '</div>'+
                        '<!-- /.col-->'
                  );

                  if (element.chart_type=="1-Batang") {
                    var ctx2 = document.getElementById("grafik-batang-"+element.id);
                    var process_name = [];
                    var level = [];
                    var target_level = [];
                    var percent = [];
                    var target_percent = [];
                    var backgroudcolor_target_percent = [];
                    var bordercolor_target_percent = [];
                    var backgroudcolor_percent = [];
                    var bordercolor_percent = [];
                    
                    data.process.forEach(process => {
                      if (process.charts_id===element.id) {
                        process_name.push(process.process);
                        level.push(process.level);
                        target_level.push(process.target_level);
                        percent.push(process.percent);
                        target_percent.push(process.target_percent);
                        backgroudcolor_target_percent.push('rgba(0,0,200,0.5)');
                        bordercolor_target_percent.push('rgba(0,0,200,0.5)');
                        backgroudcolor_percent.push('rgba(200,0,0,0.5)');
                        bordercolor_percent.push('rgba(200,0,0,0.5)');
                      }
                    });
                    
                    var myChart2 = new Chart(ctx2, {
                      type: 'bar',
                      data: {
                        labels: process_name,
                        datasets: [{
                            label: 'Target Percent %',
                            data: target_percent,
                            backgroundColor: backgroudcolor_target_percent,
                            borderColor: bordercolor_target_percent,
                            borderWidth: 1
                          },
                          {
                            label: 'Pencapaian Target %',
                            data: percent,
                            backgroundColor: backgroudcolor_percent,
                            borderColor: bordercolor_percent,
                            borderWidth: 1
                          }
                        ]
                      },
                      options: {
                        scales: {
                          yAxes: [{
                            stacked: true,
                            ticks: {
                              beginAtZero: true
                            }
                          }],
                          xAxes: [{
                            stacked: true,
                            ticks: {
                              beginAtZero: true
                            }
                          }]

                        }
                      }
                    });
                  } else if (element.chart_type=="2-Spider") {
                    var marksCanvas = document.getElementById("grafik-spider-"+element.id);
                    var survey_name = [];
                    var process_name = [];
                    var level = [];
                    var target_level = [];
                    var percent = [];
                    var target_percent = [];
                    var backgroudcolor_target_percent = [];
                    var bordercolor_target_percent = [];
                    var backgroudcolor_percent = [];
                    var bordercolor_percent = [];
                    
                    data.process.forEach(process => {
                      if (process.charts_id==element.id) {
                        survey_name.push(process.name);
                        process_name.push(process.process);
                        level.push(process.level);
                        target_level.push(process.target_level);
                        percent.push(process.percent);
                        target_percent.push(process.target_percent);
                        backgroudcolor_target_percent.push('rgba(0,0,200,0.5)');
                        bordercolor_target_percent.push('rgba(0,0,200,0.5)');
                        backgroudcolor_percent.push('rgba(200,0,0,0.5)');
                        bordercolor_percent.push('rgba(200,0,0,0.5)');
                      }
                    });

                    var radarChart = new Chart(marksCanvas, {
                        type: 'radar',
                        data: {
                            labels: process_name,
                            datasets: [{
                                backgroundColor: 'rgba(0,0,200,0.5)',
                                label: 'Target Level',
                                data: target_level
                                },
                                {
                                backgroundColor: 'rgba(200,0,0,0.5)',
                                label: 'Pencapaian Level',
                                data: level
                                }]
                        }
                    });

                    function addData(chart, label, color, data) {
                        chart.data.datasets.push({
                          label: label,
                          backgroundColor: color,
                          data: data
                        });
                        chart.update();
                    }

                    // // inserting the new dataset after 3 seconds
                    // setTimeout(function() {

                    //   addData(radarChart, survey_name, 'rgba(0,0,200,0.5)', level);
                    // }, 3000);

                  }
                  
                });
              } else {
                console.log('hide');
              }
            }
          });

      
      $('.btn.btn-dashboard').click(function (e) { 
        e.preventDefault();
        var dashboard_id = $(this).attr('id');
        $('#box-' + dashboard_id).empty();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          type: "POST",
          url: base_url+'/ajax_get_dashboard',
          data: { _token: CSRF_TOKEN, id : dashboard_id },
          dataType: "JSON",
          success: function (data) {
            console.log(data);
            if (data.charts) {
                data.charts.forEach(element => {
                  if (element.chart_type=="1-Batang") {
                    var chart_type = '<canvas id="grafik-batang-'+element.id+'" width="400" height="400"></canvas>';
                  } else if (element.chart_type=="2-Spider") {
                    var chart_type = '<canvas id="grafik-spider-'+element.id+'" width="400" height="400"></canvas>';
                  }

                  $('#box-' + dashboard_id).append('<div class="col-md-4 align-self-center">'+
                            '<!-- Default box -->'+
                            '<div class="box box-primary">'+
                              '<div class="box-header with-border">'+
                                '<h3 class="box-title">'+element.name+'</h3>'+

                                '<div class="box-tools pull-right">'+
                                  '<button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"'+
                                          'title="Share">'+
                                    '<i class="fa fa-share"></i></button>'+
                                    '<button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-dashboard-edit"'+
                                          'title="Edit" data-chart_id="'+element.id+'" data-title="'+element.name+'" data-surveyid="'+element.surveys_id+'" data-chart_type="'+element.chart_type+'">'+
                                    '<i class="fa fa-gear"></i></button>'+
                                '</div>'+
                              '</div>'+
                              '<div class="box-body">'+
                                  '{{-- Grafik Here --}}'+
                                  chart_type+
                              '</div>'+
                              '<!-- /.box-body -->'+
                            '</div>'+
                            '<!-- /.box -->'+
                          '</div>'+
                        '<!-- /.col-->'
                  );
                  
                  if (element.chart_type=="1-Batang") {
                    // var marksCanvas = document.getElementById("grafik-batang-"+element.id);
                    var ctx2 = document.getElementById("grafik-batang-"+element.id);
                    var process_name = [];
                    var level = [];
                    var target_level = [];
                    var percent = [];
                    var target_percent = [];
                    var backgroudcolor_target_percent = [];
                    var bordercolor_target_percent = [];
                    var backgroudcolor_percent = [];
                    var bordercolor_percent = [];
                    
                    data.process.forEach(process => {
                      if (process.charts_id===element.id) {
                        process_name.push(process.process);
                        level.push(process.level);
                        target_level.push(process.target_level);
                        percent.push(process.percent);
                        target_percent.push(process.target_percent);
                        backgroudcolor_target_percent.push('rgba(0,0,200,0.5)');
                        bordercolor_target_percent.push('rgba(0,0,200,0.5)');
                        backgroudcolor_percent.push('rgba(200,0,0,0.5)');
                        bordercolor_percent.push('rgba(200,0,0,0.5)');
                      }
                    });
                    
                    var myChart2 = new Chart(ctx2, {
                      type: 'bar',
                      data: {
                        labels: process_name,
                        datasets: [{
                            label: 'Target Percent %',
                            data: target_percent,
                            backgroundColor: backgroudcolor_target_percent,
                            borderColor: bordercolor_target_percent,
                            borderWidth: 1
                          },
                          {
                            label: 'Pencapaian Target %',
                            data: percent,
                            backgroundColor: backgroudcolor_percent,
                            borderColor: bordercolor_percent,
                            borderWidth: 1
                          }
                        ]
                      },
                      options: {
                        scales: {
                          yAxes: [{
                            stacked: true,
                            ticks: {
                              beginAtZero: true
                            }
                          }],
                          xAxes: [{
                            stacked: true,
                            ticks: {
                              beginAtZero: true
                            }
                          }]

                        }
                      }
                    });
                  } else if (element.chart_type=="2-Spider") {
                    var marksCanvas = document.getElementById("grafik-spider-"+element.id);
                    var survey_name = [];
                    var process_name = [];
                    var level = [];
                    var target_level = [];
                    var percent = [];
                    var target_percent = [];
                    var backgroudcolor_target_percent = [];
                    var bordercolor_target_percent = [];
                    var backgroudcolor_percent = [];
                    var bordercolor_percent = [];
                    
                    data.process.forEach(process => {
                      if (process.charts_id==element.id) {
                        survey_name.push(process.name);
                        process_name.push(process.process);
                        level.push(process.level);
                        target_level.push(process.target_level);
                        percent.push(process.percent);
                        target_percent.push(process.target_percent);
                        backgroudcolor_target_percent.push('rgba(0,0,200,0.5)');
                        bordercolor_target_percent.push('rgba(0,0,200,0.5)');
                        backgroudcolor_percent.push('rgba(200,0,0,0.5)');
                        bordercolor_percent.push('rgba(200,0,0,0.5)');
                      }
                    });

                    var radarChart = new Chart(marksCanvas, {
                        type: 'radar',
                        data: {
                            labels: process_name,
                            datasets: [{
                                backgroundColor: 'rgba(0,0,200,0.5)',
                                label: 'Target Level',
                                data: target_level
                                },
                                {
                                backgroundColor: 'rgba(200,0,0,0.5)',
                                label: 'Pencapaian Level',
                                data: level
                                }]
                        }
                    });

                    function addData(chart, label, color, data) {
                        chart.data.datasets.push({
                          label: label,
                          backgroundColor: color,
                          data: data
                        });
                        chart.update();
                    }

                    // // inserting the new dataset after 3 seconds
                    // setTimeout(function() {

                    //   addData(radarChart, survey_name, 'rgba(0,0,200,0.5)', level);
                    // }, 3000);

                  }
                });
            } else {
                console.log('hide');
            }
          }
        });

      });
    });
  </script>
  
  <script>
    // script untuk melempar value dari button untuk mengeluarkan modal dan value nya di ambil untuk di simpan di modal
    $('#modal-choose-chart').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var idDashboard = button.data('iddashboard') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('#id_dashboard').val(idDashboard)
    })
    
    // script untuk membuat set value edit dashboard
    $('#modal-dashboard-edit').on('show.bs.modal', function (event) {
      var $modal = $(this)  

      // clear dulu isi modalnya
      $modal.find('input[name="title"]').val('');
      $modal.find('#select-container').html('');
      $modal.find("input[name=chart]").removeAttr("checked");
      $('#ck-comparison2').prop('checked', false);
      $modal.find("input[name=comparison]").removeAttr('checked');

      // hide comparison field
      $(".fieldset-edit").hide();
      $('.select-compare').attr( "disabled", "disabled" ); // Elements(s) are now disabled.

      var cb = $('#ck-comparison2')
      var button = $(event.relatedTarget) // Button that triggered the modal
      var chart_id = button.data('chart_id') // Extract info from data-* attributes

      $modal.find('#id').val(chart_id);
      
      $.get(base_url + "/ajax/edit-survey/" + chart_id, function(oResp) {
        console.log(oResp)
        oResp.forEach(function (element, index) {
          // 1. append dulu select nya
          // 2. set id nya berdasarkan foreach nya
          $("#select-container").append(
            '<div class="form-group" id="row_survey_'+element.dashboard_survey_id+'">'+
              '<label class="control-label col-sm-3">Pilih Survey</label>'+
              '<input type="hidden" value="'+element.dashboard_survey_id+'" name="dashboard_survey_id[]">'+
              '<div class="col-sm-7">'+
                '<select class="form-control" id="survey_id_'+index+'" name="survey[]">'+
                      '@foreach ($surveys as $item)'+
                        '<option value="{{ $item->id }}">{{ $item->name }}</option>'+
                      '@endforeach'+
                  '</select>'+
              '</div>'+
              '<div class="col-sm-2">'+
                '<a href="#" class="btn btn-danger" title="Remove Survey" onclick="hapusSurvey('+element.dashboard_survey_id+')"><i class="fa fa-remove" style="font-color:red"></i></a>'+
              '</div>'+
            '</div>'
          );
          // 3. sudah di append dom nya baru di set value nya berdasarkan id for nya
          $modal.find('input[name="title"]').val(element.name);
          $modal.find('#survey_id_'+index).val(element.surveys_id);
          $modal.find("input[name=chart][value=" + element.chart_type + "]").attr('checked', 'checked');
        });
      });

    })

    /**
    * hapusSurvey()
    * For deleting survey on edit form
     */
    function hapusSurvey(dashboard_survey_id){
      Swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            type: "POST",
            url: base_url+'/ajax_delete_survey',
            data: { _token: CSRF_TOKEN, 'dashboard_survey_id': dashboard_survey_id },
            dataType: "JSON",
            success: function (response) {
              if(response==1){
                  Swal(
                  'Deleted!',
                  'Survey has been deleted Successfully!',
                  'success'
                )
                // window.location.href = base_url;
                $('#row_survey_'+dashboard_survey_id).remove()

              } else {
                  Swal(
                    'Failed!',
                    'Dashboard failed to delete!',
                    'error'
                )
              }
            }
          });
        }
      });
    }
  </script>

  <script>
    var batang = document.getElementById("grafik-batang");
    var myChart = new Chart(batang, {
                      type: 'bar',
                      data: {
                        labels: ["EDM02", "APO01"],
                        datasets: [{
                            label: 'Target Percent %',
                            data: [20, 10],
                            backgroundColor: 'rgba(0,0,200,0.5)',
                            borderColor: 'rgba(0,0,200,0.5)',
                            borderWidth: 1
                          },
                          {
                            label: 'Pencapaian Target %',
                            data: [20, 10],
                            backgroundColor: 'rgba(200,0,0,0.5)',
                            borderColor: 'rgba(200,0,0,0.5)',
                            borderWidth: 1
                          }
                        ]
                      },
                      options: {
                        scales: {
                          yAxes: [{
                            stacked: true,
                            ticks: {
                              beginAtZero: true
                            }
                          }],
                          xAxes: [{
                            stacked: true,
                            ticks: {
                              beginAtZero: true
                            }
                          }]

                        }
                      }
                    });
      
    var radar = document.getElementById("grafik-radar");

    var myRadar = new Chart(radar, {
                        type: 'radar',
                        data: {
                            labels: ["EDM01", "EDM02", "EDM03", "EDM04", "APO01", "APO02", "APO03"],
                            datasets: [{
                                backgroundColor: 'rgba(0,0,200,0.5)',
                                label: 'Survey 1',
                                data: [10, 20, 30, 40, 50, 60, 90]
                                },
                                {
                                backgroundColor: 'rgba(200,0,0,0.5)',
                                label: 'Survey 2',
                                data: [40, 50, 60, 30, 20, 10, 70]
                                }]
                        }
                    });
    
    // untuk modal edit dashboard
    var batang = document.getElementById("grafik-batang-edit");
    var myChart = new Chart(batang, {
                      type: 'bar',
                      data: {
                        labels: ["EDM02", "APO01"],
                        datasets: [{
                            label: 'Target Percent %',
                            data: [20, 10],
                            backgroundColor: 'rgba(0,0,200,0.5)',
                            borderColor: 'rgba(0,0,200,0.5)',
                            borderWidth: 1
                          },
                          {
                            label: 'Pencapaian Target %',
                            data: [20, 10],
                            backgroundColor: 'rgba(200,0,0,0.5)',
                            borderColor: 'rgba(200,0,0,0.5)',
                            borderWidth: 1
                          }
                        ]
                      },
                      options: {
                        scales: {
                          yAxes: [{
                            stacked: true,
                            ticks: {
                              beginAtZero: true
                            }
                          }],
                          xAxes: [{
                            stacked: true,
                            ticks: {
                              beginAtZero: true
                            }
                          }]

                        }
                      }
                    });
      
    var radar = document.getElementById("grafik-radar-edit");

    var myRadar = new Chart(radar, {
                        type: 'radar',
                        data: {
                            labels: ["EDM01", "EDM02", "EDM03", "EDM04", "APO01", "APO02", "APO03"],
                            datasets: [{
                                backgroundColor: 'rgba(0,0,200,0.5)',
                                label: 'Survey 1',
                                data: [10, 20, 30, 40, 50, 60, 90]
                                },
                                {
                                backgroundColor: 'rgba(200,0,0,0.5)',
                                label: 'Survey 2',
                                data: [40, 50, 60, 30, 20, 10, 70]
                                }]
                        }
                    });
    
      
  </script>

  {{-- Alert Delete Dashboard --}}
  @foreach ($dashboards as $item)
    <script>   
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
      $(document).ready(function(){
        $("#delete-dashboard-{{ $item->id }}").click(function(){
          Swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.value) {
              $.ajax({
                type: "POST",
                url: base_url+'/ajax_delele_dashboard',
                data: { _token: CSRF_TOKEN, 'dashboard_id': {{ $item->id }}, 'created_by': {{ $item->created_by }} },
                dataType: "JSON",
                success: function (response) {
                  if(response==1){
                      Swal(
                      'Deleted!',
                      '{{ $item->name }} has been deleted Successfully!',
                      'success'
                    )
                    window.location.href = base_url;
                  } else if (response==0){
                      Swal(
                        'Failed!',
                        'Dashboard failed to delete!',
                        'error'
                    )
                  }
                }
              });
            }
          })
        });
      });
      
    </script>
  @endforeach

  {{-- @foreach ($dashboards as $item) --}}
  <script>

    // script untuk melempar value dari button untuk mengeluarkan modal dan value nya di ambil untuk di simpat di modal
    $('#modal-share').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var idDashboard = button.data('iddashboard') // Extract info from data-* attributes
      
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('#id_dashboard').val(idDashboard)
    })
    
    // ajax proses insert user id ke dashboard_user
    $(document).ready(function () {
      $('#ajaxSubmit').click(function (e) { 
        e.preventDefault();

        $.ajax({
          type: "POST",
          url: base_url+'/ajax_share_to',
          data: { '_token' : CSRF_TOKEN,
                  'dashboard_id' : $('#id_dashboard').val(),
                  'iduser' : $('#share_to').val() },
          dataType: "JSON",
          success: function (response) {
            // console.log(response);
            if (response==1) {
              Swal(
                'Berhasil !',
                'User berhasil di tambahkan ke dashboard!',
                'success'
              )
              window.location.href = base_url;
            } else {
              Swal(
                  'Failed!',
                  'User Gagal di tambahkan!',
                  'error'
              )
            }
          }
        });
      });
    });
  </script>
  {{-- @endforeach --}}

  {{-- Show hide comparison --}}
  <script>
      $(document).ready(function() {
        var cb = $('#ck-comparison');
  
        cb.on("click", function() {
          if (cb.attr("checked") == "checked") {
            cb.removeAttr("checked");
            $("fieldset").hide();
            $('.select-compare').attr( "disabled", "disabled" ); // Elements(s) are now disabled.
            console.log('update menjadi unchecked');    
          } else {
            cb.attr("checked", "checked");
            $("fieldset").show();
            $('.select-compare').prop("disabled", false); // Element(s) are now enabled.
            console.log('update menjadi checked');
          }
        });

        // fungsi untuk menambahkan select survey
        var cb2 = $('#add-compare');
        // set global variabel untuk count append survey dimulai dari 0
        var count_cb2 = 0;

        cb2.on("click", function() {
          // mengambil id select terakhir
          var last_id_select = $('input[name*="survey"]').length;
          console.log(this)
          $("#select-container").append(
            '<div class="form-group" id="count-cb2-'+count_cb2+'">'+
              '<div class="survey_new">'+
                '<label class="control-label col-sm-3">Pilih Survey</label>'+
                '<div class="col-sm-7">'+
                  '<select class="form-control" id="survey_id_'+last_id_select+'" name="survey_new[]">'+
                        '@foreach ($surveys as $item)'+
                          '<option value="{{ $item->id }}">{{ $item->name }}</option>'+
                        '@endforeach'+
                    '</select>'+
                '</div>'+
                '<div class="col-sm-2">'+
                  '<a href="#" class="btn btn-danger" title="Remove Survey" onclick="removeNewSurvey('+count_cb2+')"><i class="fa fa-remove" style="font-color:red"></i></a>'+
                '</div>'+
              '</div>'+
            '</div>'
          );
          count_cb2++;

        });

      });

      function removeNewSurvey(counter){
        $("#count-cb2-"+counter).remove()
      }

  </script>

  {{-- Select Users --}}
  <script>
  $(document).ready(function(){
        initialize_select_user("#share_to");
  });
    
  function initialize_select_user(id_element){ 
          $.ajax({
              type: 'GET',
              url: base_url+'/ajax_get_list_user',
              success: function (data) {
                  // the next thing you want to do 
                  var $v_select = $(id_element);
                  var item = JSON.parse(data);
                  $v_select.empty();
                  $v_select.append("<option value=''></option>");
                  $.each(item, function(index,valuee) {    
                      $v_select.append("<option value='"+valuee.id+"'>@"+valuee.username+"</option>");
                  });
    
                  //manually trigger a change event for the contry so that the change handler will get triggered
                  $v_select.change();
              }
          });
        }
  </script>

  {{-- Fullscreen Dashboard --}}
  <script>
    /* Function to open fullscreen mode */
    function openFullscreen(id_tab) {
      /* Get the element you want displayed in fullscreen */ 
      var elem = document.getElementById("box-"+id_tab);
      console.log(elem)
      if (elem.requestFullscreen) {
        elem.requestFullscreen();
      } else if (elem.mozRequestFullScreen) { /* Firefox */
        elem.mozRequestFullScreen();
      } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
        elem.webkitRequestFullscreen();
      } else if (elem.msRequestFullscreen) { /* IE/Edge */
        elem.msRequestFullscreen();
      }
    };
  </script>
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop