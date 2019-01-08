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
  <li><a class="active" href="{{route('setting')}}"><i class="fa fa-user"></i> Profile</a></li>
@stop


@section('body-inner-content')
<div class="row">
  <div class="col-md-3">
    @include('setting.nav-left')
  </div>
  <div class="col-md-9">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h4>Profile</h4>
      </div>
      <div class="box-body">
        <form name="form_profile" id="form_profile" method="POST" action="{{route('setting.update_profile_user')}}">
          @csrf

          <div class="form-group">
            <input type="text" class="form-control" placeholder="Nama Depan" name="nama_depan" value="{{ old('nama_depan', $users[0]->first_name) }}">
            @if ($errors->has('nama_depan'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nama_depan') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Nama Belakang" name="nama_belakang" value="{{ old('nama_belakang', $users[0]->last_name) }}">
            @if ($errors->has('nama_belakang'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('nama_belakang') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username', $users[0]->name) }}">
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
              <option value="{{$role->id}}" {{ $role->id == $users[0]->role ? 'selected' : ''}}>{{$role->name}}</option>
              @endforeach
            </select>
            @if ($errors->has('roles'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('roles') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email', $users[0]->email) }}">
            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="No. Telepon" name="telepon" value="{{ old('telepon', $users[0]->phone) }}"> 
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
          <!-- <div class="form-group">
            <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation">
            @if ($errors->has('password_confirmation'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
            @endif
          </div> -->
        </form>
      </div>
      <div class="box-footer">
        <button type="button" class="btn btn-default pull-left" id="btn_cancel"><!--<i class="fa fa-times"></i>--> Cancel</button>
        <button type="submit" form="form_profile" class="btn btn-primary pull-right"><!--<i class="fa fa-check"></i>-->Save</button>
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
{{ Html::script('js/pages/setting/profile.js') }}
@stop

@section('theme-layout-scripts')
@stop 

@section('page-specific-scripts')
@stop