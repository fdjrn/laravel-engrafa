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
@stop

@section('page-header')
    <h1>Index</h1>
@stop

@section('page-breadcrumb')
    <li><a class="active" href="{{route('index')}}"><i class="fa fa-file"></i> Index</a></li>
@stop


@section('body-inner-content')
    <div class="row">

        {{-- Left Side --}}
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body">
                    {{--<ul class="list-group" data-widget="tree" style="list-style: none;">
                        <li class="">
                            <a href="#">
                                <i class="fa fa-folder-open"></i> <span> Some Text</span>
                                <span class="pull-right">
                                    <small class="label bg-yellow">2</small>
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#">
                                <i class="fa fa-folder-open"></i> <span> Some Text</span>
                                <span class="pull-right"><small class="label bg-yellow">2</small></span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#">
                                <i class="fa fa-folder-open"></i> <span> Some Text</span>
                                <span class="pull-right">
                                    <small class="label bg-yellow">2</small>
                                </span>
                            </a>
                        </li>
                        <li class="">
                            <a href="#">
                                <i class="fa fa-folder-open"></i> <span> Some Text</span>
                                <span class="pull-right">
                                    <small class="label bg-yellow">2</small>
                                </span>
                            </a>
                        </li>
                    </ul>--}}
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
                    <h4><i class="fa fa-usb fa-fw"></i>Some File
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
                                <p id="file-description">
                                Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad
                                squid. 3
                                wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa
                                nesciunt laborum
                                </p>
                            </div>
                            <div class="box-footer">
                                <span class="pull-left">
                                    <a href="" data-toggle="tooltip" title=""><i class="fa fa-eye fa-fw"></i></a>
                                    <a href="#" data-toggle="modal" data-target="#modal2" title="edit"><i class="fa fa-edit fa-fw"></i></a>
                                    <a href="" data-toggle="tooltip" title="share"><i class="fa fa-share fa-fw"></i></a>
                                    <a href="" data-toggle="tooltip" title="delete"><i class="fa fa-trash fa-fw"></i></a>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border" data-toggle="collapse" data-target="#collapseTwo">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#file-group" data-target="#collapseTwo">Contributor</a>
                            </h4>
                        </div>
                        <div id="collapseTwo" class="collapse in">
                            <div class="box-body">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <i class="fa fa-user fa-fw"></i> Creator
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-user fa-fw"></i> Editor
                                    </li>
                                    <li class="list-group-item">
                                        <i class="fa fa-user fa-fw"></i> Validator
                                    </li>
                                </ul>
                            </div>
                            <div class="box-footer">
                            </div>
                        </div>
                    </div>

                    <div class="box box-primary">
                        <div class="box-header with-border" data-toggle="collapse" data-target="#collapseThree">
                            <h4 class="box-title">
                                <a data-toggle="collapse" data-parent="#file-group" data-target="#collapseThree">
                                    Modified By
                                </a>
                            </h4>
                        </div>
                        <div id="collapseThree" class="collapse in">
                            <div class="box-body">
                                <table id="table1" class="table table-bordered table-hover" data-toggle="table"
                                       data-click-to-select="true">
                                    <thead>
                                    <tr>
                                        <th>File</th>
                                        <th>Modified By</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <i class="fa fa-usb fa-fw"></i>
                                                <span>Some Text</span>
                                            </td>
                                            <td>
                                                <i class="fa fa-fw fa-user"></i>
                                                <span>Some Text</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="fa fa-usb fa-fw"></i>
                                                <span>Some Text</span>
                                            </td>
                                            <td>
                                                <i class="fa fa-fw fa-user"></i>
                                                <span>Some Text</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <i class="fa fa-usb fa-fw"></i>
                                                <span>Some Text</span>
                                            </td>
                                            <td>
                                                <i class="fa fa-fw fa-user"></i>
                                                <span>Some Text</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-footer">
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

    <!-- Create Folder Bootsrap Modal -->
    <div class="modal eng-modal fade" id="create-new-folder-modal" tabindex="-1" role="dialog" aria-labelledby="createFolderModalLabel">
        <div class="modal-dialog eng-modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close pull-right fa fa-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&nbsp;</span>
                    </button>
                    <h4 class="modal-title" ><i class="fa fa-folder"></i><span> Create New Folder</span></h4>
                </div>
                {{ Form::open(['id'=>'create-new-folder-form']) }}
                @csrf
                <div class="modal-body">
                    <div id="success-msg" class="hide">
                        <div class="alert alert-info alert-dismissible fade in" role="alert">
                            <button type="button" class="close" data-dismiss="alert" >
                                <span aria-hidden="true">×</span>
                            </button>
                            <strong>Success!</strong> Folder has been created.
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        {!! Form::label('label-new-folder-name','New Folder Name: ',['class'=>'control-label', 'for'=>'folderName']) !!}
                        <input type="text" class="form-control" id="folderName" name="folderName">
                        <span class="text-danger">
                            <strong id="folder-name-error"></strong>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::button('Close', ['class' => 'btn btn-default','data-dismiss'=>'modal']) !!}
                    {!! Form::button('Create', ['class' => 'btn btn-info','id'=>'btn-create-folder']) !!}
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <!-- Upload files Bootsrap Modal -->
        <div class="modal eng-modal fade" id="upload-files-modal" tabindex="-1" role="dialog" aria-labelledby="uploadFilesModalLabel">
        <div class="modal-dialog eng-modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close pull-right fa fa-close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&nbsp;</span>
                    </button>
                    <h4 class="modal-title" ><i class="fa fa-file"></i><span> Upload Files</span></h4>
                </div>
                <div class="modal-body">
                    <div class="form-group has-feedback">
                        <form class="dropzone" id="upload-file-form" method="POST" enctype="multipart/form-data" action="">
                            @csrf
                            <div class="fallback">
                                <input type="file" name="file"/>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::button('Close', ['class' => 'btn btn-default','data-dismiss'=>'modal']) !!}
                    {!! Form::submit('Upload', ['class' => 'btn btn-info','id'=>'btn-upload-files']) !!}
                </div>
            </div>
        </div>
    </div>

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

@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
    {{ Html::script('js/jquery.dataTables.min.js') }}
    {{ Html::script('js/dataTables.material.min.js') }}
    {{ Html::script('js/dropzone.min.js') }}
    {{--{{ Html::script('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/dropzone.js') }}--}}
    {{ Html::script('js/pages/index/file-explorer.js') }}
@stop

@section('theme-layout-scripts')
@stop

@section('page-specific-scripts')
@stop