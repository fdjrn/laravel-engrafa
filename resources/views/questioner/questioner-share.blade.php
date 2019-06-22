@extends('layouts.template')

@section('doc_title', isset($documentTitle) ? $documentTitle : 'Document Title')

@section('doc_desc', isset($documentDescription) ? $documentDescription : 'Document Description')

@section('global-mandatory-styles')
@stop

@section('page-level-plugin-styles')
    {{ Html::style('css/material.min.css')}}
    {{ Html::style('css/dataTables.material.min.css') }}
    {{ Html::style('css/dropzone.min.css') }}
    {{ Html::style('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/css/bootstrap-slider.min.css') }}
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

        .slider .slider-track-low {
            background: red !important;
        }

        .rating {
            display: inline-block;
            position: relative;
            height: 50px;
            line-height: 50px;
            font-size: 50px;
        }

        .rating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            cursor: pointer;
        }

        .rating label:last-child {
            position: static;
        }

        .rating label:nth-child(1) {
            z-index: 5;
        }

        .rating label:nth-child(2) {
            z-index: 4;
        }

        .rating label:nth-child(3) {
            z-index: 3;
        }

        .rating label:nth-child(4) {
            z-index: 2;
        }

        .rating label:nth-child(5) {
            z-index: 1;
        }

        .rating label input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .rating label .icon {
            float: left;
            color: transparent;
        }

        .rating label:last-child .icon {
            color: #000;
        }

        .rating:not(:hover) label input:checked ~ .icon,
        .rating:hover label:hover input ~ .icon {
            color: #FFA500;
        }

        .rating label input:focus:not(:checked) ~ .icon:last-child {
            color: #000;
            text-shadow: 0 0 5px #09f;
        }

    </style>
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
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
                        <label class="header-cursor">Share Quisioner</label>
                        <span class="pull-right">
                            <i class="fa fa-clone"></i>
                        </span>
                    </h4>
                </div>

                <!-- <form id="form_share_questioner" role="form" > -->
                    {{-- Main grid--}}
                    <div class="box-body" id="box-body">
                        <div class="row">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="share_qeustioner_name" class="col-sm-4 control-label" style="text-align:left;">Quisioner Name</label>
                                <div class="col-sm-8">
                                  <input type="text" id="share_qeustioner_name" name="share_qeustioner_name" class="form-control" placeholder="Share Quisioner Name" value="{{ $questioner->name }}" readonly="true">
                                  <input type="hidden" id="share_qeustioner_id" name="share_qeustioner_id" value="{{ $questioner->id }}"/>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="row" style="padding-top:10px;">
                            <div class="col-lg-12">
                              <div class="form-group">
                                <label for="share_qeustioner_user" class="col-sm-4 control-label" style="text-align:left;">Share To</label>
                                <div class="col-sm-8">
                                  <select id="share_qeustioner_user" name="share_qeustioner_user" class="form-control select2" data-placeholder="Share To"
                                          style="width: 100%;">
                                    <option value=""></option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="box-footer"> 
                        <button type="button" class="btn btn-default pull-left" id="btn_cancel_view"><!--<i class="fa fa-times"></i>--> Cancel</button>
                        <!-- <button type="submit" id="btn_save_share_quisioner" class="btn btn-primary pull-right">Submit</button> -->
                        <button id="btn_save_share_quisioner" class="btn btn-primary pull-right">Submit</button>
                    </div>
                <!-- </form> -->
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
    {{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.6.1/bootstrap-slider.min.js') }}
    {{--{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/dropzone.js') }}--}}
    {{ Html::script('js/pages/kuesioner/kuesioner-share.js') }}
    <script>
        // $('.slider').bootstrapSlider({
        //     formatter: function(value) {
        //         return 'Nilai : ' + value;
        //     }
        // });
    </script>
@stop

@section('theme-layout-scripts')
@stop

@section('page-specific-scripts')
@stop