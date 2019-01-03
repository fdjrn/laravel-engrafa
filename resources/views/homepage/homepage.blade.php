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
    {{ Html::style('css/material.min.css')}}
    {{ Html::style('css/dataTables.material.min.css') }}
    {{ Html::style('css/dropzone.min.css') }}

    <style>

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

        .table-responsive tbody td{
            font-size: inherit;
            font-weight: normal;
        }

        #latest-folder-link {
            cursor: pointer;
            color: rgba(255,255,255,0.8);
        }

        #frm-last-folder {
            cursor: pointer;
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
        <div class="btn-group-sm">
            <button type="button" class="btn btn-primary" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">Option
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu">
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
            <span>
                <a class="pull-right" href="#"><span><i class="fa fa-home"></i> Engrafa</span></a>
            </span>
        </div>

@stop

@section('page-breadcrumb')
@stop


@section('body-inner-content')
    <div class="box box-primary ">
        <div class="box-header with-border">
            <h3>Recent File</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>Dokumen</h3>
                            <input type="hidden" name="file_id" value="{{ isset($latestFile) ? $latestFile->id : 0 }}">
                            <p class="latest-file-name">
                                {!! isset($latestFile) ? $latestFile->name : '[No Data]' !!}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-o"></i>
                        </div>
                        <a href="#" data-toggle="modal" id="latest-file-link"
                           class="small-box-footer latest-file-url" >
                            More Details <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>Survey</h3>
                            <input type="hidden" name="survey_id" value="{{ isset($latestSurvey) ? $latestSurvey['id'] : 0}}">
                            <p class="latest-survey-name">
                                {!! isset($latestSurvey) ? $latestSurvey['name'] : '[No Data]' !!}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-copy"></i>
                        </div>
                        <a href="#" class="small-box-footer latest-survey">
                            More Details <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>Folder</h3>
                            <p class="latest-folder-name">
                                {!! isset($latestFolder) ? $latestFolder['name'] : '[No Data]' !!}
                            </p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-folder-o"></i>
                        </div>
                        @if(isset($latestFolder))
                            <form action="{{ route('index') }}" method="POST" id="frm-last-folder" class="small-box-footer">
                                @csrf
                                <input type="hidden" name="folder_id" value="{{ isset($latestFolder) ? $latestFolder['id'] : 0 }}">
                                <a href="#"
                                   class="small-box-footer latest-folder-url" id="latest-folder-link">
                                    More Details <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </form>
                        @else
                        <a href="{{ url('/index') }}"
                           class="small-box-footer latest-folder-url">
                            More Details <i class="fa fa-arrow-circle-right"></i>
                        </a>
                        @endif

                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table id="recentListTable" class="mdl-data-table" width="100%">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Owner</th>
                        <th>Last Modified</th>
                        <th>Size</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">

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
    {{ Html::script('js/pages/homepage/homepage.js') }}
@stop

@section('theme-layout-scripts')
@stop

@section('page-specific-scripts')
@stop