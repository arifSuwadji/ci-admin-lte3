<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php echo asset_icon('AdminLTELogo.png')?>
  <title>Admin | Daftar Presensi</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php echo asset_plugin_css('fontawesome-free/css/all.min.css') ?>
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <?php echo asset_plugin_css('icheck-bootstrap/icheck-bootstrap.min.css') ?>
  <?php echo asset_css('adminlte.min.css') ?>
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page fixed">
<div class="login-box">
  <div class="login-logo">
    <a href="javascript:void(0);"><b>Daftar Presensi</b></a>
  </div>
  <?php if(validation_errors()){ ?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-warning"></i></h4>
        <?php echo validation_errors() ?>
    </div>
  <?php } ?>
  <?php if($errmsg){ ?>
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-warning"></i></h4>
        <?php echo $errmsg ?>
    </div>
  <?php } ?>
  <!-- /.login-logo -->
  
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Masuk untuk memulai sesi anda</p>

      <?php echo form_open('admin/login/action') ?>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $email ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo $password ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
          </div>
          <!-- /.col -->
        </div>
        <?php echo form_close() ?> 
      
    </div>
    <!-- /.login-card-body -->
  </div>
  
</div>
<!-- /.login-box -->

<?php echo asset_plugin_js('jquery/jquery.min.js'); ?>
<?php echo asset_plugin_js('bootstrap/js/bootstrap.bundle.min.js'); ?>
<?php echo asset_js('adminlte.min.js');?>

</body>
</html>
