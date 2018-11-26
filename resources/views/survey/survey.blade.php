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
<div class="modal fade" id="new-survey-question">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      </div>
      <!-- modal-header -->
      <form class="form-horizontal" action="{{route('survey.add.question')}}">
        <div class="modal-body">
          <div class="box-body">
              <!-- select -->
              <div class="form-group">
                <label>Question 1</label>
                <input type="text" class="form-control" placeholder="Enter your question">
                <select class="form-control" placeholder="Choose">
                  <option>Asking</option>
                  <option>Slider</option>
                  <option>Star Rating</option>
                  <option>Checkboxes</option>
                  <option>Ranking</option>
                  <option>Checkboxes</option>
                  <option>Image</option>
                  <option>Multiple Choice</option>
                </select>
              </div>
              <!-- form-group -->
          </div>
        <div class="modal-footer justify-content-start" style="text-align:center;">
          <button type="button" class="btn btn-primary pull-right">OK</button>
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
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')

@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop