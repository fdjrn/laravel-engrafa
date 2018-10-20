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
              <li class="dropdown btn-group">
                <a class="btn" href="#tab_1" data-toggle="tab">Dashboard</a>
                <a data-toggle="dropdown" class="btn dropdown-toggle">
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#tab-dropdown1" data-toggle="modal" data-target="#modal-choose-chart">Add To Dashboard</a></li>
                  <li><a href="#tab-dropdown2" data-toggle="tab">Delete Dashboard</a></li>
                </ul>
              </li>
              <li class="dropdown btn-group">
                <a class="btn" href="#tab_3" data-toggle="tab">Dashboard 01</a>
                <a data-toggle="dropdown" class="btn dropdown-toggle">
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="#tab-dropdown1" data-toggle="tab">Add To Dashboard</a></li>
                  <li><a href="#tab-dropdown2" data-toggle="tab">Delete Dashboard</a></li>
                </ul>
              </li>
              <li class="pull-right"><a href="#" class=""><i class="fa fa-plus"></i> Tambah Dashboard</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active container-fluid" id="tab_1">
                  <div class="row">
                    <!-- Default box -->
                      <div class="box">
                        <div class="box-header">
                          <h3 class="box-title"></h3>

                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
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
                                Grafik Here
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
                                Grafik Here
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
                                <h3 class="box-title">Grafik 3</h3>

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
                                Grafik Here
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
              <!-- /.tab-pane -->
              <div class="tab-pane active container-fluid" id="tab_3">
                  <div class="row">
                    <!-- Default box -->
                      <div class="box">
                        <div class="box-header">
                          <h3 class="box-title"></h3>

                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
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
                                <h3 class="box-title">Grafik 4</h3>

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
                                Grafik Here
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
                                <h3 class="box-title">Grafik 5</h3>

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
                                Grafik Here
                              </div>
                              <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                          </div>
                          <!-- /.col-->
                          <div class="col-md-4 align-self-center">
                            <!-- Default box -->
                            <div cla
                            ss="box box-primary">
                              <div class="box-header with-border">
                                <h3 class="box-title">Grafik 6</h3>

                                <div class="box-tools pull-right">
                                  <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                          title="Share">
                                    <i class="fa fa-share"></i></button>
                                    <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal-share"
                                          title="Edit">
                                    <i class="fa fa-gear"></i></button>
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
                        <!-- /.box-body -->
                      </div>
                      <!-- /.box -->
                  </div>
                  <!-- /.row -->
              </div>
              <!-- /.tab-pane -->
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
                  <input type="checkbox">
                  Comparison
                </label>
              </div>
            </div>
          </div>

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



@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop