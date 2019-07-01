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
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
          <strong>{{ $message }}</strong>
      </div>
    @endif

    @if ($message = Session::get('error'))
      <div class="alert alert-danger alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button> 
        <strong>{{ $message }}</strong>
      </div>
    @endif
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
        
        <div class="col-xs-12 clearfix">
          <a id="create-new-backup-button" href="{{ url('setting/backup/create') }}" class="btn btn-primary pull-right"
             style="margin-bottom:2em;"><i
                  class="fa fa-plus"></i> Create New Backup
          </a>
        </div>

        <div class="col-md-12">
            @if (count($backups))
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>File</th>
                        <th>Size</th>
                        <th>Created</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($backups as $backup)
                        <tr>
                            <td>{{ $backup['file_name'] }}</td>
                            <td>{{ $backup['file_size'] }}</td>
                            <td>{{ date('d-m-Y g:ia', $backup['last_modified']) }}</td>
                            <td class="text-left">
                                <a class="btn btn-xs btn-default btn-restore"
                                   data-hrefurl="{{ url('setting/backup/restore/'.$backup['file_name']) }}" style="background-color:#119B82; color:#FCFFFC; border-color:#119B82" ><i class="fa fa-refresh"></i>
                                    Restore</a>
                                <a class="btn btn-xs btn-default"
                                   href="{{ url('setting/backup/download/'.$backup['file_name']) }}" style="background-color:#119B82; color:#FCFFFC; border-color:#119B82"><i
                                        class="fa fa-cloud-download"></i> Download</a>
                                <a class="btn btn-xs btn-danger" data-button-type="delete"
                                   data-hrefurl="{{ url('setting/backup/delete/'.$backup['file_name']) }}"><i class="fa fa-trash-o"></i>
                                    Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="well">
                    <h4>There are no backups</h4>
                </div>
            @endif
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
                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">List Backup</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th>Name</th>
                          <th>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                          <td><i class="fa fa-database fa-fw"></i>Some Backup</td>
                          <td>Date</td>
                        </tr>
                        <tr>
                          <td><i class="fa fa-database fa-fw"></i>Some Backup</td>
                          <td>Date</td>
                        </tr>
                        <tr>
                          <td><i class="fa fa-database fa-fw"></i>Some Backup</td>
                          <td>Date</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Name</th>
                          <th>Date</th>
                        </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Oke</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="list_restore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">List Backup</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">List Restore</h3>
                      <h5 class="pull-right">Checklist All</h5>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                          <th>Data</th>
                          <th>Date</th>
                          <th>Checklist</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td><i class="fa fa-database fa-fw"></i>Some Backup</td>
                          <td>Date</td>
                          <th><input type="checkbox" value=""></th>
                        </tr>
                        <tr>
                          <td><i class="fa fa-database fa-fw"></i>Some Backup</td>
                          <td>Date</td>
                          <th><input type="checkbox" value=""></th>
                        </tr>
                        <tr>
                          <td><i class="fa fa-database fa-fw"></i>Some Backup</td>
                          <td>Date</td>
                          <th><input type="checkbox" value=""></th>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                          <th>Name</th>
                          <th>Date</th>
                          <th>Checklist</th>
                        </tr>
                        </tfoot>
                      </table>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Restore to Computer / Drive</button>
              <button type="button" class="btn btn-primary" data-dismiss="modal">Restore to Application</button>
            </div>
          </div>
        </div>
      </div>

      <div class="modal fade" id="scan_restore" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Restore</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="box">
                    <div class="box-header">
                      <h3 class="box-title">Restore</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">

                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Scan</button>
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
    <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
    @include('sweet::alert')
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
<script>
    jQuery(document).ready(function($){
        $('.btn-danger').on('click',function(){
            var getLink = $(this).attr('data-hrefurl');
            swal({
              title: 'Hapus data ?',
              //text: "Klik Hapus untuk menghapus data !",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Hapus'
            }).then((result) => {
              if (result.value) {
                window.location.href = getLink;
              }
            })

            return false;
        });

        $('.btn-restore').on('click',function(){
            var getLink = $(this).attr('data-hrefurl');
            swal({
              title: 'Restore Database ?',
              //text: "Klik Hapus untuk menghapus data !",
              type: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Restore'
            }).then((result) => {
              if (result.value) {
                window.location.href = getLink;
              }
            })

            return false;
        });
    });
</script>
@stop