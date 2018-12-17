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
  <h1>Survey</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="{{route('survey.task',['id' => $survey_id])}}"><i class="fa fa-check-square-o"></i> Task</a></li>
@stop


@section('body-inner-content')
<div class="row">
  <div class="col-md-3">
    @include('survey.nav-left-survey')
  </div>

  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs pull-right">
        <li class="crud-button"><a href="#" onClick="openModals('create','0')"><i class="fa fa-plus-circle"></i></a></li>
        <li><a href="#tab_2" data-toggle="tab">Completed</a></li>
        <li class="active"><a href="#tab_1" data-toggle="tab">Assigned</a></li>
        <li class="pull-left header">Team Task</li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <div class="table-responsive">
            <table class="table no-margin" border="0">
              <tbody>
                @foreach($tasks as $task)
                  @if($task->progress < 100)
                    <tr>
                      <td style="vertical-align: middle; text-align: left;">
                        <div style="position: relative; width:200px;"><canvas class="pieChart" width="200" height="110" data-progress="{{$task->progress}}" data-color="{{$task->color}}"></canvas></div>
                      </td>
                      <td style="vertical-align: middle; width:70%;">
                        <div class="row">
                          <div class="col-lg-12"><a href="#" onClick="openModals('edit','{{$task->id}}')"><h4>{{$task->name}}</h4></a></div>
                          <div class="col-lg-12"><p><i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{$task->due_dates}}</p></div>
                          <div class="col-lg-12"><p><i class="fa fa-user"></i>&nbsp;&nbsp;{{$task->username}}</p></div>
                        </div>
                      </td>
                      <td style="vertical-align: middle; text-align: center;  width:30%;">
                       <div class="priorities" data-toggle="tooltip" title="{{explode('-',$task->priority)[1]}}">
                        <h4>{{$priorities[$task->priority]}}</h4>
                       </div>
                      </td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="tab-pane" id="tab_2">
          <div class="table-responsive">
            <table class="table no-margin" border="0">
              <tbody>
                @foreach($tasks as $task)
                  @if($task->progress == 100)
                    <tr>
                      <td style="vertical-align: middle; text-align: left;">
                        <div style="position: relative; width:200px;"><canvas class="pieChart" width="200" height="110" data-progress="{{$task->progress}}" data-color="{{$task->color}}"></canvas></div>
                      </td>
                      <td style="vertical-align: middle; width:70%;">
                        <div class="row">
                          <div class="col-lg-12"><a href="#"><h4>{{$task->name}}</h4></a></div>
                          <div class="col-lg-12"><p><i class="fa fa-calendar-check-o"></i>&nbsp;&nbsp;{{$task->due_dates}}</p></div>
                          <div class="col-lg-12"><p><i class="fa fa-user"></i>&nbsp;&nbsp;{{$task->username}}</p></div>
                        </div>
                      </td>
                      <td style="vertical-align: middle; text-align: center;  width:30%;">
                       <div class="priorities" data-toggle="tooltip" title="{{explode('-',$task->priority)[1]}}">
                        <h4>{{$priorities[$task->priority]}}</h4>
                       </div>
                      </td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="col-md-3">
    @#include('survey.nav-right-survey')
  </div> -->
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
                    <input type="hidden" id="i_n_survey_id" name="i_n_survey_id" value="{{$survey_id}}">
                    <input type="text" id="i_n_name_task" name="i_n_name_task" class="form-control" placeholder="New Task Name">
                      <span class="input-group-addon">
                        <select id="i_n_color" name="i_n_color" class="colorselector">
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
                        <select id="i_n_priority" name="i_n_priority" class="form-control select2">
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
                <div class='input-group date'>
                    <input id="i_n_due_date" name="i_n_due_date" type='text' class="form-control" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
              </div>
              <div class="form-group">
                <label for="i_n_assignee">Assignee</label>
                  <select id="i_n_assignee" name="i_n_assignee" class="form-control select2" data-placeholder="Assign To" style="width: 100%;">
                    <option value=""></option>
                  </select>
              </div>
              <div class="form-group">
                <label for="i_n_participant">Participants</label>
                <select id="i_n_participant" name="i_n_participant[]" class="form-control select2" multiple="multiple" data-placeholder="Add Participants" style="width: 100%;">
                  <option value=""></option>
                </select>
              </div>
              <div class="form-group">
                <label for="i_n_detail">Detail</label>
                <textarea id="i_n_detail" name="i_n_detail" style="width:100%; resize: vertical;"></textarea>
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
<script src="{{ asset('js/pages/survey/task.js')}}"></script>
{{ Html::script('js/pages/survey.js')}}
<script>
</script>
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop