<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Tata Kelola IT | Register</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="theme/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="theme/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="theme/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="theme/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="theme/AdminLTE/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Register</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">

    <form method="POST" action="{{ route('register') }}">
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
      <div class="row">
        <div class="col-xs-12">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="theme/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="theme/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="theme/AdminLTE/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });
</script>
</body>
</html>
