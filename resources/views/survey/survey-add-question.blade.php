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
          Add Survey
        </h4>
      </div>
      <form class="form-horizontal">
        <div class="box-body" style="overflow-y: auto; height:600px;">
          <div class="box box-primary ">
            <div class="box-header with-border">
              <div class="form-group">
                <label class="control-label col-sm-3" id="title">Title</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" placeholder="Title"> 
                </div>
              </div>
            </div>
            <div class="box-body" id="box-body-question">
              <div id="demo"></div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button class="btn btn-primary" type="button" id="btn-next-question">
                <i class="fa fa-plus"></i>
                Next Question
              </button>
              <button class="btn btn-primary" type="button" id="btn-ganti-judul">
                <i class="fa fa-plus"></i>
                Ganti Judul
              </button>
            </div>
          </div>

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          
        </div>
      </form>
    </div>
  </div>
  <div class="col-md-3">
    @include('survey.nav-right-survey')
  </div>
</div>
@stop

@section('body-modals')
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')

<script type="text/javascript" src="{{ asset('app/survey/add-question.min.js')}}">
</script>

@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop