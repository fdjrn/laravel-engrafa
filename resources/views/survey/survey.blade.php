@extends('layouts.template')

@section('doc_title', isset($documentTitle) ? $documentTitle : 'Document Title')

@section('doc_desc', isset($documentDescription) ? $documentDescription : 'Document Description')

@section('global-mandatory-styles')
@stop

@section('page-level-plugin-styles')
<link rel="stylesheet" type="text/css" href="{{ asset('colorselector/lib/bootstrap-colorselector-0.2.0/css/bootstrap-colorselector.css')}}" />
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

  <div class="col-md-6">
    <div class="box box-primary ">
      <div class="box-header with-border">
        <h4>
          <i class="fa fa-angle-left fa-fw"></i>
          Some Text
          <span class="pull-right">
            <i class="fa fa-list fa-fw"></i>
            <i class="fa fa-clone"></i>
          </span>
        </h4>
      </div>
      <div class="box-body">
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
            <th>Date Modified</th>
            <th>Responses</th>
            <th>Analyze</th>
            <th>Share</th>
            <th>More</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td><input type="checkbox"></td>
            <td>
              <div>
                <a href="{{ route('survey.choose.answer') }}">
                  <p>
                    Survey 01
                  </p>
                  <h6>Created 03/08/2018</h6>
                </a>
              </div>
            </td>
            <td>Some Text</td>
            <td>169</td>
            <td class="text-center">
              <i class="fa fa-bar-chart"></i>
            </td>
            <td class="text-center">
              <i class="fa fa-share"></i>
            </td>
            <td class="text-center">
              <i class="fa fa-trash fa-fw"></i>
              <i class="fa fa-edit"></i>
            </td>
          </tr>

          <tr>
            <td><input type="checkbox"></td>
            <td>
              <div>
                <a href="{{ route('survey.choose.answer') }}">
                  <p>
                    Survey 02
                  </p>
                  <h6>Created 03/08/2018</h6>
                </a>
              </div>
            </td>
            <td>Some Text</td>
            <td>30</td>
            <td class="text-center">
              <i class="fa fa-bar-chart"></i>
            </td>
            <td class="text-center">
              <i class="fa fa-share"></i>
            </td>
            <td class="text-center">
              <i class="fa fa-trash fa-fw"></i>
              <i class="fa fa-edit"></i>
            </td>
          </tr>

          <tr>
            <td><input type="checkbox"></td>
            <td>
              <div>
                <a href="{{ route('survey.choose.answer') }}">
                  <p>
                    Survey 03
                  </p>
                  <h6>Created 03/08/2018</h6>
                </a>
              </div>
            </td>
            <td>Some Text</td>
            <td>12</td>
            <td class="text-center">
              <i class="fa fa-bar-chart"></i>
            </td>
            <td class="text-center">
              <i class="fa fa-share"></i>
            </td>
            <td class="text-center">
              <i class="fa fa-trash fa-fw"></i>
              <i class="fa fa-edit"></i>
            </td>
          </tr>

          <tr>
            <td><input type="checkbox"></td>
            <td>
              <div>
                <a href="{{ route('survey.choose.answer') }}">
                  <p>
                    Survey 04
                  </p>
                  <h6>Created 03/08/2018</h6>
                </a>
              </div>
            </td>
            <td>Some Text</td>
            <td>43</td>
            <td class="text-center">
              <i class="fa fa-bar-chart"></i>
            </td>
            <td class="text-center">
              <i class="fa fa-share"></i>
            </td>
            <td class="text-center">
              <i class="fa fa-trash fa-fw"></i>
              <i class="fa fa-edit"></i>
            </td>
          </tr>
        </table>
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        
      </div>
    </div>
  </div>
  <div class="col-md-3">
    @include('survey.nav-right-survey')
  </div>
</div>
@stop

@section('body-modals')
<div class="modal fade" id="new-survey">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
         <h4>Survey
        </h4>
      </div>
      <form class="form-horizontal">
        <div class="modal-header">
           New Survey Name
           <div class="pull-right">
              <select id="colorselector">
                <option value="106" data-color="#A0522D">sienna</option>
                <option value="47" data-color="#CD5C5C" selected="selected">indianred</option>
                <option value="87" data-color="#FF4500">orangered</option>
                ...
                <option value="15" data-color="#DC143C">crimson</option>
                <option value="24" data-color="#FF8C00">darkorange</option>
                <option value="78" data-color="#C71585">mediumvioletred</option>
            </select>
           </div>
           </h4>
        </div>
      
        <div class="modal-body">
              <!-- select -->
              <div class="form-group">
                <label class="control-label col-sm-3">Survey Category</label>
                <div class="col-sm-9">
                  <select class="form-control" placeholder="Choose">
                    <option>Community</option>
                    <option>Education</option>
                    <option>Event</option>
                    <option>Other</option>
                  </select>
                </div>
              </div>
              <!-- form-group -->

              <!-- select -->
              <div class="form-group">
                <label class="control-label col-sm-3">Survey To</label>
                <div class="col-sm-9">
                  <select class="form-control" placeholder="Choose">
                    <option>All</option>
                    <option>Team</option>
                  </select>
                </div>
              </div>
              <!-- form-group -->

              <div class="form-group">
                <div class="col-sm-3"></div>
                <div class="col-sm-9">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox">
                      Questions are already written
                    </label>
                  </div>
                </div>
              </div>
              <!-- form-group -->
        <div class="modal-footer">
          <a href="{{route('survey.add.question')}}">
            <button type="button" class="btn btn-primary pull-right" >OK</button>
          </a>
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
<script src="{{ asset('colorselector/lib/bootstrap-colorselector-0.2.0/js/bootstrap-colorselector.js')}}"></script>

<script>
    $('#colorselector').colorselector();
</script>

@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop