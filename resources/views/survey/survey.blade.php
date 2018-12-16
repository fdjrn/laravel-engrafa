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
    a.adisabled {
      cursor: default;
    }
    span.status_survey{
      cursor: pointer;
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
  <li><a class="active" href="{{url('/survey/'.$survey_id)}}"><i class="fa fa-files-o"></i> Survey</a></li>
@stop


@section('body-inner-content')
<div class="row">
  <div class="col-md-3">
    @include('survey.nav-left-survey')
  </div>

  <div class="col-md-9">
    <div class="text-center" style="background-color: #3c8dbc; border-radius: .25em; padding:1px; margin-bottom: 8px; box-shadow: 0 1px 1px rgba(0,0,0,0.3); color:#fff;">
      <h4><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;{{ $survey_name }}&nbsp;&nbsp;</h4>
    </div>
    @if($status_ownership == "CREATOR" || $status_ownership == "SURVEYOR")
      @include('survey.survey-list-creator_surveyor')
    @else
      @include('survey.survey-list-responden')
    @endif
  </div>
  <!-- <div class="col-md-3">
    @#include('survey.nav-right-survey')
  </div> -->
</div>
@stop

@section('body-modals')
  @if($status_ownership != 'RESPONDEN')
  <input type="hidden" id="s_id" value="{{$survey_id}}">
    <div class="modal fade" id="m_invite_user">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">Invite User</h4>
          </div>
          <div class="modal-body">
            <form name="form_i_user" id="form_i_user" method="POST" action="{{route('survey.invite',['id' => $survey_id])}}">
              @csrf
              <input type="hidden" name="user_id" id="user_id">
              <div class="form-group">
                <label for="inv_responden" class="control-label">Add Responden</label>
                <select id="inv_responden" name="inv_responden[]" class="form-control select2" multiple data-placeholder="Add User"
                        style="width: 100%;" >
                </select>
              </div>
              <div class="form-group">
                <label for="inv_surveyor" class="control-label">Add Surveyor</label>
                <select id="inv_surveyor" name="inv_surveyor[]" class="form-control select2" multiple data-placeholder="Add User"
                        style="width: 100%;" >
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i></button>
            <button type="submit" form="form_i_user" class="btn btn-primary"><i class="fa fa-check"></i></button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
  @endif
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
{{ Html::script('theme/AdminLTE/bower_components/chart.js2/Chart.js')}}
{{ Html::script('theme/AdminLTE/bower_components/chart.js2/Chart.min.js')}}
{{ Html::script('js/pages/survey.js')}}
{{ Html::script('js/pages/survey/survey.aggregate.js')}}
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop