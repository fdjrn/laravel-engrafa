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

        .center-image {
            margin-left: auto;
            margin-right: auto;
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
                            <a href="">
                                <i class="fa fa-print fa-fw" data-toggle="tooltip" title="print"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-usb fa-fw" data-toggle="tooltip" title="related document"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-download fa-fw" data-toggle="tooltip" title="download"></i>
                            </a>
                            &nbsp;
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
                    @if ( $file_detail->mime_type === 'application/pdf')
                        <iframe src="{{ url('http://localhost:8000/ViewerJS/index.html#../storage/index/'. $file_detail->url ) }}"
                                width="100%" height="720px">
                        </iframe>
                    @elseif(substr($file_detail->mime_type,0,5) === 'image')
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($file_detail->url) }}"
                             alt="{{ $file_detail->name }}" class="img-responsive center-image">

                    @endif
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    {{--Box Footer Here--}}
                </div>
            </div>
        </div>

        {{-- Right Side (File Properties)--}}
        <div class="col-md-3" id="file-properties">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <input type="hidden" id="file-descr-id">
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
                                <p id="{{ $file_detail->description }}"></p>
                            </div>
                            <div class="box-footer">
                                <span class="pull-left">
                                    <a href="#" data-toggle="tooltip" title=""><i class="fa fa-eye fa-fw"></i></a>
                                    <a href="" id="edit-file-descr" data-toggle="tooltip" title="edit"><i
                                                class="fa fa-edit fa-fw"></i></a>
                                    <a href="#" data-toggle="tooltip" title="share"><i
                                                class="fa fa-share fa-fw"></i></a>
                                    <a href="" id="delete-file" data-toggle="tooltip" title="delete"><i
                                                class="fa fa-trash fa-fw"></i></a>
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
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
    <script>
        $('#link-to-index').on('click', function (e) {
            e.preventDefault();
            $('#frm-index_detail').submit();
        })

    </script>
@stop

@section('theme-layout-scripts')
@stop

@section('page-specific-scripts')
@stop