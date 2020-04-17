<?php

class AdjiGenerator extends CI_Controller {
    private $buttonTambah = '';
    private $buttonTambahAksi = '';
    private $buttonEdit = '';
    private $buttonEditAksi = '';
    private $buttonHapus = '';
    
    public function __construct(){
        parent::__construct();
    }

    public function help(){
        $result = "Adji Generator commands\r\n";
        $result .= "php index.php AdjiGenerator create ControllerName Database_Name \r\n";
        echo $result. PHP_EOL;
    }

    public function create($controller="", $database=""){
        $allColumns = AllField($database);
        $dataFilter = array();
        foreach($allColumns as $fieldName){
            array_push($dataFilter, $fieldName['column_name']);
        }

        //write router
        $routePath = APPPATH."config/routes.php";
        $data ="\$route['admin/".$controller."'] = 'admin/".$controller."';\r\n";
        $judul_menu = str_replace('_',' ', $database);
        $judul_menu = ucwords($judul_menu);
        $sub_judul = 'Data '.$judul_menu;
        $url_menu = 'admin/'.$controller;
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'ya';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $this->db->get_where('halaman_menu', $where)->row();
        if(!$findData){
            $this->db->insert('halaman_menu', $where);
        }

        $data .="\$route['admin/".$controller."Json'] = 'admin/".$controller."/dataJson';\r\n";
        $data .="\$route['admin/tambah".$controller."'] = 'admin/".$controller."/tambah';\r\n";
        //insert tambah
        $sub_judul = 'Tambah '.$judul_menu;
        $url_menu = 'admin/tambah'.$controller;
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'tidak';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $this->db->get_where('halaman_menu', $where)->row();
        if($findData){
            $this->buttonTambah = $findData->menu_id;
        }else{
            $this->db->insert('halaman_menu', $where);
            $this->buttonTambah = $this->db->insert_id();
        }

        $data .="\$route['admin/tambah".$controller."Baru'] = 'admin/".$controller."/tambahBaru';\r\n";
        //insert tambah aksi
        $sub_judul = 'Tambah '.$judul_menu.' (Aksi)';
        $url_menu = 'admin/tambah'.$controller.'Baru';
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'tidak';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $this->db->get_where('halaman_menu', $where)->row();
        if($findData){
            $this->buttonTambahAksi = $findData->menu_id;
        }else{
            $this->db->insert('halaman_menu', $where);
            $this->buttonTambahAksi = $this->db->insert_id();
        }

        $data .="\$route['admin/edit".$controller."/"."(:num)'] = 'admin/".$controller."/edit';\r\n";
        //insert edit
        $sub_judul = 'Edit '.$judul_menu;
        $url_menu = 'admin/edit'.$controller;
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'tidak';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $this->db->get_where('halaman_menu', $where)->row();
        if($findData){
            $this->buttonEdit = $findData->menu_id;
        }else{
            $this->db->insert('halaman_menu', $where);
            $this->buttonEdit = $this->db->insert_id();
        }

        $data .="\$route['admin/update".$controller."'] = 'admin/".$controller."/update';\r\n";
        //insert update
        $sub_judul = 'Edit '.$judul_menu.' (Aksi)';
        $url_menu = 'admin/update'.$controller;
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'tidak';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $this->db->get_where('halaman_menu', $where)->row();
        if($findData){
            $this->buttonEditAksi = $findData->menu_id;
        }else{
            $this->db->insert('halaman_menu', $where);
            $this->buttonEditAksi = $this->db->insert_id();
        }

        $data .="\$route['admin/hapus".$controller."'] = 'admin/".$controller."/hapus';\r\n";
        //insert hapus
        $sub_judul = 'Hapus '.$judul_menu;
        $url_menu = 'admin/hapus'.$controller;
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'tidak';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $this->db->get_where('halaman_menu', $where)->row();
        if($findData){
            $this->buttonHapus = $findData->menu_id;
        }else{
            $this->db->insert('halaman_menu', $where);
            $this->buttonHapus = $this->db->insert_id();
        }

        if(!write_file($routePath, $data, 'a')){
            echo 'Unable to write Router the file'."\r\n";
        }else{
            echo 'Router written!'."\r\n";
        }

        $string = "<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class ".$controller." extends CI_Controller{
    public function __construct(){
        parent::__construct();
        
        is_login();

        ";
        $string .='$this->load->model("admin/ModelPengguna");'."\r\n";
        $string .="\t\t".'$this->load->model("admin/ModelHalamanMenu");'."\r\n";
        $string .="\t\t".'$this->load->model("admin/Model'.$controller.'");'."\r\n";
        $string .="
    }
        ";
        $string .='
    public function index($page = "'.$database.'/data"){;
        if(!file_exists(APPPATH."views/pages/admin/$page.php")){
            show_404();
        }
    ';

        $tableName = str_replace('_',' ', $database);
        $string .='
        $dataAdmin = data_admin($this->ModelPengguna);
        if($dataAdmin){
            $row = $dataAdmin->row_array();
            $data = array();
            $data["title"] = ucfirst("Data '.$tableName.'");
            $data["filejs"] = base_url()."public/admin/assets/'.$controller.'.js";
            $data["dataJson"] = base_url()."admin/'.$controller.'Json";
            $data["tambahData"] = base_url()."admin/tambah'.$controller.'";
            $data["editData"] = base_url()."admin/edit'.$controller.'";
            $data["hapusData"] = base_url()."admin/hapus'.$controller.'";
            $current_url = $this->uri->segment(1);
            if($this->uri->segment(2)){
                $current_url .= "/".$this->uri->segment(2);
            }
            $data["current_url"] = $current_url;
            $data["fixed"] = "fixed";
            if($row){
                $dataGrup = $this->ModelPengguna->idGrup($row["pengguna_grup"])->row_array();
                $data["nama_pengguna"] = $row["nama_pengguna"];
                $data["nama_grup"] = $dataGrup["nama_grup"];
                $data["pengguna_grup"] = $row["pengguna_grup"];
                $data["errmsg"] = $_GET ? $this->input->get("errmsg") : "";
                $data["menuHalaman"] = $this->ModelHalamanMenu->byUrl($current_url)->row();
                $data["menuPriviliges"] = $this->ModelHalamanMenu->byPeta($row["pengguna_grup"], "ya");
                $dataHalaman = $this->ModelHalamanMenu->byPeta($row["pengguna_grup"], "tidak");
                $data["priviliges"] = button_halaman($dataHalaman);
            }
        
            template_admin($page, $data);
        }
    }
        ';
        $string .='
    public function dataJson(){
        $draw = (int)$this->input->get("draw");
        $value = $this->input->get("search")["value"];
        $start = (int)$this->input->get("start");
        $length = (int)$this->input->get("length");
        $column = (int)$this->input->get("order")[0]["column"];
        $sort = $this->input->get("order")[0]["dir"];
        $recodsTotal = $this->Model'.$controller.'->count'.$controller.'($value);
        $list'.$controller.' = $this->Model'.$controller.'->list'.$controller.'($value, $start, $length, $column, $sort);
        $results = array();
        $dataAdmin = data_admin($this->ModelPengguna);
        $row = $dataAdmin->row_array();
        $idHalamanEdit = '.$this->buttonEdit.';
        $idHalamanHapus = '.$this->buttonHapus.';
        if($row){
            $dataHalaman = $this->ModelHalamanMenu->byPetaHalaman($row["pengguna_grup"], $idHalamanHapus);
            $priviligesDelete = $dataHalaman->row_array();
            $dataHalamanEdit = $this->ModelHalamanMenu->byPetaHalaman($row["pengguna_grup"], $idHalamanEdit);
            $priviligesDetail = $dataHalamanEdit->row_array();
            foreach ($list'.$controller.'->result() as $list) {
                $dataRow = [
        ';
            foreach($dataFilter as $fieldName){
        $string .='
                "'.$fieldName.'" => $list->'.$fieldName.',
        ';
                }
        $string .='
                $idHalamanHapus => $priviligesDelete["pengguna_grup"], $idHalamanEdit => $priviligesDetail["pengguna_grup"]];
                array_push($results, $dataRow);
            }
        }
        $response = array(
            "draw" =>  $draw,
            "recordsTotal" => $recodsTotal,
            "recordsFiltered" => $recodsTotal,
            "value" => $value,
            "start" => $start,
            "length" => $length,
            "column" => $column,
            "sort" => $sort,
            "data" => $results
        );
        $this->output
        ->set_status_header(200)
        ->set_content_type("application/json", "utf-8")
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;
    }
        ';
        //tambah
        $string .='
    public function tambah($page = "'.$database.'/tambah"){
        if(!file_exists(APPPATH."views/pages/admin/".$page.".php")){
            show_404();
        }

        $dataAdmin = data_admin($this->ModelPengguna);
        $row = $dataAdmin->row_array();
        $data = array();
        $data["filejs"] = "";
        ';
        foreach($dataFilter as $fieldName){
        $string .='
        $data["'.$fieldName.'"] = "";
        ';
        }
        $string .='
        $current_url = $this->uri->segment(1);
        if($this->uri->segment(2)){
            $current_url .= "/".$this->uri->segment(2);
        }
        $data["current_url"] = $current_url;
        $data["fixed"] = "fixed";
        if($row){
            $dataGrup = $this->ModelPengguna->idGrup($row["pengguna_grup"])->row_array();
            $data["nama_pengguna"] = $row["nama_pengguna"];
            $data["nama_grup"] = $dataGrup["nama_grup"];
            $data["pengguna_grup"] = $row["pengguna_grup"];
            $data["errmsg"] = $_GET ? $this->input->get("errmsg") : "";
            $data["menuHalaman"] = $this->ModelHalamanMenu->byUrl($current_url)->row();
            $data["menuPriviliges"] = $this->ModelHalamanMenu->byPeta($row["pengguna_grup"], "ya");
            $dataHalaman = $this->ModelHalamanMenu->byPeta($row["pengguna_grup"], "tidak");
            $data["priviliges"] = button_halaman($dataHalaman);
        }
        $dataGrup = $this->ModelPengguna->dataGrup();
        $data["data_grup"] = $dataGrup;

        template_admin($page, $data);
    }
        ';
        // action tambah
        $string .='
    public function tambahBaru($page = "'.$database.'/tambah"){
        $dataValidation = array(
        ';
        foreach($dataFilter as $fieldName){
        $string .='
            "'.$fieldName.'" => "belum diisi",
        ';
        }
        $string .='
        );
        is_validation($dataValidation);

        $data = array();
        ';
        foreach($dataFilter as $fieldName){
        $string .='
        $data["'.$fieldName.'"] = $this->input->post("'.$fieldName.'");
        ';
        }
        $string .='
        $data["errmsg"] = "";
        $data["filejs"] = "";
        $dataAdmin = data_admin($this->ModelPengguna);
        $row = $dataAdmin->row_array();
        $current_url = $this->uri->segment(1);
        if($this->uri->segment(2)){
            $current_url .= "/".$this->uri->segment(2);
        }
        $data["current_url"] = $current_url;
        $data["fixed"] = "";
        if($row){
            $dataGrup = $this->ModelPengguna->idGrup($row["pengguna_grup"])->row_array();
            $data["nama_pengguna"] = $row["nama_pengguna"];
            $data["nama_grup"] = $dataGrup["nama_grup"];
            $data["pengguna_grup"] = $row["pengguna_grup"];
            $data["errmsg"] = $_GET ? $this->input->get("errmsg") : "";
            $data["menuHalaman"] = $this->ModelHalamanMenu->byUrl($current_url)->row();
            $data["menuPriviliges"] = $this->ModelHalamanMenu->byPeta($row["pengguna_grup"], "ya");
            $dataHalaman = $this->ModelHalamanMenu->byPeta($row["pengguna_grup"], "tidak");
            $data["priviliges"] = button_halaman($dataHalaman);
        }
        $dataGrup = $this->ModelPengguna->dataGrup();
        $data["data_grup"] = $dataGrup;
        if($this->form_validation->run() == FALSE){
            template_admin($page, $data);
        }else{
            $insert = array();
        ';
        foreach($dataFilter as $fieldName){
        $string .='
            $insert["'.$fieldName.'"] = $this->input->post("'.$fieldName.'");
        ';
        }
        $string .='
            $this->db->insert("'.$database.'", $insert);
            $errmsg = "";
            $this->db->affected_rows() != 1 ? $errmsg = "gagal" : $errmsg = "berhasil";
            if($errmsg == "gagal"){
        ';
        $string .='
                redirect(base_url()."admin/tambah'.$controller.'?errmsg=".$errmsg
        ';
        foreach($dataFilter as $fieldName){
        $string .="\t\t".'."&'.$fieldName.'=".$this->input->post("'.$fieldName.'")
        ';
        }
        $string .='
                );
            }else if($errmsg == "berhasil"){
                redirect(base_url()."admin/'.$controller.'");
            }
        }
    }
        ';

        //edit
        $string .='
    public function edit($page = "'.$database.'/edit"){
        if(!file_exists(APPPATH."views/pages/admin/".$page.".php")){
            show_404();
        }

        $dataAdmin = data_admin($this->ModelPengguna);
        if($dataAdmin){
            $row = $dataAdmin->row_array();
            $data = array();
            $data["filejs"] = "";
            $data["select_pengguna_grup"] = "";
            $current_url = $this->uri->segment(1);
            if($this->uri->segment(2)){
                $current_url .= "/".$this->uri->segment(2);
            }
            $data["current_url"] = $current_url;
            $data["fixed"] = "fixed";
            if($row){
                $dataGrup = $this->ModelPengguna->idGrup($row["pengguna_grup"])->row_array();
                $data["nama_pengguna"] = $row["nama_pengguna"];
                $data["nama_grup"] = $dataGrup["nama_grup"];
                $data["pengguna_grup"] = $row["pengguna_grup"];
                $data["errmsg"] = $_GET ? $this->input->get("errmsg") : "";
                $data["menuHalaman"] = $this->ModelHalamanMenu->byUrl($current_url)->row();
                $data["menuPriviliges"] = $this->ModelHalamanMenu->byPeta($row["pengguna_grup"], "ya");
                $dataHalaman = $this->ModelHalamanMenu->byPeta($row["pengguna_grup"], "tidak");
                $data["priviliges"] = button_halaman($dataHalaman);
                $dataEdit = $this->Model'.$controller.'->'.$dataFilter[0].'($this->uri->segment(3));
                $rowEdit = $dataEdit->row_array();
                if($rowEdit){
        ';
        $i = 0;
        foreach($dataFilter as $fieldName){
            $i++;
            if($i > 1){
        $string .='
                    $data["'.$fieldName.'"] = $rowEdit["'.$fieldName.'"];
        ';
            }
        }
        $string .='
                    $data["'.$dataFilter[0].'_edit"] = $rowEdit["'.$dataFilter[0].'"];
                }
            }
            $dataGrup = $this->ModelPengguna->dataGrup();
            $data["data_grup"] = $dataGrup;
    
            template_admin($page, $data);
        }
    }
        ';

        //update
        $string .='
    public function update($page = "'.$database.'/edit"){
        $dataValidation = array(
        ';
        $i =0;
        foreach($dataFilter as $fieldName){
            $i++;
            if($i > 1){
        $string .='
            "'.$fieldName.'" => "belum diisi",
        ';
            }
        }
        $string .='
        );
        is_validation($dataValidation);
        
        $data = array();
        ';
        $i =0;
        foreach($dataFilter as $fieldName){
            $i++;
            if($i > 1){
        $string .='
        $data["'.$fieldName.'"] = $this->input->post("'.$fieldName.'");
        ';
            }
        }
        
        $string .='
        $data["errmsg"] = "";
        $data["filejs"] = "";
        $dataAdmin = data_admin($this->ModelPengguna);
        $row = $dataAdmin->row_array();
        $current_url = $this->uri->segment(1);
        if($this->uri->segment(2)){
            $current_url .= "/".$this->uri->segment(2);
        }
        $data["current_url"] = $current_url;
        $data["fixed"] = "";
        if($row){
            $dataGrup = $this->ModelPengguna->idGrup($row["pengguna_grup"])->row_array();
            $data["nama_pengguna"] = $row["nama_pengguna"];
            $data["nama_grup"] = $dataGrup["nama_grup"];
            $data["pengguna_grup"] = $row["pengguna_grup"];
            $data["errmsg"] = $_GET ? $this->input->get("errmsg") : "";
            $data["menuHalaman"] = $this->ModelHalamanMenu->byUrl($current_url)->row();
            $data["menuPriviliges"] = $this->ModelHalamanMenu->byPeta($row["pengguna_grup"], "ya");
            $dataHalaman = $this->ModelHalamanMenu->byPeta($row["pengguna_grup"], "tidak");
            $data["priviliges"] = button_halaman($dataHalaman);
            $dataEdit = $this->Model'.$controller.'->'.$dataFilter[0].'($this->input->post("'.$dataFilter[0].'_edit"));
            $rowEdit = $dataEdit->row_array();
            if($rowEdit){
        ';
        $i = 0;
        foreach($dataFilter as $fieldName){
            $i++;
            if($i > 1){
        $string .='
                $data["'.$fieldName.'"] = $rowEdit["'.$fieldName.'"];
        ';
            }
        }
        $string .='
                $data["'.$dataFilter[0].'_edit"] = $rowEdit["'.$dataFilter[0].'"];
            }
        }
        $dataGrup = $this->ModelPengguna->dataGrup();
        $data["data_grup"] = $dataGrup;
        if($this->form_validation->run() == FALSE){
            template_admin($page, $data);
        }else{
            $update = array();
        ';
        $i = 0;
        foreach($dataFilter as $fieldName){
            $i++;
            if($i > 1){
        $string .='
            $update["'.$fieldName.'"] = $this->input->post("'.$fieldName.'");
        ';
            }
        }
        $string .='
            $this->db->where("'.$dataFilter[0].'", $this->input->post("'.$dataFilter[0].'_edit"));
            $this->db->update("'.$database.'", $update);
            $errmsg = "";
            $this->db->affected_rows() != 1 ? $errmsg = "gagal" : $errmsg = "berhasil";
            if($errmsg == "gagal"){
        ';
        $string .='
                redirect(base_url()."admin/edit'.$controller.'/$this->input->post(\''.$dataFilter[0].'_edit\')?errmsg=".$errmsg
        ';
        foreach($dataFilter as $fieldName){
        $string .="\t\t".'."&'.$fieldName.'=".$this->input->post("'.$fieldName.'")
        ';
        }
        $string .='
                );
            }else if($errmsg == "berhasil"){
                redirect(base_url()."admin/'.$controller.'");
            }
        }
    }
        ';

        //hapus
        $string .='
    public function hapus(){
        $'.$dataFilter[0].' = $this->input->post("'.$dataFilter[0].'");
        $this->Model'.$controller.'->hapusData($'.$dataFilter[0].');
        $response = array(
            "status" => "success",
            "message" => "Data Berhasil dihapus"
        );
        $this->output
            ->set_status_header(200)
            ->set_content_type("application/json", "utf-8")
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }
}
?>
        ';
        
        $path = APPPATH."controllers/admin/".$controller.".php";
        createFile($string, $path);

        //load template index
        $this->template_index($controller, $database);

        //load template tambah
        $this->template_tambah($controller, $database);

        //load template edit
        $this->template_edit($controller, $database);

        //load models
        $this->model_generator($controller, $database);

        //load js
        $this->js_generator($controller, $database);

        echo "Class ".$controller."\r\n";
        echo "Database ".$database."\r\n";
    }

    public function model_generator($controller, $database){
        $allColumns = AllField($database);
        $dataFilter = array();
        foreach($allColumns as $fieldName){
            array_push($dataFilter, $fieldName['column_name']);
        }
        $string ='<?php
    defined("BASEPATH") OR exit("No direct script access allowed");

    class Model'.$controller.' extends CI_model{
        private $table = "'.$database.'";

        public function '.$dataFilter[0].'($'.$dataFilter[0].'){
            return $this->db->get_where($this->table, array("'.$dataFilter[0].'" => $'.$dataFilter[0].'));
        }

        function hapusData($'.$dataFilter[0].'){
            return $this->db->delete($this->table, array("'.$dataFilter[0].'" => $'.$dataFilter[0].'));
        }

        function count'.$controller.'($value){
            if($value){
                $this->db->or_like("'.$dataFilter[1].'", $value);
                $this->db->or_like("'.$dataFilter[2].'", $value);
            }
            $this->db->from($this->table);
            return  $this->db->count_all_results();
        }

        function list'.$controller.'($value, $start, $length, $column, $sort){
            if($value){
                $this->db->or_like("'.$dataFilter[1].'", $value);
                $this->db->or_like("'.$dataFilter[2].'", $value);
            }
            if($column == 0){
                $this->db->order_by("'.$dataFilter[0].'", $sort);
            }else if($column == 1){
                $this->db->order_by("'.$dataFilter[1].'", $sort);
            }else if($column == 2){
                $this->db->order_by("'.$dataFilter[2].'", $sort);
            }
            
            if($start){
                $this->db->select("*");
                $this->db->from($this->table);
                return $this->db->limit($length, $start)->get();
            }else{
                $this->db->select("*");
                $this->db->from($this->table);
                return $this->db->limit($length)->get();
            }
        }
    }
?>
        ';
        $path = APPPATH."models/admin/Model".$controller.".php";
        createFile($string, $path);
    }

    public function template_index($controller, $database){
        $allColumns = AllField($database);
        $dataFilter = array();
        foreach($allColumns as $fieldName){
            array_push($dataFilter, $fieldName['column_name']);
        }
        $string ='
    <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1><?php echo $menuHalaman->judul_menu ?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><i class="<?php echo $menuHalaman->icon_menu ?>"></i> <?php echo $menuHalaman->judul_menu ?></a></li>
                <li class="breadcrumb-item active">Data <?php echo $menuHalaman->sub_judul_menu ?></li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                  <h3 class="card-title"><?php echo $menuHalaman->sub_judul_menu ?></h3>
                  <?php if(isset($priviliges->{'.$this->buttonTambah.'})){ ?><a href="<?php echo $tambahData ?>"><button class="btn btn-primary btn-sm float-right text-bold">Tambah '.ucwords(str_replace('_',' ', $database)).'</button></a><?php }else{?><button class="btn btn-default btn-sm float-right text-bold" disabled>Tambah '.ucwords(str_replace('_',' ', $database)).'</button><?php } ?>
                  <input type="hidden" id="dataJson" value="<?php echo $dataJson ?>"/>
                  <input type="hidden" id="editData" value="<?php echo $editData ?>"/>
                  <input type="hidden" id="hapusJson" value="<?php echo $hapusData ?>"/>
                  <input type="hidden" id="adminGrup" value="<?php echo $pengguna_grup ?>"/>
                  <input type="hidden" id="sessionIdAdmin" value="<?php echo $this->session->userdata["adminDistribusi"]["pengguna_id"]?>">
                </div>
                <!--card header-->
                <div class="card-body table-responsive p-0">
                  <table id="tableData" class="table table-striped table-bordered table-hover text-nowrap">
                  <thead class="bg-primary">
                    <tr class="">
        ';
        foreach($dataFilter as $fieldName){
            $langField = str_replace('_',' ', $fieldName);
            $langField = ucwords($langField);
        $string .='
                      <th>'.$langField.'</th>
        ';
        }
        $string .='
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
        ';
        $path = APPPATH."views/pages/admin/".$database."/data.php";
        if(is_file($path)){
        }else{
            mkdir(APPPATH."views/pages/admin/".$database);
        }
        createFile($string, $path);
    }

    public function template_tambah($controller, $database){
        $allColumns = AllField($database);
        $dataFilter = array();
        foreach($allColumns as $fieldName){
            array_push($dataFilter, $fieldName['column_name']);
        }
        $string ='
    <!-- Content Header (Page header) -->
    <?php $title = explode("(",$menuHalaman->sub_judul_menu); ?>
    <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1><?php echo $title[0] ?></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><i class="<?php echo $menuHalaman->icon_menu ?>"></i> <?php echo $menuHalaman->judul_menu ?></a></li>
            <li class="breadcrumb-item active"><?php echo $menuHalaman->sub_judul_menu ?></li>
            </ol>
        </div>
        </div>
    </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
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
        <!-- form -->
        <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Form <?php echo $menuHalaman->sub_judul_menu ?></h3>
        </div>
        <!-- /.card-header -->
        <?php
            $attributes = array("class" => "form-horizontal");
            echo form_open("admin/tambah'.$controller.'Baru", $attributes);
        ?>
        <div class="card-body">
        ';
        foreach($dataFilter as $fieldName){
            $langField = str_replace('_',' ', $fieldName);
            $langField = ucwords($langField);
        $string .='
            <div class="form-group">
                <label for="pengguna">'.$langField.'</label>
                <input type="text" class="form-control" placeholder="'.$langField.'" name="'.$fieldName.'" value="<?php echo $'.$fieldName.' ?>">
            </div>
        ';
        }
        $string .='
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <input type="hidden" name="baseURL" id="baseURL" value="<?php echo base_url() ?>" />
            <?php if(isset($priviliges->{'.$this->buttonTambahAksi.'})){ ?>                    
            <button type="submit" id="lanjut" class="btn bg-primary pull-right">Tambah</button>
            <?php }else{?><button class="pull-right btn btn-default text-bold" disabled>Tambah</button><?php } ?>
        </div>
        <?php echo form_close() ?>
        </div>
    </div>
    </section>
    
        ';
        $path = APPPATH."views/pages/admin/".$database."/tambah.php";
        createFile($string, $path);
    }

    public function template_edit($controller, $database){
        $allColumns = AllField($database);
        $dataFilter = array();
        foreach($allColumns as $fieldName){
            array_push($dataFilter, $fieldName['column_name']);
        }
        $string ='
    <!-- Content Header (Page header) -->
    <?php $title = explode("(",$menuHalaman->sub_judul_menu); ?>
    <section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1><?php echo $title[0] ?></h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?php echo base_url() ?>"><i class="<?php echo $menuHalaman->icon_menu ?>"></i> <?php echo $menuHalaman->judul_menu ?></a></li>
            <li class="breadcrumb-item active"><?php echo $menuHalaman->sub_judul_menu ?></li>
            </ol>
        </div>
        </div>
    </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
    <div class="container-fluid">
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
        <!-- form -->
        <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Form <?php echo $menuHalaman->sub_judul_menu ?></h3>
        </div>
        <!-- /.card-header -->
        <?php
            $attributes = array("class" => "form-horizontal");
            echo form_open("admin/update'.$controller.'", $attributes);
        ?>
        <div class="card-body">
        ';
        $i = 0;
        foreach($dataFilter as $fieldName){
            $i++;
            $langField = str_replace('_',' ', $fieldName);
            $langField = ucwords($langField);
            if($i > 1){
        $string .='
            <div class="form-group">
                <label for="pengguna">'.$langField.'</label>
                <input type="text" class="form-control" placeholder="'.$langField.'" name="'.$fieldName.'" value="<?php echo $'.$fieldName.' ?>">
            </div>
        ';
            }
        }
        $string .='
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <input type="hidden" name="baseURL" id="baseURL" value="<?php echo base_url() ?>" />
            <input type="hidden" name="'.$dataFilter[0].'_edit" value="<?php echo $'.$dataFilter[0].'_edit ?>">
            <?php if(isset($priviliges->{'.$this->buttonEditAksi.'})){ ?>                    
            <button type="submit" id="lanjut" class="btn bg-primary pull-right">Perbarui</button>
            <?php }else{?><button class="pull-right btn btn-default text-bold" disabled>Perbarui</button><?php } ?>
        </div>
        <?php echo form_close() ?>
        </div>
    </div>
    </section>
    
        ';
        $path = APPPATH."views/pages/admin/".$database."/edit.php";
        createFile($string, $path);
    }

    public function js_generator($controller, $database){
        $allColumns = AllField($database);
        $dataFilter = array();
        foreach($allColumns as $fieldName){
            array_push($dataFilter, $fieldName['column_name']);
        }
        $string = '
let ajaxJson = $("#dataJson").val();
let urlEditData = $("#editData").val();
let hapusJson = $("#hapusJson").val();
let adminGrup = $("#adminGrup").val();
let sessionIdAdmin = $("#sessionIdAdmin").val();
let table = $("#tableData").DataTable({
    "paging"      : true,
    "lengthChange": true,
    "searching"   : true,
    "ordering"    : true,
    "autoWidth"   : false,
    "info"        : true,
    "processing"  : true,
    "serverSide"  : true,
    "ajax" : ajaxJson,
    "columns" : [
        ';
        $string .='
      {
        "mRender": function(data, type, full){
            return `<span class="pull-right">${full["'.$dataFilter[0].'"]}</span>`;
        }
      },
        ';
        $i=0;
        foreach($dataFilter as $fieldName){
            $i++;
            if($i > 1){
        $string .='
      { "data": "'.$fieldName.'" },
        ';
            }
        }
        $string .='
      { "mRender": function(data, type, full){
          let aksesEdit = ""; let aksesHapus = "";
          let editData = `editData(${full["'.$dataFilter[0].'"]})`;
          let hapusData = `hapusData(${full["'.$dataFilter[0].'"]})`;
          if(!full['.$this->buttonEdit.']){
            aksesEdit = "disabled";
            editData = "";
          }
          if(!full['.$this->buttonHapus.']){
            aksesHapus = "disabled";
            hapusData = "";
          }
          return `<div class="btn-group dropleft">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-ellipsis-v"></span></button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <a class="dropdown-item" href="javascript:void(0);" onClick="${editData}">
                            <button class="btn btn-warning btn-block btn-sm text-bold ${aksesEdit}">Edit</button>
                        </a>
                        <a class="dropdown-item" href="javascript:void(0);" onClick="${hapusData}">
                            <button class="btn btn-danger btn-block btn-sm text-bold ${aksesHapus}">Hapus</button>
                        </a>
                    </div>
                  </div>`;
      }}
    ],
  });

table.on( "order.dt search.dt", function () {
    table.column(0, {search:"applied", order:"applied"}).nodes().each( function (cell, i) {
        //cell.innerHTML = i+1;
        cell.innerHTML = i+1;
    } );
} ).draw();

table.on("draw.dt", function(){
    table.column(0).nodes().each( function (cell, i) {
        let info = table.page.info();
        let page = info.page;
        let length = table.page.len();
        if(page >= 1){
            page = page * length;
        }
        cell.innerHTML = page+i+1;
    } );
});

function editData('.$dataFilter[0].'){
    console.log("'.$dataFilter[0].' "+'.$dataFilter[0].');
    $(location).attr("href", urlEditData+"/"+'.$dataFilter[0].');
}

function hapusData('.$dataFilter[0].'){
    console.log("'.$dataFilter[0].' "+'.$dataFilter[0].');
    $.post(hapusJson, {'.$dataFilter[0].': '.$dataFilter[0].'}, function(data, status){
        console.log(data);
        if(data.status == "success"){
            Swal.fire({
              position: "top-end",
              type: "success",
              title: "Data Telah dihapus",
              showConfirmButton: false,
              timer: 2000
            }).then(function(){
              table.ajax.reload( null, false );
            });
          }else{
            Swal.fire({
              position: "top-end",
              type: "error",
              title: "Data Tidak dihapus",
              showConfirmButton: false,
              timer: 2000
            }).then(function(){
              table.ajax.reload( null, false );
            });
        }
    }).fail(function(){
        Swal.fire({
            position: "top-end",
            type: "warning",
            title: "Url tidak ditemukan",
            showConfirmButton: false,
            timer: 2000
        })
    });
}

  function toRp(a,b,c,d,e){e=function(f){return f.split("").reverse().join("")};b=e(parseInt(a,10).toString());for(c=0,d="";c<b.length;c++){d+=b[c];if((c+1)%3===0&&c!==(b.length-1)){d+=",";}}return"\t"+e(d)+""}
  
  // Wrap IIFE around your code
  (function($, viewport){
      $(document).ready(function() {
  
          // Executes only in XS breakpoint
          if(viewport.is("xs")) {
              // ...
          }
  
          // Executes in SM, MD and LG breakpoints
          if(viewport.is(">=sm")) {
              // ...
              /*let column = table.column(6);
              column.visible(!column.visible());*/
          }
  
          // Executes in XS and SM breakpoints
          if(viewport.is("<md")) {
              // ...
              /*let column = table.column(0);
              column.visible(!column.visible());*/
          }
  
          // Execute code each time window size changes
          $(window).resize(
              viewport.changed(function() {
                  if(viewport.is("xs")) {
                      // ...
                  }
              })
          );
      });
  })(jQuery, ResponsiveBootstrapToolkit);
  
        ';
        $path = FCPATH."public/admin/assets/".$controller.".js";
        createFile($string, $path);
    }
}

?>