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

    .priorities{
      width: 50px; 
      height: 50px; 
      vertical-align: middle;
      border:solid 4px #dd4b39;
      border-radius:100%;
      -webkit-border-radius: 100%;
      -moz-border-radius: 100%;
    }

    .priorities > h4{
      font-weight: bold;
    }
  </style>
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
@stop

@section('page-header') 
  <h1>Setting</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="{{route('setting')}}"><i class="fa fa-user"></i> Profile</a></li>
@stop


@section('body-inner-content')
<div class="row">
  <div class="col-md-3">
    @include('setting.nav-left')
  </div>
  <div class="col-md-9">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Profile</h4>
      </div>
      <div class="box-body">
      </div>
      <div class="box-footer">
      </div>
    </div>
  </div>
</div>
@stop

@section('body-modals')
<div class="modal fade" id="m_new_task">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create New Task</h4>
      </div>
      <div class="modal-body">
        <form name="form_n_task" action="{{route('survey.task.store')}}" method="post" id="form_n_task">
          {{ csrf_field() }}
          <div class="row">
            <div class="col-lg-12">
              <div class="form-group">
                  <div class='input-group'>
                    <input type="text" id="i_n_name_task" name="i_n_name_task" class="form-control" placeholder="New Task Name">
                      <span class="input-group-addon">
                        <select name="i_n_color" class="colorselector">
                          <option value="A0522D" data-color="#A0522D">sienna</option>
                          <option value="CD5C5C" data-color="#CD5C5C" selected="selected">indianred</option>
                          <option value="FF4500" data-color="#FF4500">orangered</option>
                          ...
                          <option value="DC143C" data-color="#DC143C">crimson</option>
                          <option value="FF8C00" data-color="#FF8C00">darkorange</option>
                          <option value="C71585" data-color="#C71585">mediumvioletred</option>
                        </select>
                      </span>
                      <div class="pull-right">
                        <select name="i_n_priority" class="form-control select2">
                          <option value="3-Low" selected="selected">!</option>
                          <option value="2-Medium">!!</option>
                          <option value="1-High">!!!</option>
                        </select>
                      </div>
                  </div>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="form-group">
                <label for="i_n_due_date">Task Due Date</label>
                <div class='input-group date' id='i_n_due_date'>
                    <input name="i_n_due_date" type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
              <div class="form-group">
                <label for="i_n_assignee">Assigned</label>
                  <select id="i_n_assignee" name="i_n_assignee" class="form-control select2" data-placeholder="Add Participants" style="width: 100%;">
                  </select>
              </div>
              <div class="form-group">
                <label for="i_n_participant">Participants</label>
                <select id="i_n_participant" name="i_n_participant[]" class="form-control select2" multiple="multiple" data-placeholder="Add Participants" style="width: 100%;">
                </select>
              </div>
              <div class="form-group">
                <label for="i_n_due_date">Detail</label>
                <textarea name="i_n_detail" style="width:100%; resize: vertical;"></textarea>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i></button>
        <button type="submit" form="form_n_task" class="btn btn-primary"><i class="fa fa-check"></i></button>
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
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop