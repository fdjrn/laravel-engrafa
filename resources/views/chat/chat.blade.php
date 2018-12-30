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
<!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('theme/AdminLTE//bower_components/select2/dist/css/select2.min.css')}}">
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
@stop

@section('page-header') 
  <h1>Chat</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="{{ url('chat')}}"><i class="fa fa-comment"></i> Chat</a></li>
@stop


@section('body-inner-content')
<div id="app">
  <chat-personal-component :user="{{ auth()->user() }}"></chat-personal-component>
</div>
@stop

@section('core-plugins')
@stop

@section('page-level-plugins')
@stop

@section('theme-global-scripts')
@stop

@section('page-level-scripts')
<!-- <script src="{{ asset('js/app.js')}}"></script> -->

<script src="{{ asset('theme/AdminLTE/bower_components/select2/dist/js/select2.full.min.js')}}"></script> <script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()
  })
</script>

<script>
</script>
  <!-- select2 -->
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop