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
            <?php if(isset($priviliges->{14})){?><a href="<?php echo $tambahData ?>"><button class="btn btn-primary btn-sm float-right text-bold">Tambah Grup</button></a><?php }else{?><button class="btn btn-default btn-sm float-right text-bold" disabled>Tambah Grup</button><?php } ?>
            <input type="hidden" id="dataJson" value="<?php echo $dataJson ?>"/>
            <input type="hidden" id="editData" value="<?php echo $editData ?>"/>
            <input type="hidden" id="hapusJson" value="<?php echo $hapusData ?>"/>
            <input type="hidden" id="hakAkses" value="<?php echo $hakAkses?>" />
          </div>
          <!--card header-->
          <div class='card-body table-responsive p-0'>
            <table id="tableData" class='table table-striped table-bordered table-hover text-nowrap'>
            <thead class="bg-primary">
              <tr class=''>
                <th>No</th>
                <th>Nama Grup</th>
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
