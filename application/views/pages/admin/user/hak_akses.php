  <!-- Content Header (Page header) -->
  <?php $title = explode('(',$menuHalaman->sub_judul_menu); ?>
  <section class='content-header'>
  <div class='container-fluid'>
      <div class='row mb-2'>
      <div class='col-sm-6'>
          <h1><?php echo $title[0] ?> <?php echo $nama_edit_grup ?></h1>
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
        <div class='card card-default'>
            <div class='card-header'>
                <h3 class='card-title'>Form <?php echo $menuHalaman->sub_judul_menu ?></h3>
            </div>
             <!-- /.card-header -->
             <?php
                $attributes = array('class' => 'form-horizontal');
                echo form_open('admin/updateHakAkses', $attributes);
            ?>
            <div class='card-body table-responsive p-0'>
                <table id="tableData" class='table table-striped table-bordered table-hover text-nowrap'>
                <thead class="bg-primary">
                <tr class=''>
                    <th>No</th>
                    <th>Judul Modul</th>
                    <th>Nama Modul</th>
                    <th>Url Modul</th>
                    <th>Opsi</th>
                </tr>
                <thead>
                <tbody>
                <?php $lastJudul = ''; $i=0; foreach($halaman_admin->result() as $admin){ $i++; ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php if($lastJudul != $admin->judul_menu ){ echo $admin->judul_menu; }?></td>
                        <td><?php echo $admin->sub_judul_menu ?></td>
                        <td><?php echo $admin->url_menu ?></td>
                        <td><input type="checkbox" class="minimal halaman" name="halaman[]" value="<?php echo $admin->menu_id ?>" <?php echo $admin->menu_id == $admin->halaman_menu ? 'checked' : '' ?>></td>
                    </tr>
                <?php $lastJudul= $admin->judul_menu; } ?>
                </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <input type="hidden" name="baseURL" id="baseURL" value="<?php echo base_url() ?>" />
                <input type="hidden" name="grup_id_edit" value="<?php echo $grup_id_edit ?>">
                <button type="button" class="btn bt-outline bg-primary cek"><span class="fa fa-check-square-o"></span> Cek Semua</button>
                <button type="button" class="btn btn-outline bg-navy batal"><span class="fa fa-square-o"></span> Batal</button>
                <?php if(isset($priviliges->{22})){ ?>
                <button type="submit" id="lanjut" class="btn bg-warning float-right">Perbarui</button>
                <?php }else{?><button class="float-right btn btn-default text-bold" disabled>Perbarui</button><?php } ?>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
  </section>