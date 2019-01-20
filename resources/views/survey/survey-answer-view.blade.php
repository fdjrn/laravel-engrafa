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
  <h1>Assessment</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="{{route('survey',['id'=> $survey_id])}}"><i class="fa fa-files-o"></i> Assessment</a></li>
  <li>View</li>
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
    <div class="row">
      <div class="col-md-9">
        @if(!$levels)
          <div class="box box-primary">
            <div id="question" class="box-body collapse in">
              <span>No Data Found</span>
            </div>
          </div>
        @else
          <form name="form_q_survey">
          {{ csrf_field() }}
          @foreach($levels as $index => $level)
            <div class="box box-primary collapsed-box">
              <div class="box-header">
                <a href="#" data-widget="collapse">
                  <h4 style="margin:2px 0px;">Level {{$index}}</h4>
                </a>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                  </button>
                </div>
              </div>

              <div id="question" style="display: none;" class="box-body collapse in form-horizontal">
                <div class="form-group">
                  <label for="i_n_surveyor" class="col-sm-2 control-label">Objective</label>

                  <div class="col-sm-10">
                    <div style="border: solid thin #d2d6de; padding:4px;">
                      <span style="font-weight: normal;">{{ $levels[$index]['surveys']->first()->purpose }}</span>
                    </div>
                  </div>
                </div>
                @foreach($level['surveys'] as $idx => $survey)
                  <div class="form-group">
                    <label for="i_n_surveyor" class="col-sm-2 control-label">Criteria</label>

                    <div class="col-sm-10">
                      <div style="border: solid thin #d2d6de; padding: 6px 12px;">
                        <div style="border: solid thin #d2d6de; padding:4px;">
                          {{ $survey->outcome }}&nbsp;&nbsp;<span style="font-weight: normal;">{{$survey->description }}</span>
                        </div>
                        <div style="border: solid thin #d2d6de; padding:4px; margin-top: 4px; max-height: 100px; overflow-y: auto;">
                          Comment&nbsp;&nbsp;<span style="font-weight: normal;">{{ $survey->comment ? $survey->comment : '-' }}</span>
                        </div>
                        <div class="row" style="margin-top: 4px;">
                          <div class="col-sm-3">
                            <div>
                              <input type="radio" name="metcriteria[{{$survey->id}}]" value="{{$survey->met_criteria}}" checked disabled> {{ $survey->met_criteria ? ucfirst($survey->met_criteria) : '-'}}
                            </div>
                          </div>
                          <div class="col-sm-9">
                            <div class="pull-left" style="margin-left: 10px; margin-right: 20px; margin-top: 3px;">
                              @if($survey->acceptance)
                                <input type="radio" name="acceptance[{{$survey->id}}]" value="{{$survey->acceptance}}" checked disabled> {{ucfirst($survey->acceptance)}}
                              @else
                                <input type="radio" name="acceptance[{{$survey->id}}]" value="" disabled> Not Checked Yet
                              @endif
                            </div>
                            <div class="clearfix" style="border: solid thin #d2d6de; padding: 10px 12px; padding-bottom: 4px;">
                              <div class="pull-left">
                                <h4 style="margin-top: 0; margin-bottom: 0;">
                                  <i class="fa fa-file-pdf-o text-red"></i>&nbsp;&nbsp;
                                  <i class="fa fa-file-word-o text-blue"></i>&nbsp;&nbsp;
                                  <i class="fa fa-file-excel-o text-green"></i>
                                </h4>
                                <h5 style="margin-top: 0; margin-bottom: 0;">Document Support</h5>
                              </div>
                              <div class="pull-right">
                                <a onclick="getWP('{{ $survey->id }},{{ $survey_id }}')" class="btn btn-default"><i class="fa fa-eye"></i></a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="note" class="col-sm-2 control-label">Note</label>

                    <div class="col-sm-10">
                        <div style="border: solid thin #d2d6de; padding:4px; margin-top: 4px; max-height: 100px; overflow-y: auto;">
                          <span style="font-weight: normal;">{{ $survey->note ? $survey->note: '-' }}</span>
                        </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @endforeach
          </form>
        @endif
      </div>
      <div class="col-md-3">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4>
              History Version
            </h4>
          </div>
          <div class="box-body">
            @foreach($survey_members as $survey_member)
              <p><small class="label bg-green">&nbsp;&nbsp;&nbsp;&nbsp;</small>&nbsp;<span>{{ $survey_member->username }}</span></p>
            @endforeach
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop

@section('body-modals')
  <div class="modal fade" id="m_u_file">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-file"></i>&nbsp;Working Product <span id="wp-title" style="font-weight: bold;"></span></h4>
        </div>
        <input type="hidden" id="curWP">
        <input type="hidden" id="curTyp" value="view">
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover no-margin" id="table-wp" style=" width: 100% !important;">
              <thead>
                <tr>
                  <td style="width:100px;">WP ID</td>
                  <td style="width:350px;">Description</td>
                  <td>File</td>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  @include('survey.survey-invite-modal')
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
<script src="{{ asset('js/pages/survey/answer.js')}}"></script>
{{ Html::script('js/pages/survey.js')}}
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