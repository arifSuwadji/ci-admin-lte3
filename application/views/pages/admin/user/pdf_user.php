<!DOCTYPE html>
<html>
<head>
  <?php $title= array("Dashboard"); if($menuHalaman){$title = explode('(',$menuHalaman->sub_judul_menu); }?>
  <title>Aplikasi Donasi Kader | <?php echo $title[0] ?></title>
  <?php echo asset_icon('AdminLTELogo.png')?>
  <?php echo asset_plugin_css('tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>
  <?php echo asset_css('adminlte.min.css') ?>
  <style>
    table, td, th {
        border: 1px solid black;
    }
    
    td, th {
        padding-top: 10px;
        padding-bottom: 5px;
        padding-left: 3px;
        padding-right: 3px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }
  </style>
</head>
<body style="font-size:12px;">
	<div >
        <div style="text-align:right;" class="float-right">
            <br><?php if($menuHalaman){$title = explode('(',$menuHalaman->sub_judul_menu); } echo $title[0] ?>,  <?php echo dateText(date("d-m-Y")) ?>
        </div>
        <br>
        <br>
        <table class="table table-striped table-bordered table-hover text-nowrap">
            <thead class="bg-primary">
                <tr style="line-height: 6px;">
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Grup</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; ?>
                <?php foreach($users->result() as $user): ?>
                <tr style="line-height: 6px;">
                    <td style="text-align:right;"><?php echo $no; ?></td>
                    <td><?php echo $user->nama_pengguna; ?></td>
                    <td><?php echo $user->email; ?></td>
                    <td><?php echo $user->nama_grup; ?></td>
                </tr>
                <?php $no++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
	 </div>
</body>
</html>
