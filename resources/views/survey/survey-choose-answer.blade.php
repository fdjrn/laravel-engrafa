@extends('layouts.template')

@section('doc_title', isset($documentTitle) ? $documentTitle : 'Document Title')

@section('doc_desc', isset($documentDescription) ? $documentDescription : 'Document Description')

@section('global-mandatory-styles')
@stop

@section('page-level-plugin-styles')
<!-- bootstrap slider -->
<link rel="stylesheet" href="{{ asset('theme/AdminLTE/plugins/bootstrap-slider/slider.css')}}">
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

  <div class="col-md-6">
    <div class="box box-primary ">
      <div class="box-header with-border">
        <h4>
          <i class="fa fa-angle-left fa-fw"></i>
          Preview
        </h4>
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
      </div>

      <div class="box-body">
        <div class="box box-primary ">
          <div class="box-header with-border">
            <a data-toggle="collapse" href="#question">
              <h4>
                Survey 01
                <span class="pull-right">
                  Team 02
                </span>
              </h4>
            </a>
          </div>
          
          <div id="question" class="collapse in">
            <div class="box-body">
              <ol style="margin-left:-25px">
                <li> Question 1 ?
                  <ul class="list-unstyled">
                    <li><input type="radio" name="question-1-radio"> Yes</input></li>
                    <li><input type="radio" name="question-1-radio"> No</input></li>
                  </ul>
                </li>
                <li> Question 2 ?
                  <ul class="list-unstyled">
                    <li>
                      <input type="text" value="" class="slider form-control" data-slider-min="-200" data-slider-max="200"
                         data-slider-step="5" data-slider-value="[-100,100]" data-slider-orientation="horizontal"
                         data-slider-selection="before" data-slider-tooltip="show" data-slider-id="red">
                    </li>
                  </ul>
                </li>
                <li> Question 3 ?</li>
                <li> Question 4 ?</li>
                <li> Question 5 ?</li>
              </ol>
            </div>
          </div>

        </div>
      </div>
      
    </div>
  </div>
  <div class="col-md-3">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>
          <i class="fa fa-usb fa-fw"></i>
          Survey 01
          <span class="pull-right">
            <i class="fa fa-angle-double-right"></i>
          </span>
        </h4>
      </div>
      <div class="box-body">
        
          <div class="box box-primary">
            <div class="box-header with-border">
              <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#file-group" href="#collapseOne">
                  Description
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="collapse in">
              <div class="box-body">
                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3
                wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum
              </div>
              <div class="box-footer">
                
              </div>
            </div>
          </div>

          <div class="box box-primary">
            <div class="box-header with-border">
              <h4 class="box-title">
                <a data-toggle="collapse" data-parent="#file-group" href="#collapseTwo">
                  15:00 10 Juli 2018
                </a>
              </h4>
            </div>
            <div id="collapseTwo" class="collapse in">
              <div class="box-body text-center">
                <span>Many</span>
                <br />
                <h3>89</h3>
                <br />
                <span>FollowApp</span>
              </div>
              <div class="box-footer text-center">
                <span>
                  Created By : 
                  <i class="fa fa-user"></i>
                  User 1
                </span>
              </div>
            </div>
          </div>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
      </div>
    </div>
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
<script src="/theme/AdminLTE/plugins/bootstrap-slider/bootstrap-slider.js"></script>
<script>
  $(function () {
    /* BOOTSTRAP SLIDER */
    $('.slider').slider()
  })
</script>
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop