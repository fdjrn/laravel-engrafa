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

    .priorities{
      width: 50px; 
      height: 50px; 
      vertical-align: middle;
      border:solid 4px #dd4b39;
      border-radius:100%;
      -webkit-border-radius: 100%;
      -moz-border-radius: 100%;
    }

    .priorities > h4{
      font-weight: bold;
    }
    .nav-tabs-custom{
    }
    .nav-tabs-custom > ul{
      border-top: solid thin #f4f4f4;
    }
    .nav-tabs-custom > ul > li {
      width: 50%;
    }
    .nav-tabs-custom > ul > li > a {
      padding-top: 2px;
      padding-bottom: 2px;
    }
    .nav-tabs-custom > ul > li > a > p{
      margin: 0 0 1px;
    }
    .nav-tabs-custom > ul > li > a > span{
      font-weight: normal;
    }

    .left-content{
      width: 100%; display: table; 
      border-bottom: solid thin #f4f4f4; 
      padding-left: 4px; 
      padding-right: 4px; 
      padding-top: 4px; padding-bottom: 4px;
    }
    .left-content > .left-content-row{
      display: table-row;
    }
    .left-content > .left-content-row > .left-content-cell{
      display: table-cell; font-weight: normal;
    }
    .users-image{
      margin-top: 6px; padding-right: 4px;
    }
    .users-name{
      padding-top:6px;
    }
    .no_available{
      text-align: center; padding: 5px;
    }
    /**
    * table user black and white list
    */
    .table-borderless {
      overflow: auto;
    }
    .table-borderless td,
    .table-borderless th {
        border: 0;
    }
    /**
    * On-Off Switch button
    */
    .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 24px;
    }

    .switch input { 
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 16px;
      width: 16px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked + .slider {
      background-color: #2196F3;
    }

    input:focus + .slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
  </style>
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
@stop

@section('page-header')
<meta name="csrf-token" content="{{ csrf_token() }}"> 
  <h1>Setting</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="{{route('setting')}}"><i class="fa fa-ban"></i> Blacklist and Whitelist</a></li>
@stop


@section('body-inner-content')
<div class="row">
  <div class="col-md-3">
    @include('setting.nav-left')
  </div>
  <div class="col-md-9" style="padding-left:0px;">
    <div class="box box-primary">
      <div class="box-body">
        <div class="row">
          <h4 style="margin-left: 30px;"><a href="javascript:void(0)"><i class="fa fa-ban"></i>&nbsp;Blacklist and Whitelist</a></h4>
          
          <div class="col-md-5">
            <div class="left-content">
                <div class="left-content-row">
                  <div class="left-content-cell" style="vertical-align: middle; text-align: center;">
                    <h4>User Blacklisting</h4>
                  </div>
                </div>

                <div class="left-content-row">
                  <div class="left-content-cell" style="vertical-align: middle;">
                    <table class="table table-borderless table-condensed table-hover" id="table_blacklist">
                      @if($blackUsers->count() > 0)
                        @foreach($blackUsers as $user)
                          <tr>
                            <td><i class="fa fa-check-circle-o"></i></td>
                            <td>{{$user->name}}</td>
                            <td style="text-align:right;">
                              <label class="switch">
                                <input type="checkbox" id="{{$user->id}}">
                                <span class="slider round"></span>
                              </label>
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <p class="no_available">No Users Available</p>
                      @endif
                    </table>
                  </div>
                </div>
            </div>
          </div>

          <div class="col-md-2" style="padding-top:10px; vertical-align: middle; text-align: center;">
            <button id="btnSwitch"> <i class="fa fa-exchange"></i></button>
          </div>

          <div class="col-md-5">
            <div class="left-content">
                <div class="left-content-row">
                  <div class="left-content-cell" style="vertical-align: middle; text-align: center;">
                    <h4>User Whitelisting</h4>
                  </div>
                </div>
                <div class="left-content-row">
                  <div class="left-content-cell" style="vertical-align: middle;">
                    <table class="table table-borderless table-condensed table-hover" id="table_whitelist">
                      @if($whiteUsers->count() > 0)
                        @foreach($whiteUsers as $user)
                          <tr>
                            <td><i class="fa fa-check-circle-o"></i></td>
                            <td>{{$user->name}}</td>
                            <td style="text-align:right;">
                              <label class="switch">
                                <input type="checkbox" id="{{$user->id}}" checked="checked">
                                <span class="slider round"></span>
                              </label>
                            </td>
                          </tr>
                        @endforeach
                      @else
                        <p class="no_available">No Users Available</p>
                      @endif
                    </table>
                  </div>
                </div>
            </div>
          </div>
        </div>
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
{{ Html::script('js/pages/setting/blackwhitelist.js') }}
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')

@stop