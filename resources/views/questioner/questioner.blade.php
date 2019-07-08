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

        body{
            padding-right: 0 !important;
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
                        <label class="header-cursor">Quisioner</label>
                        <span class="pull-right">
                            <i class="fa fa-list fa-fw"></i>
                        </span>
                    </h4>
                </div>

                {{-- Main grid--}}
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="dt-questioner-table-index" class="mdl-data-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="25px">No</th>
                                    <th width="250px">Name</th>
                                    <th width="250px">Category</th>
                                    <th width="250px">Creator</th>
                                    <th width="80px" style="text-align:center;">More</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                {{--<div class="box-footer"> </div>--}}
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
    @include('questioner.questioner-share-modal')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
    {{ Html::script('js/jquery.dataTables.min.js') }}
    {{ Html::script('js/dataTables.material.min.js') }}
    {{--{{ Html::script('js/dropzone.min.js') }}--}}
    {{--{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/dropzone.js') }}--}}
    {{ Html::script('js/pages/kuesioner/kuesioner.js') }}
@stop

@section('theme-layout-scripts')
@stop

@section('page-specific-scripts')
@stop