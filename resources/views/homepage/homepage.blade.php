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
        <div class="btn-group dropdown">
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
        </div>
        <span>
            <a class="pull-right" href="#"><span><i class="fa fa-home"></i> Engrafa</span></a>
        </span>
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
                            <p>[Nama File Dokumen]</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-file-o"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More Details <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-purple">
                        <div class="inner">
                            <h3>Survey</h3>
                            <p>[Nama Survey]</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-copy"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More Details <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>Folder</h3>
                            <p>[Nama Folder]</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-folder-o"></i>
                        </div>
                        <a href="#" class="small-box-footer">
                            More Details <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <table id="recentListTable" class="table table-bordered table-hover" data-toggle="table"
                   data-click-to-select="true">
                <thead>
                <tr>
                    <th data-field="state" data-checkbox="true" data-formatter="stateFormatter">
                        <input type="checkbox">
                    </th>
                    <th>Name</th>
                    <th>Date Modified</th>
                    <th>Creator</th>
                    <th>Comment</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>
                        <i class="fa fa-folder fa-fw"></i>
                        <span>Some Text</span>
                    </td>
                    <td>Some Text</td>
                    <td>Some Text</td>
                    <td>
                        <i class="fa fa-comment fa-fw"></i>
                        <span>Some Text</span>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>
                        <i class="fa fa-folder fa-fw"></i>
                        <span>Some Text</span>
                    </td>
                    <td>Some Text</td>
                    <td>Some Text</td>
                    <td>
                        <i class="fa fa-comment fa-fw"></i>
                        <span>Some Text</span>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox"></td>
                    <td>
                        <i class="fa fa-usb fa-fw"></i>
                        <span>Some Text</span>
                    </td>
                    <td>Some Text</td>
                    <td>Some Text</td>
                    <td>
                        <i class="fa fa-comment fa-fw"></i>
                        <span>Some Text</span>
                    </td>
                </tr>
                <tfoot>
                <tr>
                    <th data-field="state" data-checkbox="true" data-formatter="stateFormatter">
                        <input type="checkbox">
                    </th>
                    <th>Name</th>
                    <th>Date Modified</th>
                    <th>Creator</th>
                    <th>Comment</th>
                </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">

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
@stop

@section('theme-layout-scripts')
@stop

@section('page-specific-scripts')
@stop