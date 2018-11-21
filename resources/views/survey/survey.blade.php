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
  <li><a class="active" href="{{route('survey')}}"><i class="fa fa-files-o"></i> Survey</a></li>
@stop


@section('body-inner-content')
<div class="row">
  <div class="col-md-3">
    @include('survey.nav-left-survey')
  </div>

  <div class="col-md-9">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">Pending Survey</a></li>
        <li><a href="#tab_2" data-toggle="tab">Done</a></li>
        <li class="pull-right crud-button"><a href="#" id="b_create_new_team" class="text-success"><i class="fa fa-plus-circle"></i></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
          <!-- search form -->
          <form action="#" method="get">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                  </span>
            </div>
          </form>

          <table id="table1" class="table table-bordered table-hover" data-toggle="table" data-click-to-select="true">
            <thead>
              <tr>
                <th data-field="state" data-checkbox="true" data-formatter="stateFormatter">
                  <input type="checkbox">
                </th>
                <th>Name</th>
                <th>Type</th>
                <th>Time</th>
                <th>Level</th>
                <!-- <th>Date Modified</th> -->
                <th>Analyze</th>
                <th>More</th>
              </tr>
            </thead>
            <tbody>
              @foreach($surveys as $survey)
                <tr>
                  <td><input type="checkbox"></td>
                  <td>
                    <div>
                      <a href="{{ route('survey.choose.answer') }}">
                        <p>
                          {{$survey->name}}
                        </p>
                        <h6>Created {{$survey->created_ats}}</h6>
                      </a>
                    </div>
                  </td>
                  <!-- <td>{{$survey->updated_at}}</td> -->
                  <td>Purpose</td>
                  <td>1 minutes to Finish</td>
                  <td>-</td>
                  <td class="text-center">
                    <i class="fa fa-bar-chart"></i>
                  </td>
                  <td class="text-center">
                    <i class="fa fa-trash fa-fw"></i>
                    <i class="fa fa-edit"></i>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="tab-pane active" id="tab_2">
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