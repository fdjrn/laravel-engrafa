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
  <h1>Assessment</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="{{route('assessment')}}"><i class="fa fa-files-o"></i> Assessment</a></li>
@stop


@section('body-inner-content')
<div class="row">

  <div class="col-md-12">

    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Assessment List</a></li>
        <li class="nav-add-button pull-right" title="Create New"><button id="mn_create_new_team" class="btn"><i class="fa fa-plus-circle"></i>&nbsp;<span>Create New</span></button></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">  
          <div class="table-responsive">
            @if($listSurvey)     
            <table id="table_edm" class="table table-hover" data-toggle="table" data-click-to-select="true">
              <thead>
                  <th>Assessment Name</th>
                  <th>Ownership</th>
                  <th>Expire Date</th>
                  <th>Creator</th>
                  <th>Action</th>
              </thead>
              <tbody>
                @foreach($listSurvey as $index => $survey)
                <tr>
                  <td>
                    <a href="{{route('survey',['id'=> $survey->id])}}">
                      <i class="fa fa-file-text-o"></i>&nbsp;<span>{{$survey->name}}</span>
                    </a>
                  </td>
                  <td>{{$survey->ownership}}</td>
                  <td><i class="fa fa-calendar-times-o"></i>&nbsp;{{date('d M Y', strtotime($survey->expired))}}</td>
                  <td>{{$survey->created_by}}</td>
                  @if($survey->ownership == 'CREATOR')
                    <td>
                      <button type="button" class="btn btn-danger" data-toggle="tooltip" title="Delete Survey" id="btn_delete" onClick="confirmDeleteSurvey('{{$survey->id}}')">
                        <i class="fa fa-times"></i>
                      </button>
                    </td>
                  @endif
                </tr>
                @endforeach
              </tbody>
            </table>
            @else     
            <table class="table table-hover table-condensed" data-toggle="table" data-click-to-select="true">
              <thead>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Analyze</th>
                  <th>More</th>
              </thead>
              <tbody>
                <tr>
                  <td colspan="4" class="text-center">No Pending Process Available</td>
                </tr>
              </tbody>
            </table>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('body-modals')
  <!-- #include('survey.survey-invite-modal') -->
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
{{ Html::script('js/pages/survey.js')}}
{{ Html::script('js/pages/survey/survey.aggregate.js')}}
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop