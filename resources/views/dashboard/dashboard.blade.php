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

  {{--<link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css')}}">  dipindah jadi global style --}}
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
                  <a class="btn" href="#tab_{{ $item->id }}" data-toggle="tab">{{ $item->name }}</a>
                  <a data-toggle="dropdown" class="btn dropdown-toggle">
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="#tab-dropdown1" data-toggle="modal" data-target="#modal-choose-chart" data-idDashboard="{{ $item->id }}">Add To Dashboard</a></li>
                    <li><a id="delete-dashboard-{{ $item->id }}">Delete Dashboard</a></li>
                  </ul>
                </li>
              @endforeach
                <li class="pull-right"><a href="#" data-toggle="modal" data-target="#modal-insert-dashboard" class=""><i class="fa fa-plus"></i> Tambah Dashboard</a></li>
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
                            <button type="button" id="fullscreen" class="btn btn-box-tool" data-toggle="tooltip"
                                    title="Full Scree n">
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
            <label class="control-label col-sm-3">Pilih Survey</label>
            <div class="col-sm-9">
                <select class="form-control">
                    @foreach ($surveys as $item)
                      <option name="survey" value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
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
            <div class="col-md-4 align-self-center">
              <!-- Default box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Grafik 6</h3>

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

            <div class="col-md-4 align-self-center">
              <!-- Default box -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Grafik 6</h3>

                  <div class="box-tools pull-right">
                  </div>
                </div>
                <div class="box-body">
                  Grafik Here2
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
                  <h3 class="box-title">Grafik 6</h3>

                  <div class="box-tools pull-right">
                  </div>
                </div>
                <div class="box-body">
                  Grafik Here
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
      <form action="{{ route('dashboard.post.chart') }}" method="post" autocomplete="off" class="form-horizontal">
        <div class="modal-header">
            <div class="form-group">
              <label for="inputEmail3" class="col-sm-3 control-label">Survey</label>
              <div class="col-sm-9">
                <input type="hidden" class="form-control" id="id_dashboard" name="id_dashboard">
                <input type="text" class="form-control" id="survey" placeholder="Survey" name="name">
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
              <select class="form-control" name="survey">
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
              <select class="form-control" name="survey2">
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
  {{--<script src="{{ asset('js/pages/dashboard/sweetalert2.all.min.js')}}"></script> dipindah ke global theme plugin --}}

@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
  <script>
    $('#modal-choose-chart').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget) // Button that triggered the modal
      var idDashboard = button.data('iddashboard') // Extract info from data-* attributes
      // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
      // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
      var modal = $(this)
      modal.find('#id_dashboard').val(idDashboard)
    })
  </script>
  <script>
  var marksCanvas = document.getElementById("grafik-compare");
  var marksData = {
    labels: @php echo json_encode($labels) @endphp,
    datasets: [{
      label: "Survey 1",
      backgroundColor: "rgba(200,0,0,0.5)",
      data: @php echo json_encode($level) @endphp
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

  var radarChart2 = new Chart(marksCanvas2, {
    type: 'radar',
    data: marksData2
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
                data: { _token: CSRF_TOKEN, 'dashboard_id': {{ $item->id }} },
                dataType: "JSON",
                success: function (response) {
                  if(response==1){
                      Swal(
                      'Deleted!',
                      'Dashboard has been deleted Successfully!',
                      'success'
                    )
                    window.location.href = base_url;
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
          })
        });
      });
      
    </script>
  @endforeach

  @foreach ($dashboards as $item)
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

<script>
    var userid = [];
    jQuery(document).ready(function(){
      jQuery('#ajaxSubmit').click(function(e){
          e.preventDefault();
          
          $.each($("#share_to option:selected"), function(){            
            userid.push($(this).val());
          });
          // console.log(userid);
          var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
          jQuery.ajax({
            url: base_url+'/ajax_share_to',
            method: 'post',
            data: { "_token" : CSRF_TOKEN,
                    'userid': $('#share_to').val()
            },
            success: function(result){
                jQuery('.alert').show();
                jQuery('.alert').html(result.success);
            }
          });
        });
      });
  </script>
  @endforeach

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
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop