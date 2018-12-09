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
@stop

@section('page-header') 
  <h1>Dashboard</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="{{ url('dashboard')}}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
@stop


@section('body-inner-content')

      <div class="row">
        <div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              @foreach ($dashboards as $item)
                <li class="dropdown btn-group">
                  <a class="btn" href="#tab_{{ $item->id }}" data-toggle="tab">{{ $item->name }}</a>
                  <a data-toggle="dropdown" class="btn dropdown-toggle">
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#tab-dropdown1" data-toggle="modal" data-target="#modal-choose-chart">Add To Dashboard</a></li>
                    <li><a id="delete-dashboard-{{ $item->id }}">Delete Dashboard</a></li>
                  </ul>
                </li>
              @endforeach

                <li class="pull-right"><a href="#" data-toggle="modal" data-target="#modal-insert-dashboard" class=""><i class="fa fa-plus"></i> Tambah Dashboard</a></li>
              </ul>
            <div class="tab-content">
                    <div class="tab-pane container-fluid active" id="tab_1">
                        <div class="row">
                          <!-- Default box -->
                            <div class="box">
                              <div class="box-header">
                                <h3 class="box-title"></h3>
  
                                <div class="box-tools pull-right">
                                  <button type="button" id="fullscreen" class="btn btn-box-tool" data-toggle="tooltip"
                                          title="Full Screen">
                                    <i class="fa fa-arrows-alt"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
                                          title="PDF">
                                    <i class="fa fa-file-pdf-o"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                          title="Share">
                                    <i class="fa fa-share"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
                                          title="Print">
                                    <i class="fa fa-print"></i></button>
                                </div>
                              </div>
                              <div class="box-body">
                                <div class="col-md-4 align-self-center">
                                  <!-- Default box -->
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Grafik Compare</h3>
  
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                                title="Share">
                                          <i class="fa fa-share"></i></button>
                                          <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-dashboard-edit"
                                                title="Edit">
                                          <i class="fa fa-gear"></i></button>
                                      </div>
                                    </div>
                                    <div class="box-body">
                                        {{-- Grafik Here --}}
                                        <canvas id="grafik-compare" width="400" height="400"></canvas>
                                    </div>
                                    <!-- /.box-body -->
                                  </div>
                                  <!-- /.box -->
                                </div>
                                <!-- /.col-->
                                <div class="col-md-4 align-self-center">
                                  <!-- Default box -->
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">SURVEY_1</h3>
  
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                                title="Share">
                                          <i class="fa fa-share"></i></button>
                                          <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-dashboard-edit"
                                                title="Edit">
                                          <i class="fa fa-gear"></i></button>
                                      </div>
                                    </div>
                                    <div class="box-body">
                                      {{-- Grafik Here --}}
                                      <canvas id="grafik-1" width="400" height="400"></canvas>
                                    </div>
                                    <!-- /.box-body -->
                                  </div>
                                  <!-- /.box -->
                                </div>
                                <!-- /.col-->
                                <div class="col-md-4 align-self-center">
                                  <!-- Default box -->
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">SURVEY_2</h3>
  
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                                title="Share">
                                          <i class="fa fa-share"></i></button>
                                          <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-dashboard-edit"
                                                title="Edit">
                                          <i class="fa fa-gear"></i></button>
                                      </div>
                                    </div>
                                    <div class="box-body">
                                      {{-- Grafik Here --}}
                                      <canvas id="grafik-2" width="400" height="400"></canvas>
                                    </div>
                                    <!-- /.box-body -->
                                  </div>
                                  <!-- /.box -->
                                </div>
                                <!-- /.col-->
                          </div>
                              <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.row -->
                    </div>

                    <div class="tab-pane container-fluid" id="tab_2">
                        <div class="row">
                          <!-- Default box -->
                            <div class="box">
                              <div class="box-header">
                                <h3 class="box-title"></h3>
  
                                <div class="box-tools pull-right">
                                  <button type="button" id="fullscreen" class="btn btn-box-tool" data-toggle="tooltip"
                                          title="Full Screen">
                                    <i class="fa fa-arrows-alt"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
                                          title="PDF">
                                    <i class="fa fa-file-pdf-o"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                          title="Share">
                                    <i class="fa fa-share"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
                                          title="Print">
                                    <i class="fa fa-print"></i></button>
                                </div>
                              </div>
                              <div class="box-body">
                                <div class="col-md-4 align-self-center">
                                  <!-- Default box -->
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Grafik Compare</h3>
  
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                                title="Share">
                                          <i class="fa fa-share"></i></button>
                                          <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-dashboard-edit"
                                                title="Edit">
                                          <i class="fa fa-gear"></i></button>
                                      </div>
                                    </div>
                                    <div class="box-body">
                                        {{-- Grafik Here --}}
                                        {{-- <canvas id="grafik-compare" width="400" height="400"></canvas> --}}
                                    </div>
                                    <!-- /.box-body -->
                                  </div>
                                  <!-- /.box -->
                                </div>
                                <!-- /.col-->
                                <div class="col-md-4 align-self-center">
                                  <!-- Default box -->
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Grafik 1</h3>
  
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                                title="Share">
                                          <i class="fa fa-share"></i></button>
                                          <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-dashboard-edit"
                                                title="Edit">
                                          <i class="fa fa-gear"></i></button>
                                      </div>
                                    </div>
                                    <div class="box-body">
                                      {{-- Grafik Here --}}
                                      {{-- <canvas id="grafik-1" width="400" height="400"></canvas> --}}
                                    </div>
                                    <!-- /.box-body -->
                                  </div>
                                  <!-- /.box -->
                                </div>
                                <!-- /.col-->
                                <div class="col-md-4 align-self-center">
                                  <!-- Default box -->
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Grafik 2</h3>
  
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                                title="Share">
                                          <i class="fa fa-share"></i></button>
                                          <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-dashboard-edit"
                                                title="Edit">
                                          <i class="fa fa-gear"></i></button>
                                      </div>
                                    </div>
                                    <div class="box-body">
                                      {{-- Grafik Here --}}
                                      {{-- <canvas id="grafik-2" width="400" height="400"></canvas> --}}
                                    </div>
                                    <!-- /.box-body -->
                                  </div>
                                  <!-- /.box -->
                                </div>
                                <!-- /.col-->
                          </div>
                              <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.row -->
                    </div>

                    <div class="tab-pane container-fluid" id="tab_3">
                        <div class="row">
                          <!-- Default box -->
                            <div class="box">
                              <div class="box-header">
                                <h3 class="box-title"></h3>
  
                                <div class="box-tools pull-right">
                                  <button type="button" id="fullscreen" class="btn btn-box-tool" data-toggle="tooltip"
                                          title="Full Screen">
                                    <i class="fa fa-arrows-alt"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
                                          title="PDF">
                                    <i class="fa fa-file-pdf-o"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                          title="Share">
                                    <i class="fa fa-share"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
                                          title="Print">
                                    <i class="fa fa-print"></i></button>
                                </div>
                              </div>
                              <div class="box-body">
                                <div class="col-md-4 align-self-center">
                                  <!-- Default box -->
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Grafik Compare</h3>
  
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                                title="Share">
                                          <i class="fa fa-share"></i></button>
                                          <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-dashboard-edit"
                                                title="Edit">
                                          <i class="fa fa-gear"></i></button>
                                      </div>
                                    </div>
                                    <div class="box-body">
                                        {{-- Grafik Here --}}
                                        {{-- <canvas id="grafik-compare" width="400" height="400"></canvas> --}}
                                    </div>
                                    <!-- /.box-body -->
                                  </div>
                                  <!-- /.box -->
                                </div>
                                <!-- /.col-->
                                <div class="col-md-4 align-self-center">
                                  <!-- Default box -->
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Grafik 1</h3>
  
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                                title="Share">
                                          <i class="fa fa-share"></i></button>
                                          <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-dashboard-edit"
                                                title="Edit">
                                          <i class="fa fa-gear"></i></button>
                                      </div>
                                    </div>
                                    <div class="box-body">
                                      {{-- Grafik Here --}}
                                      {{-- <canvas id="grafik-1" width="400" height="400"></canvas> --}}
                                    </div>
                                    <!-- /.box-body -->
                                  </div>
                                  <!-- /.box -->
                                </div>
                                <!-- /.col-->
                                <div class="col-md-4 align-self-center">
                                  <!-- Default box -->
                                  <div class="box box-primary">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Grafik 2</h3>
  
                                      <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                                title="Share">
                                          <i class="fa fa-share"></i></button>
                                          <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-dashboard-edit"
                                                title="Edit">
                                          <i class="fa fa-gear"></i></button>
                                      </div>
                                    </div>
                                    <div class="box-body">
                                      {{-- Grafik Here --}}
                                      {{-- <canvas id="grafik-2" width="400" height="400"></canvas> --}}
                                    </div>
                                    <!-- /.box-body -->
                                  </div>
                                  <!-- /.box -->
                                </div>
                                <!-- /.col-->
                          </div>
                              <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.row -->
                    </div>
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
<div class="modal fade" id="modal-dashboard-edit">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Survey</h4>
      </div>
      <form class="form-horizontal">
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-sm-3">Title</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="title" placeholder="Title">
            </div>
          </div>
          <!-- select -->
          <div class="form-group">
            <label class="control-label col-sm-3">Choose 1</label>
            <div class="col-sm-9">
              <select class="form-control">
                <option>survey 1</option>
                <option>survey 2</option>
                <option>survey 3</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
              <div class="checkbox">
                <label>
                  <input type="checkbox">
                  Comparison
                </label>
              </div>
            </div>
          </div>

        </div>
        <!-- modal-body -->

        <div class="modal-body">

          <div class="row">
            <div class="col-md-6 align-self-center">
              <!-- Default box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Grafik Batang</h3>

                  <div class="box-tools pull-right">
                  </div>
                </div>
                <div class="box-body">
                    <canvas id="chart"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col-->

            <div class="col-md-6 align-self-center">
              <!-- Default box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Grafik Radar</h3>

                  <div class="box-tools pull-right">
                  </div>
                </div>
                <div class="box-body">
                    <canvas id="chart"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col-->
          </div>
          <!-- row -->

        </div>
        <!-- modal-body -->

        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary pull-right">Done</button>
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

