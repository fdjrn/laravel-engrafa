@extends('layouts.template')

@section('doc_title', isset($documentTitle) ? $documentTitle : 'Document Title')

@section('doc_desc', isset($documentDescription) ? $documentDescription : 'Document Description')

@section('global-mandatory-styles')
@stop

@section('page-level-plugin-styles')
    {{ Html::style('css/material.min.css')}}
    {{ Html::style('css/dataTables.material.min.css') }}
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
@stop

@section('page-header')
    <h1>Index Detail</h1>
@stop

@section('page-breadcrumb')
    <li><a class="active" href="{{route('index')}}"><i class="fa fa-file"></i> Index Detail</a></li>
@stop


@section('body-inner-content')
    <div class="row">
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h4><i class="fa fa-sticky-note"></i>
                        <span class="pull-right">
                            <a href="#" id="file_detail-print">
                                <i class="fa fa-print fa-fw" data-toggle="tooltip" title="print"></i>
                            </a>
                            <a href="" id="file-detail-related">
                                <i class="fa fa-usb fa-fw" data-toggle="tooltip" title="related document"></i>
                            </a>
                            <a href="" id="file_detail-download">
                                <i class="fa fa-download fa-fw" data-toggle="tooltip" title="download"></i>
                            </a>                            &nbsp;
                            <span class="pull-right">
                                <form action="{{ route('index') }}" method="POST" id="frm-index_detail" class="small-box-footer">
                                    @csrf
                                    <input type="hidden" name="folder_id" value="{{ $file_detail->folder_root }}">
                                    <a href="" id="link-to-index">
                                        <i class="fa fa-window-close " data-toggle="tooltip" title="close"></i>
                                    </a>
                                </form>
                            </span>
                        </span>
                    </h4>
                </div>

                <div class="box-body" style="height: auto">
                    <iframe src="{{\Illuminate\Support\Facades\Storage::url($file_detail->url)}}"
                            id="index-detail-iframe" name ="index-detail-iframe"
                            width="100%" height="640px"></iframe>
                </div>
            </div>
        </div>

        {{-- Right Side (File Properties)--}}
        <div class="col-md-3" id="file-properties">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <input type="hidden" id="file-descr-id" value="{{ $file_detail->id }}">
                    <h4 class="file-descr-name" id="file-descr-name" style="overflow-wrap: break-word"><i
                                class="fa fa-usb fa-fw"></i>
                        {{ $file_detail->name }}
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
                                <a data-toggle="collapse" data-target="#collapseOne" data-parent="#file-group">
                                    Description</a>
                            </h4>
                        </div>

                        <div id="collapseOne" class="collapse in">
                            <div class="box-body">
                                <p id="index-detail-descr" style="font-weight: normal"> {{ $file_detail->description }} </p>
                            </div>
                            <div class="box-footer">
                                <span class="pull-left">
                                    {{--<a href="#" data-toggle="tooltip" title=""><i class="fa fa-eye fa-fw"></i></a>--}}
                                    @if(substr($loggedUser['role'],0,1) <= '4' )
                                    <a href="" id="edit-file" data-toggle="tooltip" title="edit"><i
                                                class="fa fa-edit fa-fw"></i></a>
                                    @endif
                                    <a href="#" data-toggle="tooltip" title="share"><i
                                                class="fa fa-share fa-fw"></i></a>
                                    @if(substr($loggedUser['role'],0,1) <= '4' )
                                    <a href="" id="delete-file" data-toggle="tooltip" title="delete"><i
                                                class="fa fa-trash fa-fw"></i></a>
                                    @endif
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

    <!-- View File Relations -->
    <div class="modal fade bs-modal-file-history eng-modal" tabindex="-1" role="dialog" aria-labelledby="viewFileModalLabel" style="height: auto">
        <div class="modal-dialog eng-modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close pull-right fa fa-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&nbsp;</span>
                    </button>
                    <div align="center">
                        <h4 class="modal-title">History</h4>
                        <h4 id="modal-history-caption" class="modal-title"></h4>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="file-history-table" class="mdl-data-table" width="100%">
                            <thead>
                            <tr>
                                <th width="250px">Name</th>
                                <th width="120px">Date Modified</th>
                                <th width="250px">Size</th>
                                <th width="150px">Action</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
    {{ Html::script('js/pages/index/index-detail.js') }}
@stop

@section('theme-layout-scripts')
@stop

@section('page-specific-scripts')
@stop