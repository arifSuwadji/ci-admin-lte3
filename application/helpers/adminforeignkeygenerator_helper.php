<?php
/**
 * controller function
 */
function admin_foreignkey_controller($controller, $table, $table_foreignkey_one, $table_foreignkey_two, $buttonTambah, $buttonTambahAksi, $buttonEdit, $buttonEditAksi, $buttonHapus){
        $ci =& get_instance();
        
        $allColumns = AllField($table);
        $dataFilter = array();
        foreach($allColumns as $fieldName){
            array_push($dataFilter, $fieldName['column_name']);
        }

        //write router
        $routePath = APPPATH."config/routes.php";
        $data ="\$route['admin/".$controller."'] = 'admin/".$controller."';\r\n";
        $judul_menu = str_replace('_',' ', $table);
        $judul_menu = ucwords($judul_menu);
        $sub_judul = 'Data '.$judul_menu;
        $url_menu = 'admin/'.$controller;
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'ya';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $ci->db->get_where('halaman_menu', $where)->row();
        if(!$findData){
            $ci->db->insert('halaman_menu', $where);
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
        $findData = $ci->db->get_where('halaman_menu', $where)->row();
        if($findData){
            $buttonTambah = $findData->menu_id;
        }else{
            $ci->db->insert('halaman_menu', $where);
            $buttonTambah = $ci->db->insert_id();
        }

        $data .="\$route['admin/tambah".$controller."Baru'] = 'admin/".$controller."/tambahBaru';\r\n";
        //insert tambah aksi
        $sub_judul = 'Tambah '.$judul_menu.' (Aksi)';
        $url_menu = 'admin/tambah'.$controller.'Baru';
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'tidak';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $ci->db->get_where('halaman_menu', $where)->row();
        if($findData){
            $buttonTambahAksi = $findData->menu_id;
        }else{
            $ci->db->insert('halaman_menu', $where);
            $buttonTambahAksi = $ci->db->insert_id();
        }

        $data .="\$route['admin/edit".$controller."/"."(:num)'] = 'admin/".$controller."/edit';\r\n";
        //insert edit
        $sub_judul = 'Edit '.$judul_menu;
        $url_menu = 'admin/edit'.$controller;
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'tidak';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $ci->db->get_where('halaman_menu', $where)->row();
        if($findData){
            $buttonEdit = $findData->menu_id;
        }else{
            $ci->db->insert('halaman_menu', $where);
            $buttonEdit = $ci->db->insert_id();
        }

        $data .="\$route['admin/update".$controller."'] = 'admin/".$controller."/update';\r\n";
        //insert update
        $sub_judul = 'Edit '.$judul_menu.' (Aksi)';
        $url_menu = 'admin/update'.$controller;
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'tidak';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $ci->db->get_where('halaman_menu', $where)->row();
        if($findData){
            $buttonEditAksi = $findData->menu_id;
        }else{
            $ci->db->insert('halaman_menu', $where);
            $buttonEditAksi = $ci->db->insert_id();
        }

        $data .="\$route['admin/hapus".$controller."'] = 'admin/".$controller."/hapus';\r\n";
        //insert hapus
        $sub_judul = 'Hapus '.$judul_menu;
        $url_menu = 'admin/hapus'.$controller;
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'tidak';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $ci->db->get_where('halaman_menu', $where)->row();
        if($findData){
            $buttonHapus = $findData->menu_id;
        }else{
            $ci->db->insert('halaman_menu', $where);
            $buttonHapus = $ci->db->insert_id();
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
    public function index($page = "'.$table.'/data"){
        if(!file_exists(APPPATH."views/pages/admin/$page.php")){
            show_404();
        }
    ';

        $tableName = str_replace('_',' ', $table);
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
        ';
        if($table_foreignkey_one){
        $string .='
                $data["data_'.$table_foreignkey_one.'"] = $this->Model'.$controller.'->data_'.$table_foreignkey_one.'();
        ';
        }

        if($table_foreignkey_two){
        $string .='
                $data["data_'.$table_foreignkey_two.'"] = $this->Model'.$controller.'->data_'.$table_foreignkey_two.'();
        ';
        }

        $string .='
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
        $idHalamanEdit = '.$buttonEdit.';
        $idHalamanHapus = '.$buttonHapus.';
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

            if($table_foreignkey_one){
        $string .='
                "nama_'.$table_foreignkey_one.'" => $list->nama_'.$table_foreignkey_one.',
        ';
            }
            if($table_foreignkey_two){
        $string .='
                "nama_'.$table_foreignkey_two.'" => $list->nama_'.$table_foreignkey_two.',
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
    public function tambah($page = "'.$table.'/tambah"){
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
        ';
        if($table_foreignkey_one){
        $string .='
            $data["data_'.$table_foreignkey_one.'"] = $this->Model'.$controller.'->data_'.$table_foreignkey_one.'();
        ';
        }

        if($table_foreignkey_two){
        $string .='
            $data["data_'.$table_foreignkey_two.'"] = $this->Model'.$controller.'->data_'.$table_foreignkey_two.'();
        ';
        }

        $string .='
        }
        $dataGrup = $this->ModelPengguna->dataGrup();
        $data["data_grup"] = $dataGrup;

        template_admin($page, $data);
    }
        ';
        // action tambah
        $string .='
    public function tambahBaru($page = "'.$table.'/tambah"){
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
        ';
        if($table_foreignkey_one){
        $string .='
            $data["data_'.$table_foreignkey_one.'"] = $this->Model'.$controller.'->data_'.$table_foreignkey_one.'();
        ';
        }

        if($table_foreignkey_two){
        $string .='
            $data["data_'.$table_foreignkey_two.'"] = $this->Model'.$controller.'->data_'.$table_foreignkey_two.'();
        ';
        }

        $string .='
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
            $this->db->insert("'.$table.'", $insert);
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
    public function edit($page = "'.$table.'/edit"){
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
        ';
        if($table_foreignkey_one){
        $string .='
                $data["data_'.$table_foreignkey_one.'"] = $this->Model'.$controller.'->data_'.$table_foreignkey_one.'();
        ';
        }

        if($table_foreignkey_two){
        $string .='
                $data["data_'.$table_foreignkey_two.'"] = $this->Model'.$controller.'->data_'.$table_foreignkey_two.'();
        ';
        }

        $string .='
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
    public function update($page = "'.$table.'/edit"){
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
        ';
        if($table_foreignkey_one){
        $string .='
            $data["data_'.$table_foreignkey_one.'"] = $this->Model'.$controller.'->data_'.$table_foreignkey_one.'();
        ';
        }

        if($table_foreignkey_two){
        $string .='
            $data["data_'.$table_foreignkey_two.'"] = $this->Model'.$controller.'->data_'.$table_foreignkey_two.'();
        ';
        }

        $string .='
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
            $this->db->update("'.$table.'", $update);
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
        return array('buttonTambah' => $buttonTambah, 'buttonTambahAksi' => $buttonTambahAksi, 'buttonEdit' => $buttonEdit, 'buttonEditAksi' => $buttonEditAksi, 'buttonHapus' => $buttonHapus);
}

/**
 * model generator
 */
function model_foreignkey_generator($controller, $table, $table_foreignkey_one, $table_foreignkey_two){
    $ci =& get_instance();
    
    $allColumns = AllField($table);
    $dataFilter = array();
    foreach($allColumns as $fieldName){
        array_push($dataFilter, $fieldName['column_name']);
    }

    $allColumns_foreignkey_one = AllField($table_foreignkey_one);
    $dataFilter_foreignkey_one = array();
    foreach($allColumns_foreignkey_one as $fieldName){
        array_push($dataFilter_foreignkey_one, $fieldName['column_name']);
    }

    $allColumns_foreignkey_two = AllField($table_foreignkey_two);
    $dataFilter_foreignkey_two = array();
    foreach($allColumns_foreignkey_two as $fieldName){
        array_push($dataFilter_foreignkey_two, $fieldName['column_name']);
    }

    $string ='<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Model'.$controller.' extends CI_model{
    private $table = "'.$table.'";
    ';

    if($table_foreignkey_one){
    $string .='
    private $table_'.$table_foreignkey_one.' = "'.$table_foreignkey_one.'";
    ';
    }

    if($table_foreignkey_two){
    $string .='
    private $table_'.$table_foreignkey_two.' = "'.$table_foreignkey_two.'";
    ';
    }

    $string .='
    public function '.$dataFilter[0].'($'.$dataFilter[0].'){
        return $this->db->get_where($this->table, array("'.$dataFilter[0].'" => $'.$dataFilter[0].'));
    }

    function hapusData($'.$dataFilter[0].'){
        return $this->db->delete($this->table, array("'.$dataFilter[0].'" => $'.$dataFilter[0].'));
    }
    
    ';

    if($table_foreignkey_one){
    $string .='
    public function data_'.$table_foreignkey_one.'(){
        return $this->db->get($this->table_'.$table_foreignkey_one.');
    }
    ';
    }

    if($table_foreignkey_two){
    $string .='
    public function data_'.$table_foreignkey_two.'(){
        return $this->db->get($this->table_'.$table_foreignkey_two.');
    }
    ';
    }

    $string .='
    function count'.$controller.'($value){
        if($value){
            $arrVal = explode(\'_\', $value);
            $arrSearch = array();
    ';
    $i = 0;
    foreach($dataFilter as $fieldName){
    $string .='
            if($arrVal['.$i.']){
                $arrSearch[\''.$fieldName.'\'] = \'%\'.$arrVal['.$i.'].\'%\';
            }
    ';
        $i++;
    }
    $string .='
            $this->db->where($arrSearch);
        }
    ';
    if($table_foreignkey_one){
    $string .='
        $this->db->join($this->table_'.$table_foreignkey_one.', "'.$table.'.'.$table_foreignkey_one.' = '.$table_foreignkey_one.'.'.$dataFilter_foreignkey_one[0].'");
    ';
    }
    if($table_foreignkey_two){
    $string .='
        $this->db->join($this->table_'.$table_foreignkey_two.', "'.$table.'.'.$table_foreignkey_two.' = '.$table_foreignkey_two.'.'.$dataFilter_foreignkey_two[0].'");
    ';
    }
    $string .='
        $this->db->from($this->table);
        return  $this->db->count_all_results();
    }

    function list'.$controller.'($value, $start, $length, $column, $sort){
        if($value){
            $arrVal = explode(\'_\', $value);
            $arrSearch = array();
    ';
    $i = 0;
    foreach($dataFilter as $fieldName){
    $string .='
            if($arrVal['.$i.']){
                $arrSearch[\''.$fieldName.'\'] = \'%\'.$arrVal['.$i.'].\'%\';
            }
    ';
        $i++;
    }
    $string .='
            $this->db->where($arrSearch);
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
    ';
    if($table_foreignkey_one){
    $string .='
            $this->db->join($this->table_'.$table_foreignkey_one.', "'.$table.'.'.$table_foreignkey_one.' = '.$table_foreignkey_one.'.'.$dataFilter_foreignkey_one[0].'");
    ';
    }
    if($table_foreignkey_two){
    $string .='
            $this->db->join($this->table_'.$table_foreignkey_two.', "'.$table.'.'.$table_foreignkey_two.' = '.$table_foreignkey_two.'.'.$dataFilter_foreignkey_two[0].'");
    ';
    }
    $string .='
            $this->db->from($this->table);
            return $this->db->limit($length, $start)->get();
        }else{
            $this->db->select("*");
    ';
    if($table_foreignkey_one){
    $string .='
            $this->db->join($this->table_'.$table_foreignkey_one.', "'.$table.'.'.$table_foreignkey_one.' = '.$table_foreignkey_one.'.'.$dataFilter_foreignkey_one[0].'");
    ';
    }
    if($table_foreignkey_two){
    $string .='
            $this->db->join($this->table_'.$table_foreignkey_two.', "'.$table.'.'.$table_foreignkey_two.' = '.$table_foreignkey_two.'.'.$dataFilter_foreignkey_two[0].'");
    ';
    }
    $string .='
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

function template_foreignkey_index($controller, $table, $table_foreignkey_one, $table_foreignkey_two, $buttonTambah, $buttonTambahAksi, $buttonEdit, $buttonEditAksi, $buttonHapus){
    $ci =& get_instance();
    
    $allColumns = AllField($table);
    $dataFilter = array();
    foreach($allColumns as $fieldName){
        array_push($dataFilter, $fieldName['column_name']);
    }
    
    $allColumns_foreignkey_one = AllField($table_foreignkey_one);
    $dataFilter_foreignkey_one = array();
    foreach($allColumns_foreignkey_one as $fieldName){
        array_push($dataFilter_foreignkey_one, $fieldName['column_name']);
    }

    $allColumns_foreignkey_two = AllField($table_foreignkey_two);
    $dataFilter_foreignkey_two = array();
    foreach($allColumns_foreignkey_two as $fieldName){
        array_push($dataFilter_foreignkey_two, $fieldName['column_name']);
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
      <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">Pencarian </h3>

            <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-remove"></i></button>
            </div>
        </div>
        <div class="card-body">
        <?php
            $attributes = array("class" => "form-horizontal", "method" => "GET");
            echo form_open("", $attributes);
        ?>
    ';
    foreach($dataFilter as $fieldName){
        $langField = str_replace('_',' ', $fieldName);
        $langField = ucwords($langField);
        if($fieldName == $table_foreignkey_one){
    $string .='
            <div class="form-group">
                <label for="'.$fieldName.'">'.$langField.'</label>
                <select id="'.$fieldName.'" name="'.$fieldName.'" class="form-control select2" data-placeholder="'.$langField.'">
                <option></option>
            <?php foreach($data_'.$table_foreignkey_one.'->result() as $'.$table_foreignkey_one.'){ ?>
                <option value="<?php echo $'.$table_foreignkey_one.'->'.$dataFilter_foreignkey_one[0].' ?>" ><?php echo $'.$table_foreignkey_one.'->'.$dataFilter_foreignkey_one[1].' ?></option>
            <?php } ?>
                </select>
            </div>
    ';
        }else if($fieldName == $table_foreignkey_two){
    $string .='
            <div class="form-group">
                <label for="'.$fieldName.'">'.$langField.'</label>
                <select id="'.$fieldName.'" name="'.$fieldName.'" class="form-control select2" data-placeholder="'.$langField.'">
                <option></option>
            <?php foreach($data_'.$table_foreignkey_two.'->result() as $'.$table_foreignkey_two.'){ ?>
                <option value="<?php echo $'.$table_foreignkey_two.'->'.$dataFilter_foreignkey_two[0].' ?>" ><?php echo $'.$table_foreignkey_two.'->'.$dataFilter_foreignkey_two[1].' ?></option>
            <?php } ?>
                </select>
            </div>
    ';
        }else{
    $string .='
            <div class="form-group">
                <label for="'.$fieldName.'">'.$langField.'</label>
                <input type="text" id="'.$fieldName.'" class="form-control" placeholder="'.$langField.'" name="'.$fieldName.'" value="">
            </div>
    ';
        }
    }
    $string .='
        <?php echo form_close() ?>
        </div>
        <div class="card-footer">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary" id="cari">Cari</button>
            </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-header">
              <h3 class="card-title"><?php echo $menuHalaman->sub_judul_menu ?></h3>
              <?php if(isset($priviliges->{'.$buttonTambah.'})){ ?><a href="<?php echo $tambahData ?>"><button class="btn btn-primary btn-sm float-right text-bold">Tambah '.ucwords(str_replace('_',' ', $table)).'</button></a><?php }else{?><button class="btn btn-default btn-sm float-right text-bold" disabled>Tambah '.ucwords(str_replace('_',' ', $table)).'</button><?php } ?>
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
    $path = APPPATH."views/pages/admin/".$table."/data.php";
    if(is_file($path)){
    }else{
        mkdir(APPPATH."views/pages/admin/".$table);
    }
    createFile($string, $path);
}

function template_foreignkey_tambah($controller, $table, $table_foreignkey_one, $table_foreignkey_two, $buttonTambah, $buttonTambahAksi, $buttonEdit, $buttonEditAksi, $buttonHapus){
    $ci =& get_instance();
    
    $allColumns = AllField($table);
    $dataFilter = array();
    foreach($allColumns as $fieldName){
        array_push($dataFilter, $fieldName['column_name']);
    }

    $allColumns_foreignkey_one = AllField($table_foreignkey_one);
    $dataFilter_foreignkey_one = array();
    foreach($allColumns_foreignkey_one as $fieldName){
        array_push($dataFilter_foreignkey_one, $fieldName['column_name']);
    }

    $allColumns_foreignkey_two = AllField($table_foreignkey_two);
    $dataFilter_foreignkey_two = array();
    foreach($allColumns_foreignkey_two as $fieldName){
        array_push($dataFilter_foreignkey_two, $fieldName['column_name']);
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
        if($fieldName == $table_foreignkey_one){
    $string .='
        <div class="form-group">
            <label for="'.$fieldName.'">'.$langField.'</label>
            <select id="'.$fieldName.'" name="'.$fieldName.'" class="form-control select2" data-placeholder="'.$langField.'">
            <option></option>
        <?php foreach($data_'.$table_foreignkey_one.'->result() as $'.$table_foreignkey_one.'){ ?>
            <option value="<?php echo $'.$table_foreignkey_one.'->'.$dataFilter_foreignkey_one[0].' ?>" <?php echo $'.$table_foreignkey_one.'->'.$dataFilter_foreignkey_one[0].' == $'.$fieldName.' ? "selected" : "" ?>><?php echo $'.$table_foreignkey_one.'->'.$dataFilter_foreignkey_one[1].' ?></option>
        <?php } ?>
            </select>
        </div>
    ';
        }else if($fieldName == $table_foreignkey_two){
    $string .='
        <div class="form-group">
            <label for="'.$fieldName.'">'.$langField.'</label>
            <select id="'.$fieldName.'" name="'.$fieldName.'" class="form-control select2" data-placeholder="'.$langField.'">
            <option></option>
        <?php foreach($data_'.$table_foreignkey_two.'->result() as $'.$table_foreignkey_two.'){ ?>
            <option value="<?php echo $'.$table_foreignkey_two.'->'.$dataFilter_foreignkey_two[0].' ?>" <?php echo $'.$table_foreignkey_two.'->'.$dataFilter_foreignkey_two[0].' == $'.$fieldName.' ? "selected" : "" ?>><?php echo $'.$table_foreignkey_two.'->'.$dataFilter_foreignkey_two[1].' ?></option>
        <?php } ?>
            </select>
        </div>
    ';
        }else{
    $string .='
        <div class="form-group">
            <label for="'.$fieldName.'">'.$langField.'</label>
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
        <?php if(isset($priviliges->{'.$buttonTambahAksi.'})){ ?>                    
        <button type="submit" id="lanjut" class="btn bg-primary pull-right">Tambah</button>
        <?php }else{?><button class="pull-right btn btn-default text-bold" disabled>Tambah</button><?php } ?>
    </div>
    <?php echo form_close() ?>
    </div>
</div>
</section>

    ';
    $path = APPPATH."views/pages/admin/".$table."/tambah.php";
    createFile($string, $path);
}

function template_foreignkey_edit($controller, $table, $table_foreignkey_one, $table_foreignkey_two, $buttonTambah, $buttonTambahAksi, $buttonEdit, $buttonEditAksi, $buttonHapus){
    $ci =& get_instance();
    
    $allColumns = AllField($table);
    $dataFilter = array();
    foreach($allColumns as $fieldName){
        array_push($dataFilter, $fieldName['column_name']);
    }

    $allColumns_foreignkey_one = AllField($table_foreignkey_one);
    $dataFilter_foreignkey_one = array();
    foreach($allColumns_foreignkey_one as $fieldName){
        array_push($dataFilter_foreignkey_one, $fieldName['column_name']);
    }

    $allColumns_foreignkey_two = AllField($table_foreignkey_two);
    $dataFilter_foreignkey_two = array();
    foreach($allColumns_foreignkey_two as $fieldName){
        array_push($dataFilter_foreignkey_two, $fieldName['column_name']);
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
            if($fieldName == $table_foreignkey_one){
    $string .='
        <div class="form-group">
            <label for="'.$fieldName.'">'.$langField.'</label>
            <select id="'.$fieldName.'" name="'.$fieldName.'" class="form-control select2" data-placeholder="'.$langField.'">
            <option></option>
        <?php foreach($data_'.$table_foreignkey_one.'->result() as $opt_'.$table_foreignkey_one.'){ ?>
            <option value="<?php echo $opt_'.$table_foreignkey_one.'->'.$dataFilter_foreignkey_one[0].' ?>" <?php echo $opt_'.$table_foreignkey_one.'->'.$dataFilter_foreignkey_one[0].' == $'.$fieldName.' ? "selected" : "" ?>><?php echo $opt_'.$table_foreignkey_one.'->'.$dataFilter_foreignkey_one[1].' ?></option>
        <?php } ?>
            </select>
        </div>
    ';
            }else if($fieldName == $table_foreignkey_two){
    $string .='
        <div class="form-group">
            <label for="'.$fieldName.'">'.$langField.'</label>
            <select id="'.$fieldName.'" name="'.$fieldName.'" class="form-control select2" data-placeholder="'.$langField.'">
            <option></option>
        <?php foreach($data_'.$table_foreignkey_two.'->result() as $opt_'.$table_foreignkey_two.'){ ?>
            <option value="<?php echo $opt_'.$table_foreignkey_two.'->'.$dataFilter_foreignkey_two[0].' ?>" <?php echo $opt_'.$table_foreignkey_two.'->'.$dataFilter_foreignkey_two[0].' == $'.$fieldName.' ? "selected" : "" ?>><?php echo $opt_'.$table_foreignkey_two.'->'.$dataFilter_foreignkey_two[1].' ?></option>
        <?php } ?>
            </select>
        </div>
    ';
            }else{
    $string .='
        <div class="form-group">
            <label for="'.$fieldName.'">'.$langField.'</label>
            <input type="text" class="form-control" placeholder="'.$langField.'" name="'.$fieldName.'" value="<?php echo $'.$fieldName.' ?>">
        </div>
    ';
            }
        }
    }
    $string .='
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <input type="hidden" name="baseURL" id="baseURL" value="<?php echo base_url() ?>" />
        <input type="hidden" name="'.$dataFilter[0].'_edit" value="<?php echo $'.$dataFilter[0].'_edit ?>">
        <?php if(isset($priviliges->{'.$buttonEditAksi.'})){ ?>                    
        <button type="submit" id="lanjut" class="btn bg-primary pull-right">Perbarui</button>
        <?php }else{?><button class="pull-right btn btn-default text-bold" disabled>Perbarui</button><?php } ?>
    </div>
    <?php echo form_close() ?>
    </div>
</div>
</section>

    ';
    $path = APPPATH."views/pages/admin/".$table."/edit.php";
    createFile($string, $path);
}

function js_foreignkey_generator($controller, $table, $buttonTambah, $buttonTambahAksi, $buttonEdit, $buttonEditAksi, $buttonHapus){
    $ci =& get_instance();
    
    $allColumns = AllField($table);
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
"dom" : "<\'row\'<\'col-sm-6\'l>>" +
"<\'row\'<\'col-sm-12\'tr>>" +
"<\'row\'<\'col-sm-5\'i><\'col-sm-7\'p>>",
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
      let colorButtonEdit = "btn-warning";
      let colorButtonHapus = "btn-danger";
      if(!full['.$buttonEdit.']){
        aksesEdit = "disabled";
        editData = "";
        colorButtonEdit = "btn-default";
      }
      if(!full['.$buttonHapus.']){
        aksesHapus = "disabled";
        hapusData = "";
        colorButtonHapus = "btn-default";
      }
      return `<div class="btn-group dropleft">
                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="fa fa-ellipsis-v"></span></button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="javascript:void(0);" onClick="${editData}">
                        <button class="btn ${colorButtonEdit} btn-block btn-sm text-bold ${aksesEdit}">Edit</button>
                    </a>
                    <a class="dropdown-item" href="javascript:void(0);" onClick="${hapusData}">
                        <button class="btn ${colorButtonHapus} btn-block btn-sm text-bold ${aksesHapus}">Hapus</button>
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

$("#cari").on("click", function(event){
    event.preventDefault();
    let searchDataFilter = "";
    ';
    $i =0;
    foreach($dataFilter as $fieldName){
    $string .='
    let '.$fieldName.' = $("#'.$fieldName.'").val();
    ';
        if($i < count($dataFilter) - 1){
    $string .='
    searchDataFilter += `${'.$fieldName.'}_`;
    ';
        }else{
    $string .='
    searchDataFilter += `${'.$fieldName.'}`;
    ';
        }
        $i++;
    }
    foreach($dataFilter as $fieldName){
    $string .='
    ';
    }
    $string .='
    table.search(`${searchDataFilter}`).draw();
});
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

?>