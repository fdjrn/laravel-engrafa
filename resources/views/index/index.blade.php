@extends('layouts.template')

@section('doc_title', isset($documentTitle) ? $documentTitle : 'Document Title')

@section('doc_desc', isset($documentDescription) ? $documentDescription : 'Document Description')

@section('global-mandatory-styles')
@stop

@section('page-level-plugin-styles')
    {{ Html::style('css/material.min.css')}}
    {{ Html::style('css/dataTables.material.min.css') }}
    {{ Html::style('css/dropzone.min.css') }}
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
        window.onload = function () {
            document.getElementById("iframe-view-file").setAttribute("visibility", "hidden");
        }
    </script>
@stop

@section('page-header')
    <h1>Index</h1>
@stop

@section('page-breadcrumb')
    <li><a class="active" href="{{route('index')}}"><i class="fa fa-file"></i> Index</a></li>
@stop


@section('body-inner-content')
    <input name="f_id" type="hidden" value="{!! $folderID !!}">
    <div class="row">

        {{-- Left Side --}}
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="dt-list-folder-table-index" class="table table-responsive" width="100%">
                            <thead>
                                <tr>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>

                </div>
                <!-- /.box-body -->


                <div class="box-footer text-center">
                    <div class="btn-group dropup btn-block custom-dropdown-btn">
                        <button type="button" class="btn btn-primary btn-block" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">My Drive
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu custom-dropdown-btn">
                            <li>
                                <a href="#"><span><i class="fa fa-folder-o"></i></span> Upload Folder</a>
                            </li>
                            <li>
                                <a href="#" data-toggle="modal" id="upload_file_btn" data-target="#upload-files-modal">
                                    <span><i class="fa fa-file-o"></i></span> Upload Files
                                </a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#create-new-folder-modal">
                                    <span><i class="fa fa-plus-square-o"></i></span> New Folder
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main view (Center) --}}
        <div class="col-md-6">
            <div class="box box-primary ">

                {{-- Header--}}
                <div class="box-header with-border">
                    <h4>
                        <i class="fa fa-angle-left fa-fw header-cursor" id="main-back"></i>
                        <label id="root-folder-name" class="header-cursor"></label>
                        <span class="pull-right">
                            <i class="fa fa-list fa-fw"></i>
                            <i class="fa fa-clone"></i>
                        </span>
                    </h4>
                </div>

                {{-- Main grid--}}
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="dt-file-exp-table-index" class="mdl-data-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="75px"><input value="1" id="file-exp-select-all" type="checkbox"></th>
                                    <th width="250px">Name</th>
                                    <th width="120px">Date Modified</th>
                                    <th width="150px">Creator</th>
                                    <th width="250px">Comment</th>
                                    <th width="150px">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                {{--<div class="box-footer"> </div>--}}
            </div>
        </div>

        {{-- Right Side (File Properties)--}}
        <div class="col-md-3" id="file-properties">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <input type="hidden" id="file-descr-id">
                    <h4 class="file-descr-name" id="file-descr-name" style="overflow-wrap: break-word"><i class="fa fa-usb fa-fw"></i>
                        <span class="pull-right">
                            <i class="fa fa-angle-double-right"></i>
                        </span>
                    </h4>
                </div>

                <div class="box-body">
                    {{-- File Description Part --}}
                    <div class="box box-primary">
                        <div class="box-header with-border" data-toggle="collapse" data-target="#collapseOne">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-target="#collapseOne" data-parent="#file-group"> Description</a>
                            </h4>
                        </div>

                        <div id="collapseOne" class="collapse in">
                            <div class="box-body">
                                <p id="file-descr-text"></p>
                            </div>
                            <div class="box-footer">
                                <span class="pull-left">
                                    <a href="" id="view-file" data-toggle="tooltip" title=""><i class="fa fa-eye fa-fw"></i></a>
                                    <a href="" id="edit-file-descr" data-toggle="tooltip" title="edit"><i class="fa fa-edit fa-fw"></i></a>
                                    <a href="#" data-toggle="tooltip" title="share"><i class="fa fa-share fa-fw"></i></a>
                                    <a href="" id="delete-file" data-toggle="tooltip" title="delete"><i class="fa fa-trash fa-fw"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
        </div>

    </div>
@stop

@section('body-modals')
    @include('layouts.part.file-management-modal')
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')

@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
    {{ Html::script('js/jquery.dataTables.min.js') }}
    {{ Html::script('js/dataTables.material.min.js') }}
    {{ Html::script('js/dropzone.min.js') }}
    {{ Html::script('js/pages/index/file-explorer.js') }}
@stop

@section('theme-layout-scripts')
@stop

@section('page-specific-scripts')
@stop