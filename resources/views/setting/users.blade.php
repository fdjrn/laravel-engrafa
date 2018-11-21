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
  </style>
@stop

@section('theme-layout-styles')
@stop

@section('custom-scripts')
@stop

@section('page-header') 
  <h1>Setting</h1>
@stop

@section('page-breadcrumb')
  <li><a class="active" href="{{route('setting')}}"><i class="fa fa-users"></i> Users</a></li>
@stop


@section('body-inner-content')
<div class="row">
  <div class="col-md-3">
    @include('setting.nav-left')
  </div>
  <div class="col-md-9">
    <div class="box box-primary">
      <div class="box-body">
        <div class="row">
          <div class="col-md-5">
            <h4 style="margin-left: 14px;"><a href="#"><i class="fa fa-user-plus fa-fw"></i>&nbsp;Invite People</a></h4>
            <div class="left-content">
                <div class="left-content-row">
                  <div class="left-content-cell" style="vertical-align: middle; text-align: center;">
                    <h1 class="users-image"><i class="fa fa-user"></i></h1>
                  </div>
                  <div class="left-content-cell">
                    <div class="users-name">{{Auth::user()->name}}</div>
                    <div style=""><span>{{Auth::user()->email}}</span></div>
                  </div>
                </div>
            </div>
            <div class="left-content" style="padding-left: 20px; padding-right: 15px; padding-top: 8px; padding-bottom: 8px;">
                <div class="left-content-row">
                  <div class="left-content-cell">
                    <select class="select2">
                      @foreach($data_roles as $role)
                      <option value="{{$role->id}}" {{ $role->id === Auth::user()->role ? 'selected' : '' }}>{{$role->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="left-content-cell">
                    <i class="fa fa-key"></i>
                  </div>
                </div>
            </div>
            <div class="left-content">
                <div class="left-content-row">
                  <div class="left-content-cell">
                    <h4>Teams</h4>
                    @if($teams)
                      @foreach($teams as $team)
                        <button type="button" class="btn bg-olive btn-flat margin">{{$team->name}}</button>
                      @endforeach
                    @endif
                  </div>
                </div>
            </div>
            <div class="left-content">
                <div class="left-content-row">
                  <div class="left-content-cell">
                    <button id="o_new_user" type="button" class="btn bg-purple btn-block margin" style="height: 40px;">Create New User</button>
                  </div>
                </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs">
                <li class="active no-margin text-center">
                  <a href="#tab_1" data-toggle="tab">
                    <p>Users</p>
                    <span>{{$total_users}} users</span>
                  </a>
                </li>
                <li class="no-margin text-center">
                  <a href="#tab_2" data-toggle="tab">
                    <p>Guest</p>
                    <span>0 users</span>
                  </a>
                </li>
              </ul>
              <div class="tab-content" style="padding:0;">
                <div class="tab-pane active" id="tab_1">
                  @if($users)
                    @foreach($users as $user)
                      <div class="left-content">
                        <div class="left-content-row">
                          <div class="left-content-cell" style="vertical-align: middle; text-align: center; width:55px; padding-left: 4px;">
                            <h1 class="users-image"><i class="fa fa-user"></i></h1>
                          </div>
                          <div class="left-content-cell">
                            <div class="users-name">{{$user->first_name." ".$user->last_name}}</div>
                            <div style=""><span>{{$user->email}}</span></div>
                          </div>
                          <div class="left-content-cell" style="text-align: right; padding-right: 5px;">
                            <a href="#"><i class="fa fa-pencil"></i></a>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  @else
                    <p class="no_available">No Users Available</p>
                  @endif
                </div>
                <div class="tab-pane" id="tab_2">
                  <p class="no_available">No Guest Available</p>
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

@section('body-modals')
<div class="modal fade" id="m_new_user">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Create New User</h4>
      </div>
      <div class="modal-body">
        <form name="form_n_user" id="form_n_user" method="POST" action="{{route('setting.create_user')}}">
          @csrf

          <div class="form-group">
            <input type="text" class="form-control" placeholder="Nama Depan" name="nama_depan" value="{{ old('nama_depan') }}">
            @if ($errors->has('nama_depan'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nama_depan') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Nama Belakang" name="nama_belakang" value="{{ old('nama_belakang') }}">
            @if ($errors->has('nama_belakang'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nama_belakang') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}">
            @if ($errors->has('username'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('username') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <select name="roles" class="select2" style="width: 100%;" data-placeholder="Pilih Role">
              <option value=""></option>
              @foreach($data_roles as $role)
              <option value="{{$role->id}}">{{$role->name}}</option>
              @endforeach
            </select>
            @if ($errors->has('roles'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('roles') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="No. Telepon" name="telepon" value="{{ old('telepon') }}"> 
            @if ($errors->has('telepon'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('telepon') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Password" name="password">
            @if ($errors->has('password'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation">
            @if ($errors->has('password_confirmation'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><i class="fa fa-times"></i></button>
        <button type="submit" form="form_n_user" class="btn btn-primary"><i class="fa fa-check"></i></button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
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