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
          echo form_open('admin/tambahPenggunaBaru', $attributes);
      ?>
        <div class='card-body'>
          <div class="form-group">
              <label for="pengguna">Nama Pengguna</label>
              <input type="text" class="form-control" placeholder="Nama Pengguna" name="nama_pengguna" value="<?php echo $nama_tambah_pengguna ?>">
          </div>
          <div class="form-group">
              <label for="pengguna">User Pengguna</label>
              <input type="text" class="form-control" placeholder="User Pengguna" name="user_pengguna" value="<?php echo $nama_tambah_user ?>">
          </div>
          <div class="form-group">
              <label for="grup">Pengguna Grup</label>
              <select name="pengguna_grup" class="form-control select2" data-placeholder="Pengguna Grup">
                  <option></option>
              <?php foreach($data_grup->result() as $grup){ ?>
                  <option value="<?php echo $grup->grup_id ?>" <?php echo $grup->grup_id == $select_pengguna_grup ? 'selected' : '' ?>><?php echo $grup->nama_grup ?></option>
              <?php } ?>
              </select>
          </div>
          <div class="form-group">
              <label for="admin">Password</label>
              <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo $password ?>">
          </div>
          <div class="form-group">
              <label for="admin">Konfirmasi Password</label>
              <input type="password" class="form-control" placeholder="Konfirmasi Password" name="konf_password" value="<?php echo $konf_password ?>">
          </div>
        </div>
        <!-- /.card-body -->
        <div class='card-footer'>
          <input type="hidden" name="baseURL" id="baseURL" value="<?php echo base_url() ?>" />
          <?php if(isset($priviliges->{9})){ ?>                    
          <button type="submit" id="lanjut" class="btn bg-primary pull-right">Tambah</button>
          <?php }else{?><button class="pull-right btn btn-default text-bold" disabled>Tambah</button><?php } ?>
        </div>
      <?php echo form_close() ?>
      </div>
  </div>
  </section>
