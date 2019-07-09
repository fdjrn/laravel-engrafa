@extends('layouts.app')

@section('doc_title', isset($documentTitle) ? $documentTitle : 'OSS WEB')

@section('doc_desc', isset($documentDescription) ? $documentDescription : 'Document Description')

@section('global-mandatory-styles')
@stop

@section('page-level-plugin-styles')
    <link href="/oss/templates/metronic/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="/oss/templates/metronic/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="/oss/templates/metronic/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
    <link href="/oss/templates/metronic/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="/oss/templates/metronic/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
@stop

@section('theme-global-styles')
@stop

@section('page-level-styles')
<style>
    .portlet-body a{
        color:#333 !important;;
    }

    .portlet-body{
        padding-top:40px !important;
        margin-left:auto !important;
        margin-right:auto !important;
        width:805px;
    }
</style>
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
    <script type="text/javascript">
        @if ( isset( $var_javascript ) )
            @foreach ( $var_javascript as $k => $v )
                var {{ $k }}  = '{{ $v }}';
            @endforeach
        @endif
    </script>
@stop

@section('page_title', isset($pageTitle) ? $pageTitle : 'Page Title')

@section('content')
    @include('general.breadchrumb')
    <div class="portlet light" id="page_portlet">
        <div class="portlet-title">

            <div class="caption">
                <i class="icon-list"></i>
                <span class="caption-subject"><b> {{  isset($view_data['sub_header']) ? $view_data['sub_header'] : 'OSS-WEB' }} </b></span>
            </div>
            <div class="actions">
                <a class="btn btn-circle btn-icon-only btn-default fullscreen" href="javascript:;"> </a>
            </div>

        </div>

        <div class="portlet-body">
            @include('general.alert-box', [])
            @include('general.success-box', [])

        </div>
    </div>
@stop

@section('page-level-plugins-scripts')
    <script src="/oss/templates/metronic/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
    <script src="/oss/templates/metronic/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
    <script src="/oss/templates/metronic/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
    <script src="/oss/templates/metronic/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
    <script src="/oss/js/general/datatable.js" type="text/javascript"></script>
@stop

@section('theme-layout-scripts')
@stop

@section('page-specific-scripts')
    <script src="/oss/js/pages/notification-all.js" type="text/javascript"></script>
@stop
