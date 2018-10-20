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
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
@stop

@section('page-header') 
	<h1>Landing Page</h1>
@stop

@section('page-breadcrumb')
	<li><a href="#">Landing Page</a></li>
@stop

@section('body-inner-content')
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
