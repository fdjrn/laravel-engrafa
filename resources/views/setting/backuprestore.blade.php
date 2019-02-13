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
    <link href="{{ asset('css/bootstrap-toggle.min.css')}}" rel="stylesheet">
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
@stop

@section('page-header') 
  <h1>Setting</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="{{route('setting')}}"><i class="fa fa-users"></i> Users</a></li>
@stop


@section('body-inner-content')
<div class="row">
  <div class="col-md-3">
    @include('setting.nav-left')
  </div>
  <div class="col-md-9">
    <div class="box box-primary">
      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <h4 style="margin-left: 14px;"><a href="#"><i class="fa fa-database fa-fw"></i>&nbsp;Backup and Restore</a></h4>
          </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
    
                <h3 class="box-title">Backup</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                        <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#list_backup">List Backup</button>
                        <button type="button" class="btn btn-block btn-info">To Aplication</button>
                        <button type="button" class="btn btn-block btn-success">To Computer</button>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-6">
                <div class="box box-default">
                    <div class="box-header with-border">
        
                    <h3 class="box-title">Restore</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <button type="button" class="btn btn-block btn-info">List</button>
                        <button type="button" class="btn btn-block btn-success">New</button>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                <li class="active no-margin text-center">
                    <a href="#tab_1" data-toggle="tab">
                    <p>Setting Backup</p>
                    {{-- <span>{{$total_users}} users</span> --}}
                    </a>
                </li>
                <li class="no-margin text-center">
                    <a href="#tab_2" data-toggle="tab">
                    <p>Setting Restore</p>
                    {{-- <span>0 users</span> --}}
                    </a>
                </li>
                </ul>
                <div class="tab-content" style="padding:0;">
                <div class="tab-pane active" id="tab_1">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <input type="checkbox" checked data-toggle="toggle" data-size="mini"><h5>Auto Backup</h5>
                        </li>
                        <li class="list-group-item">
                                <input type="checkbox" checked data-toggle="toggle" data-size="mini"><h5>Always show the latest searches</h5>
                        </li>
                        <li class="list-group-item">
                            <input type="checkbox" checked data-toggle="toggle" data-size="mini"><h5>Log activity Backup</h5>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane" id="tab_2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <input type="checkbox" checked data-toggle="toggle" data-size="mini"><h5>Auto Restore</h5>
                        </li>
                        <li class="list-group-item">
                                <input type="checkbox" checked data-toggle="toggle" data-size="mini"><h5>Always show the latest searches</h5>
                        </li>
                        <li class="list-group-item">
                            <input type="checkbox" checked data-toggle="toggle" data-size="mini"><h5>Log activity Restore</h5>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('body-modals')
<div class="modal fade" id="list_backup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">List Backup</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
    <script src="{{ asset('js/bootstrap-toggle.min.js')}}"></script>
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop