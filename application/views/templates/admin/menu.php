
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo base_url() ?>" class="brand-link">
    <?php echo asset_logo('AdminLTELogo.png')?>
    <span class="brand-text font-weight-light">PJJ-Kuttab</span>
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <?php echo asset_image_profile('user2-160x160.jpg')?>
        </div>
        <div class="info">
        <a href="#" class="d-block"><?php echo $nama_pengguna ?></a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
            <li class="nav-item">
                <a href="<?php echo base_url('admin') ?>" class="nav-link <?php echo $current_url == 'admin' ? 'active' : '' ?>">
                <i class="nav-icon fas fa-th"></i>
                <p>
                    Dashboard
                </p>
                </a>
                
            </li>
        <?php
        $icon_menu = $menuHalaman ? $menuHalaman->icon_menu : 'nav-icon fas fa-th';
        $lastJudul = '';
        foreach($menuPriviliges->result() as $priv){ ?>
            <?php if($lastJudul != $priv->judul_menu){ ?>
            <li class="nav-header"><?php echo strtoupper($priv->judul_menu) ?></li>
            <?php } $lastJudul = $priv->judul_menu ?>
            <?php if($priv->hitungMenu > 1){
                $activeArrayIcon = array();
                $arrayIcon = explode(',', $priv->tampilkanIcon);
                foreach($arrayIcon as $icon){
                    $activeArrayIcon[$icon] = $icon;
                }
                $activeArrayUrl = array();
                $arrayUrl = explode(',', $priv->tampilkanUrl);
                foreach($arrayUrl as $url){
                    $activeArrayUrl[$url] = $url;
                }
            ?>
            <li class="nav-item has-treeview <?php echo $current_url == array_search($current_url, $activeArrayUrl) ? 'menu-open': $icon_menu == array_search($icon_menu, $activeArrayIcon) ? 'menu-open': '' ?>">
                <a href="javascript:void(0)" class="nav-link <?php echo $current_url == array_search($current_url, $activeArrayUrl) ? 'active': $icon_menu == array_search($icon_menu, $activeArrayIcon) ? 'active': '' ?>">
                <i class="<?php echo $priv->icon_menu ?>"></i>
                <p>
                    <?php echo ucfirst($priv->judul_menu) ?>
                    <i class="fas fa-angle-left right"></i>
                </p>
                </a>
                <ul class="nav nav-treeview">
                <?php
                    $arrayMenu = explode(';', $priv->tampilkanMenu);
                    foreach($arrayMenu as $menu){
                    $arrayList = explode('_', $menu);
                ?>
                    <li class="nav-item">
                        <a href="<?php echo base_url($arrayList[1]) ?>" class="nav-link <?php echo $current_url == $arrayList[1] ? 'active': $icon_menu == $arrayList[0] ? 'active': '' ?>">
                        <i class="<?php echo $arrayList[0] ?>"></i>
                        <p><?php echo $arrayList[2] ?></p>
                        </a>
                    </li>
                <?php } ?>
                </ul>
            </li>
            <?php }else{ ?>
            <li class="nav-item">
                <a href="<?php echo base_url($priv->url_menu) ?>" class="nav-link <?php echo $current_url == $priv->url_menu ? 'active': $icon_menu == $priv->icon_menu ? 'active': '' ?>">
                <i class="<?php echo $priv->icon_menu ?>"></i> 
                <p><?php echo $priv->sub_judul_menu ?></p>
                </a>
            </li>
            <?php } ?>
        <?php } ?>
            <li class="nav-item">
                <a href="<?php echo base_url('admin/logout')?>" class="nav-link">
                <i class="nav-icon far fa-circle text-danger"></i>
                <p class="text">Keluar</p>
                </a>
            </li>
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
