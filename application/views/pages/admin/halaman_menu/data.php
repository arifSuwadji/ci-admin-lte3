  <!-- Content Header (Page header) -->
  <section class='content-header'>
  <div class='container-fluid'>
      <div class='row mb-2'>
      <div class='col-sm-6'>
          <h1><?php echo $menuHalaman->judul_menu ?></h1>
      </div>
      <div class='col-sm-6'>
          <ol class='breadcrumb float-sm-right'>
          <li class='breadcrumb-item'><a href='javascript:void(0)'><i class="<?php echo $menuHalaman->icon_menu ?>"></i> <?php echo $menuHalaman->judul_menu ?></a></li>
          <li class='breadcrumb-item active'>Data <?php echo $menuHalaman->sub_judul_menu ?></li>
          </ol>
      </div>
      </div>
  </div><!-- /.container-fluid -->
  </section>
  <!-- Main content -->
  <section class='content'>
  <div class='container-fluid'>
    <div class='row'>
      <div class='col-md-12'>
          <div class='card'>
          <div class='card-header'>
            <h3 class='card-title'><?php echo $menuHalaman->sub_judul_menu ?></h3>
            <?php if(isset($buttonPriviliges->{2})){ ?><a href="<?php echo $tambahData ?>"><button class="btn btn-primary btn-sm float-right text-bold">Tambah Menu</button></a><?php }else{?><button class="btn btn-default btn-sm float-right text-bold" disabled>Tambah Menu</button><?php } ?>
            <input type="hidden" id="dataJson" value="<?php echo $dataJson ?>"/>
            <input type="hidden" id="editData" value="<?php echo $editData ?>"/>
            <input type="hidden" id="hapusJson" value="<?php echo $hapusData ?>"/>
            <input type="hidden" id="gantiPassword" value="<?php echo $gantiPassword ?>"/>
            <input type="hidden" id="adminGrup" value="<?php echo $pengguna_grup ?>"/>
            <input type="hidden" id="sessionIdAdmin" value="<?php echo $this->session->userdata['adminDaftarPresensi']['pengguna_id']?>">
          </div>
          <br>
          <!--card header-->
          <div class='card-body table-responsive p-0'>
            <table id="tableData" class='table table-striped table-bordered table-hover text-nowrap'>
            <thead class="bg-primary">
              <tr class=''>
                <th>No</th>
                <th>Judul Menu</th>
                <th>Sub Judul Menu</th>
                <th>Url Menu</th>
                <th>Icon Menu</th>
                <th>Menu Aktif</th>
                <th>Opsi</th>
              </tr>
            <thead>
            </table>
          </div>
          <!--card body-->
          </div>
      </div>
    </div>
  </div>
  </section>