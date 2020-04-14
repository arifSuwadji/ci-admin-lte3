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
          echo form_open('admin/tambahMenuBaru', $attributes);
      ?>
        <div class='card-body'>
          <div class="form-group">
              <label for="admin">Judul Menu</label>
              <input type="text" class="form-control" placeholder="Judul Menu" name="judul_menu" value="<?php echo $judulMenu ?>">
          </div>
          <div class="form-group">
              <label for="admin">Sub Judul Menu</label>
              <input type="text" class="form-control" placeholder="Judul Menu" name="sub_judul_menu" value="<?php echo $subJudulMenu ?>">
          </div>
          <div class="form-group">
              <label for="admin">Url Menu</label>
              <input type="text" class="form-control" placeholder="Url Menu" name="url_menu" value="<?php echo $urlMenu?>">
          </div>
          <div class="form-group">
              <label for="admin">Icon Menu</label>
              <input type="text" class="form-control" placeholder="Icon Menu" name="icon_menu" value="<?php echo $iconMenu ?>">
          </div>
          <div class="form-group">
              <label for="admin">Aktif Menu</label>
              <select name="aktif_menu" class="form-control select2" data-placeholder="Aktif Menu">
                <option></option>
                <option value="ya" <?php echo $aktifMenu == 'ya' ? 'selected' : ''?>>Ya</option>
                <option value="tidak" <?php echo $aktifMenu == 'tidak' ? 'selected' : ''?>>Tidak</option>
              </select>
          </div>
        </div>
        <!-- /.card-body -->
        <div class='card-footer'>
          <input type="hidden" name="baseURL" id="baseURL" value="<?php echo base_url() ?>" />
          <?php if(isset($buttonPriviliges->{3})){ ?>
              <button type="submit" id="lanjut" class="btn bg-primary pull-right">Tambah</button>
          <?php }else{ ?>
              <button class="pull-right btn btn-default text-bold" disabled>Tambah</button>
          <?php } ?>
        </div>
      <?php echo form_close() ?>
      </div>
  </div>
  </section>
