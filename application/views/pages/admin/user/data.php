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
            <div class="float-right">
            <?php if(isset($priviliges->{8})){ ?><a href="<?php echo $tambahData ?>"><button class="btn btn-primary btn-sm text-bold">Tambah Pengguna</button></a><?php }else{?><button class="btn btn-default btn-sm text-bold" disabled>Tambah Pengguna</button><?php } ?>
            <?php if(isset($priviliges->{23})){ ?><a href="<?php echo $exportpdf ?>"><button class="btn btn-info btn-sm text-bold" ><i class="fas fa-file-pdf"></i> PDF</button><a><?php }else{?><button class="btn btn-default btn-sm text-bold" disabled><i class="fas fa-file-pdf"></i> PDF</button><?php } ?>
            <?php if(isset($priviliges->{24})){ ?><a href="<?php echo $exportexcel ?>"><button class="btn btn-info btn-sm text-bold" ><i class="fas fa-file-excel"></i> Excel</button><a><?php }else{?><button class="btn btn-default btn-sm text-bold" disabled><i class="fas fa-file-excel"></i> Excel</button><?php } ?>
            </div>

            <input type="hidden" id="dataJson" value="<?php echo $dataJson ?>"/>
            <input type="hidden" id="editData" value="<?php echo $editData ?>"/>
            <input type="hidden" id="hapusJson" value="<?php echo $hapusData ?>"/>
            <input type="hidden" id="gantiPassword" value="<?php echo $gantiPassword ?>"/>
            <input type="hidden" id="adminGrup" value="<?php echo $pengguna_grup ?>"/>
            <input type="hidden" id="sessionIdAdmin" value="<?php echo $this->session->userdata['adminPjjKuttab']['pengguna_id']?>">
          </div>
          <br>
          <!--card header-->
          <div class='card-body table-responsive p-0'>
            <table id="tableData" class='table table-striped table-bordered table-hover text-nowrap'>
            <thead class="bg-primary">
              <tr class=''>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Grup</th>
                <th>Password</th>
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
  