<div class="modal fade" id="modal-share" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form role="form" class="form-horizontal">
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
              <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
            </div>
          </div>
        
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-primary">Share</button>
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="modal-choose-chart" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-horizontal">
        <div class="modal-header">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-3 control-label">Survey</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="survet" placeholder="Survey">
              </div>
            </div>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 align-self-center">
              <!-- Default box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <input type="radio" name="grafik"/>
                  <h3 class="box-title">Grafik Batang</h3>

                  <div class="box-tools pull-right">
                  </div>
                </div>
                <div class="box-body styled-1">
                    <canvas id="grafik-batang" width="400" height="400"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col-->

            <div class="col-md-6 align-self-center">
              <!-- Default box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <input type='radio' name="grafik"/>
                  <h3 class="box-title">Grafik Radar</h3>
                  <div class="box-tools pull-right">
                  </div>
                </div>
                <div class="box-body styled-1">
                    <canvas id="grafik-radar" width="400" height="400"></canvas>
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </div>
            <!-- /.col-->
          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-choose-survey">Next</button>
        </div>
      </form>
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
      <form class="form-horizontal">
        <div class="modal-body">

          <!-- select -->
          <div class="form-group">
            <label class="control-label col-sm-3">Choose 1</label>
            <div class="col-sm-9">
              <select class="form-control">
                <option>survey 1</option>
                <option>survey 2</option>
                <option>survey 3</option>
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
          <fieldset>
            <div class="form-group">
              <label class="control-label col-sm-3">Choose 1</label>
              <div class="col-sm-9">
                <select class="form-control">
                  <option>survey 1</option>
                  <option>survey 2</option>
                  <option>survey 3</option>
                </select>
              </div>
            </div>
          <fieldset>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary pull-right">Done</button>
        </div>
      </form>
      </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
  
  <div class="modal fade" id="modal-insert-dashboard" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal">
          <div class="modal-header">
            <form method="POST" action="{{ route('dashboard.post') }}">
              @csrf
              <div class="form-group">
                <label for="name-dashboard" class="col-sm-3 control-label">Nama Dashboard</label>
                <div class="col-sm-9">
                  {{ Form::text('name_dashboard', 'test' , ['class'=>'form-control', 'id'=>'name-dashboard']) }}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                </div>
              </div>
            </form>
          </div>
        </form>
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
  var marksCanvas = document.getElementById("grafik-compare");

  var marksData = {
    labels: ["EDM01", "EDM05", "EDM03", "APO10", "APO12", "APO13"],
    datasets: [{
      label: "Survey 1",
      backgroundColor: "rgba(200,0,0,0.5)",
      data: [65, 75, 70, 80, 60, 80]
    },{ label: "Survey 2",
      backgroundColor: "rgba(200, 209, 29, 0.5)",
      data: [30, 30, 78, 48, 69, 89]
    }, {
      label: "Survey 3",
      backgroundColor: "rgba(0,0,200,0.5)",
      data: [54, 65, 60, 70, 70, 75]
    }]
  };

  var radarChart = new Chart(marksCanvas, {
    type: 'radar',
    data: marksData
  });

  var marksCanvas = document.getElementById("grafik-1");

  var marksData = {
    labels: ["EDM01", "EDM05", "EDM03", "APO10", "APO12", "APO13"],
    datasets: [{
      label: "Level",
      backgroundColor: "rgba(200,0,0,0.5)",
      data: [65, 75, 70, 80, 60, 80]
    }, {
      label: "Target Level",
      backgroundColor: "rgba(0,0,200,0.5)",
      data: [54, 65, 60, 70, 70, 75]
    }]
  };

  var radarChart = new Chart(marksCanvas, {
    type: 'radar',
    data: marksData
  });

  var ctx = document.getElementById("grafik-2");
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ["EDM01", "EDM05", "EDM03", "APO10", "APO12", "APO13"],
      datasets: [{
          label: '#Target Percent',
          data: [10, 19, 3, 5, 2, 3],
          backgroundColor: [
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)'
          ],
          borderColor: [
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)'
          ],
          borderWidth: 1
        },
        {
          label: '#Percent',
          data: [15, 19, 3, 5, 2, 3],
          backgroundColor: [
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)'
          ],
          borderColor: [
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)'
          ],
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

  var ctx2 = document.getElementById("grafik-batang");
  var myChart2 = new Chart(ctx2, {
    type: 'bar',
    data: {
      labels: ["EDM01", "EDM05", "EDM03", "APO10", "APO12", "APO13"],
      datasets: [{
          label: '# Target Percent',
          data: [10, 19, 3, 5, 2, 3],
          backgroundColor: [
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)'
          ],
          borderColor: [
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)',
            'rgba(0,0,200,0.5)'
          ],
          borderWidth: 1
        },
        {
          label: '# Target',
          data: [15, 19, 3, 5, 2, 3],
          backgroundColor: [
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)'
          ],
          borderColor: [
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)',
            'rgba(200,0,0,0.5)'
          ],
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

  var marksCanvas2 = document.getElementById("grafik-radar");

  var marksData2 = {
    labels: ["English", "Maths", "Physics", "Chemistry", "Biology", "History"],
    datasets: [{
      label: "Target Dicapai",
      backgroundColor: "rgba(200,0,0,0.5)",
      data: [65, 75, 70, 80, 60, 80]
    }, {
      label: "Target Survey",
      backgroundColor: "rgba(0,0,200,0.5)",
      data: [54, 65, 60, 70, 70, 75]
    }]
  };

  var radarChart2 = new Chart(marksCanvas2, {
    type: 'radar',
    data: marksData2
  });
  </script>

  {{-- Alert Delete Dashboard --}}
  @foreach ($dashboards as $item)
  <script>
    $(document).ready(function(){
      $("#delete-dashboard-{{ $item->id }}").click(function(){
        Swal({
          title: 'Are you sure you want to delete the {{ $item->name }}?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.value) {
            Swal(
              'Deleted!',
              'Your {{ $item->name }} has been deleted.',
              'success'
            )
          }
        })
      });
    });
  </script>
  @endforeach

  {{-- Fullscreen Dashboard --}}
  <script>
    $('#fullscreen').click(function() {
        $('.box').css({
            position: 'absolute',
            top: 0,
            left: 0,
            width: '100%',
            height: '100%',
            zIndex: 701
        });
    });
  </script>

  {{-- Show hide comparison --}}
  <script>
      $(document).ready(function() {
        var cb = $('#ck-comparison');
  
        cb.on("click", function() {
          if (cb.attr("checked") == "checked") {
            cb.removeAttr("checked");
            $("fieldset").hide();
            console.log('update menjadi unchecked');    
          } else {
            cb.attr("checked", "checked");
            $("fieldset").show();
            console.log('update menjadi checked');
          }
        });
      });
  </script>
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop