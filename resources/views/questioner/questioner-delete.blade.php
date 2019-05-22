@extends('layouts.template')

@section('doc_title', isset($documentTitle) ? $documentTitle : 'Document Title')

@section('doc_desc', isset($documentDescription) ? $documentDescription : 'Document Description')

@section('global-mandatory-styles')
@stop

@section('page-level-plugin-styles')
    {{ Html::style('css/material.min.css')}}
    {{ Html::style('css/dataTables.material.min.css') }}
    {{ Html::style('css/dropzone.min.css') }}
    {{--{{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/dropzone.css') }}--}}
@stop

@section('theme-global-styles')
@stop

@section('page-level-styles')
    <style>
        .eng-modal-dialog-centered{
            display: inline-block;
            text-align: left;
            vertical-align: middle;
        }

        .eng-modal {
            text-align: center;
            padding: 0!important;
        }

        .eng-modal:before {
            content: '';
            display: inline-block;
            height: 100%;
            vertical-align: middle;
            margin-right: -4px;
        }

        .mdl-data-table th {
            vertical-align: bottom;
            text-overflow: ellipsis;
            font-weight: inherit;
            line-height: 24px;
            letter-spacing: 0;
            font-size: inherit;
            color: inherit;
            padding-bottom: 8px;
        }

        .mdl-data-table td {
            border-top: 1px solid rgba(0,0,0,.12);
            border-bottom: 1px solid rgba(0,0,0,.12);
            padding-top: 12px;
            vertical-align: middle;
            font-weight: 400;
            font-size: inherit;
        }

        .custom-dropdown-btn > ul {
            width: inherit;
        }

        .header-cursor {
            cursor: pointer;
        }

        .table-responsive tbody td{
            font-size: inherit;
            font-weight: normal;
        }

    </style>
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
<script>
    var QUESTIONER_DETAIL = {!! json_encode($questioner) !!};
</script>
@stop

@section('page-header')
    <h1>Quisioner</h1>
@stop

@section('page-breadcrumb')
    <li><a class="active" href="{{route('quisioner.list')}}"><i class="fa fa-file"></i>Quisioner</a></li>
@stop


@section('body-inner-content')
    <div class="row">

        {{-- begin side menu kuesioner --}}
        <div class="col-md-3">
            @include('questioner.nav-left')
        </div>
        {{-- end side menu kuesioner --}}

        {{-- Main view (Center) --}}
        <div class="col-md-9">
            <div class="box box-primary ">

                {{-- Header--}}
                <div class="box-header with-border">
                    <h4>
                        <i class="fa fa-angle-left fa-fw header-cursor" id="main-back"></i>
                        <label class="header-cursor">Delete Quisioner</label>
                        <span class="pull-right">
                            <i class="fa fa-clone"></i>
                        </span>
                    </h4>
                </div>

                <form id="form_delete_questioner" role="form"{{-- method="POST" action="{{route('quisioner.create')}}" --}} >
                    {{-- Main grid--}}
                    <div class="box-body" id="box-body">
                    
                        {{--  @csrf --}}

                            <div class="row form-group">
                                <label for="c_questioner_name" class="col-sm-3 control-label" style="text-align:left;">Quisioner Name</label>
                                <div class="col-sm-8">
                                    <input type="text" id="c_questioner_name" name="c_questioner_name" class="form-control" placeholder="New Quisioner Name" value="{{ $questioner->name }}" readonly="true">
                                    <input type="hidden" id="c_questioner_id" name="c_questioner_id" class="form-control" placeholder="New Quisioner Name" value="{{ $questioner->id }}">
                                    <!-- <span class="error" id="error_name">This field is required</span> -->
                                </div>
                                <span class="help-block"> </span>
                            </div>

                            <div class="row form-group">
                                <label for="c_questioner_category" class="col-sm-3 control-label" style="text-align:left;">Quisioner Category</label>
                                <div class="col-sm-8">
                                    <select id="c_questioner_category" name="c_questioner_category" class="form-control select2" data-placeholder="Quisioner Category" style="width: 100%;" disabled="true">
                                        <option value=""></option>
                                        <option value="1" @if($questioner->category == 1)
                                                            selected
                                                          @endif>Community</option>
                                        <option value="2" @if($questioner->category == 2)
                                                            selected
                                                          @endif>Education</option>
                                        <option value="3" @if($questioner->category == 3)
                                                            selected
                                                          @endif>Event</option>
                                        <option value="4" @if($questioner->category == 4)
                                                            selected
                                                          @endif>Other</option>
                                    </select>
                                </div>
                                <span class="help-block"> </span>
                            </div>

                            <div class="row form-group">
                                <label for="c_qeustioner_category" class="col-sm-3 control-label" style="text-align:left;"></label>
                                <div class="col-sm-8">
                                    <button type="button" class="btn btn-default pull-left" id="btn_add_question" disabled="true"><!--<i class="fa fa-times"></i>--> Add Question</button>
                                </div>
                            </div>                        
                        
                    </div>

                    <div class="box-footer"> 
                        <button type="button" class="btn btn-default pull-left" id="btn_cancel_delete"><!--<i class="fa fa-times"></i>--> Cancel</button>
                        <button type="submit" id="btn_save_delete_quisioner" class="btn btn-primary pull-right"><!--<i class="fa fa-check"></i>-->Delete</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@stop

@section('body-modals')

    @include('layouts.part.file-management-modal')
    
    <!-- Create/Update Description -->
    <!-- Modal -->
    <div id="modal2" class="modal eng-modal fade " role="dialog">
        <div class="modal-dialog eng-modal-dialog-centered">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><span><i class="fa fa-file "></i> File Description</span></h4>
                </div>
                <div class="modal-body">
                    <textarea style="width: -moz-available; font-weight: normal;" rows="4"></textarea>
                </div>
                <div class="modal-footer">
                    {!! Form::button('Cancel', ['class' => 'btn btn-default','data-dismiss'=>'modal']) !!}
                    {!! Form::button('Save', ['class' => 'btn btn-info','id'=>'btn-file-descr']) !!}
                </div>
            </div>

        </div>
    </div>
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
    @include('questioner.questioner-create-modal')
    @include('questioner.questioner-create-question-modal')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
    {{ Html::script('js/jquery.dataTables.min.js') }}
    {{ Html::script('js/dataTables.material.min.js') }}
    {{--{{ Html::script('js/dropzone.min.js') }}--}}
    {{--{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/dropzone.js') }}--}}
    {{ Html::script('js/pages/kuesioner/kuesioner-delete.js') }}
@stop

@section('theme-layout-scripts')
@stop

@section('page-specific-scripts')
@stop