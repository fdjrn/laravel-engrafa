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

  <div class="col-md-9">
    <div class="text-center" style="background-color: #3c8dbc; border-radius: .25em; padding:1px; margin-bottom: 8px; box-shadow: 0 1px 1px rgba(0,0,0,0.3); color:#fff;">
      <h4><i class="fa fa-file-text-o"></i>&nbsp;&nbsp;{{ $surveys->name }}&nbsp;&nbsp;</h4>
    </div>
    <div class="row">
      <div class="col-md-9">
        <div class="box box-primary">
          <div class="box-header">
            <a data-toggle="collapse" href="#question">
              <h4 style="margin:2px 0px;">Level 0</h4>
            </a>
          </div>

          <div id="question" class="box-body collapse in">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="i_n_surveyor" class="col-sm-2 control-label">Process</label>

                <div class="col-sm-10">
                  <input type="text" id="i_process" name="i_process" class="form-control" value="Question Cobit" readonly>
                </div>
              </div>
              <div class="form-group">
                <label for="i_n_surveyor" class="col-sm-2 control-label">Criteria</label>

                <div class="col-sm-10">
                  <div style="border: solid thin #d2d6de; padding: 6px 12px;">
                    <div style="border: solid thin #d2d6de; padding:4px;">Question 1</div>
                    <div class="row" style="margin-top: 4px;">
                      <div class="col-sm-3">
                        <div>
                          <input type="radio" name="gender" value="yes" checked> Yes<br>
                          <input type="radio" name="gender" value="no"> No
                        </div>
                      </div>
                      <div class="col-sm-9">
                        <div class="clearfix" style="border: solid thin #d2d6de; padding: 8px 12px;">
                          <div class="pull-left">
                            <h4 style="margin-top: 0; margin-bottom: 0;">
                              <i class="fa fa-file-pdf-o text-red"></i>&nbsp;&nbsp;
                              <i class="fa fa-file-word-o text-blue"></i>&nbsp;&nbsp;
                              <i class="fa fa-file-excel-o text-green"></i>
                            </h4>
                            <h5 style="margin-top: 0; margin-bottom: 0;">Document Support</h5>
                          </div>
                          <div class="pull-right">
                            <a class="btn btn-default btn-upload"><i class="fa fa-upload"></i></a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="i_n_surveyor" class="col-sm-2 control-label">Comment</label>

                <div class="col-sm-10">
                  <textarea name="i_n_detail" style="width:100%; resize: vertical;"></textarea>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h4>
              History Version
            </h4>
          </div>
          <div class="box-body">

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
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Working Product</h4>
      </div>
      <div class="modal-body">
        <form name="form_w_product" action="{{route('survey.task.store')}}" method="post" id="form_w_product">
          {{ csrf_field() }}
          <div class="table-responsive">
            <table class="table no-margin" border="0">
              <thead>
                <tr>
                  <td>WP ID</td>
                  <td>Description</td>
                  <td>File</td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>APO01</td>
                  <td>Ilorem Ipsum Dolor Sit Amet</td>
                  <td><input type="file" name="f_up"></td>
                </tr>
              </tbody>
            </table>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i></button>
        <button type="submit" form="form_w_product" class="btn btn-primary"><i class="fa fa-check"></i></button>
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
<script src="/theme/AdminLTE/plugins/bootstrap-slider/bootstrap-slider.js"></script>
<script>
  $(function () {
    /* BOOTSTRAP SLIDER */
    $('.slider').slider()
  })
  $(".btn-upload").click(function(){
    $('#m_u_file').modal('show');
  });
</script>
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop