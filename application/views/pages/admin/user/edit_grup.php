    <!-- Content Header (Page header) -->
    <?php $title = explode('(',$menuHalaman->sub_judul_menu); ?>
  <section class='content-header'>
  <div class='container-fluid'>
      <div class='row mb-2'>
      <div class='col-sm-6'>
          <h1><?php echo $title[0] ?></h1>
      </div>
      <div class='col-sm-6'>
          <ol class='breadcrumb float-sm-right'>
          <li class='breadcrumb-item'><a href='<?php echo base_url() ?>'><i class="<?php echo $menuHalaman->icon_menu ?>"></i> <?php echo $menuHalaman->judul_menu ?></a></li>
          <li class='breadcrumb-item active'><?php echo $menuHalaman->sub_judul_menu ?></li>
          </ol>
      </div>
      </div>
  </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class='content'>
  <div class='container-fluid'>
    <?php if(validation_errors()){ ?>
    <div class="alert alert-warning alert-dismissible col-sm-6 col-sm-offset-3">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-warning"></i></h4>
        <?php echo validation_errors() ?>
    </div>
    <?php } ?>
    <?php if($errmsg){ ?>
    <div class="alert alert-warning alert-dismissible col-sm-6 col-sm-offset-3">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-warning"></i></h4>
        <?php echo $errmsg ?>
    </div>
    <?php } ?>
      <!-- form -->
      <div class='card card-default'>
      <div class='card-header'>
          <h3 class='card-title'>Form <?php echo $menuHalaman->sub_judul_menu ?></h3>
      </div>
      <!-- /.card-header -->
      <?php
          $attributes = array('class' => 'form-horizontal');
          echo form_open('admin/updateGrup', $attributes);
      ?>
        <div class='card-body'>
          <div class="form-group">
              <label for="grup" class="col-sm-4 control-label">Nama Grup</label>
              <input type="text" class="form-control" placeholder="Nama Grup" name="nama_grup" value="<?php echo $nama_edit_grup ?>">
          </div>
        </div>
        <!-- /.card-body -->
        <div class='card-footer'>
          <input type="hidden" name="baseURL" id="baseURL" value="<?php echo base_url() ?>" />
          <input type="hidden" name="grup_id_edit" value="<?php echo $grup_id_edit ?>">
          <?php if(isset($priviliges->{17})){ ?>
          <button type="submit" id="lanjut" class="btn bg-primary pull-right">Perbarui</button>
          <?php }else{?><button class="pull-right btn btn-default text-bold" disabled>Perbarui</button><?php } ?>
        </div>
      <?php echo form_close() ?>
      </div>
  </div>
  </section>
 