<?php
/**
 * controller function
 */
function admin_controller($controller, $table, $buttonTambah, $buttonTambahAksi, $buttonEdit, $buttonEditAksi, $buttonHapus, $buttonPdf, $buttonExcel){
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

        $data .="\$route['admin/pdf".$controller."'] = 'admin/".$controller."/pdf';\r\n";
        //insert pdf
        $sub_judul = 'PDF - '.$judul_menu;
        $url_menu = 'admin/pdf'.$controller;
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'tidak';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $ci->db->get_where('halaman_menu', $where)->row();
        if($findData){
            $buttonPdf = $findData->menu_id;
        }else{
            $ci->db->insert('halaman_menu', $where);
            $buttonPdf = $ci->db->insert_id();
        }

        $data .="\$route['admin/excel".$controller."'] = 'admin/".$controller."/excel';\r\n";
        //insert excel
        $sub_judul = 'Excel - '.$judul_menu;
        $url_menu = 'admin/excel'.$controller;
        $icon_menu = 'nav-icon fas fa-bars';
        $aktif_menu = 'tidak';
        $where = array('judul_menu' => $judul_menu, 'sub_judul_menu' => $sub_judul, 'url_menu' => $url_menu, 'icon_menu' => $icon_menu, 'aktif_menu' => $aktif_menu);
        //insert or find
        $findData = $ci->db->get_where('halaman_menu', $where)->row();
        if($findData){
            $buttonExcel = $findData->menu_id;
        }else{
            $ci->db->insert('halaman_menu', $where);
            $buttonExcel = $ci->db->insert_id();
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
            $data["exportpdf"] = base_url(). "admin/pdf'.$controller.'";
            $data["exportexcel"] = base_url(). "admin/excel'.$controller.'";
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
        ';

        $string .='
    public function pdf($page = "'.$table.'/pdf"){
        $current_url = $this->uri->segment(1);
        if($this->uri->segment(2)){
            $current_url .= "/".$this->uri->segment(2);
        }
        $data["menuHalaman"] = $this->ModelHalamanMenu->byUrl($current_url)->row();
        $title = explode("(",$data["menuHalaman"]->sub_judul_menu);
        $data["dataPdf"]= $this->Model'.$controller.'->getAll();
        $showTitle = $title[0];
    
        $html = $this->load->view("pages/admin/".$page, $data, true);
        $this->pdfgenerator->generate($html, $showTitle);
    }
        ';

        $string .='
    public function excel(){
        $current_url = $this->uri->segment(1);
        if($this->uri->segment(2)){
            $current_url .= "/".$this->uri->segment(2);
        }
        $data["menuHalaman"] = $this->ModelHalamanMenu->byUrl($current_url)->row();
        $title = explode("(",$data["menuHalaman"]->sub_judul_menu);

        $header = array();
        ';
        $i =0;
        foreach($dataFilter as $fieldName){
            $i++;
            if($i > 1){
        $string .='
        array_push($header, "'.$fieldName.'");
        ';
            }
        }
        
        $string .='
        $content = array();
        $allData = $this->Model'.$controller.'->getAll();
        foreach($allData->result()  as $data){
            array_push($content, [
        ';
        $i =0;
        foreach($dataFilter as $fieldName){
            $i++;
            if($i > 1){
        $string .='
            "'.$fieldName.'" => $data->'.$fieldName.',
        ';
            }
        }
        
        $string .='
            ]);
        }
        $filename=$title[0]." ".date("d-m-Y")." - payroll.xlsx";
        $this->excelgenerator->generate($header, $content, $filename, "'.$table.'");
    }
        
}
?>
        ';
        
        $path = APPPATH."controllers/admin/".$controller.".php";
        createFile($string, $path);
        return array('buttonTambah' => $buttonTambah, 'buttonTambahAksi' => $buttonTambahAksi, 'buttonEdit' => $buttonEdit, 'buttonEditAksi' => $buttonEditAksi, 'buttonHapus' => $buttonHapus, 'buttonPdf' => $buttonPdf, 'buttonExcel' => $buttonExcel);
}

/**
 * model generator
 */
function model_generator($controller, $table){
    $ci =& get_instance();
    
    $allColumns = AllField($table);
    $dataFilter = array();
    foreach($allColumns as $fieldName){
        array_push($dataFilter, $fieldName['column_name']);
    }
    $string ='<?php
defined("BASEPATH") OR exit("No direct script access allowed");

class Model'.$controller.' extends CI_model{
    private $table = "'.$table.'";

    public function '.$dataFilter[0].'($'.$dataFilter[0].'){
        return $this->db->get_where($this->table, array("'.$dataFilter[0].'" => $'.$dataFilter[0].'));
    }

    function hapusData($'.$dataFilter[0].'){
        return $this->db->delete($this->table, array("'.$dataFilter[0].'" => $'.$dataFilter[0].'));
    }

    public function getAll(){
        $this->db->select("*");
        $this->db->from($this->table);
        return $this->db->get();
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

function template_index($controller, $table, $buttonTambah, $buttonTambahAksi, $buttonEdit, $buttonEditAksi, $buttonHapus, $buttonPdf, $buttonExcel){
    $ci =& get_instance();
    
    $allColumns = AllField($table);
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
              <div class="float-right">
              <?php if(isset($priviliges->{'.$buttonTambah.'})){ ?><a href="<?php echo $tambahData ?>"><button class="btn btn-primary btn-sm text-bold">Tambah '.ucwords(str_replace('_',' ', $table)).'</button></a><?php }else{?><button class="btn btn-default btn-sm text-bold" disabled>Tambah '.ucwords(str_replace('_',' ', $table)).'</button><?php } ?>
              <?php if(isset($priviliges->{'.$buttonPdf.'})){ ?><a href="<?php echo $exportpdf ?>" target="_blank"><button class="btn btn-info btn-sm text-bold" ><i class="fas fa-file-pdf"></i> PDF</button><a><?php }else{?><button class="btn btn-default btn-sm text-bold" disabled><i class="fas fa-file-pdf"></i> PDF</button><?php } ?>
              <?php if(isset($priviliges->{'.$buttonExcel.'})){ ?><a href="<?php echo $exportexcel ?>"><button class="btn btn-info btn-sm text-bold" ><i class="fas fa-file-excel"></i> Excel</button><a><?php }else{?><button class="btn btn-default btn-sm text-bold" disabled><i class="fas fa-file-excel"></i> Excel</button><?php } ?>
              </div>
              <input type="hidden" id="dataJson" value="<?php echo $dataJson ?>"/>
              <input type="hidden" id="editData" value="<?php echo $editData ?>"/>
              <input type="hidden" id="hapusJson" value="<?php echo $hapusData ?>"/>
              <input type="hidden" id="adminGrup" value="<?php echo $pengguna_grup ?>"/>
              <input type="hidden" id="sessionIdAdmin" value="<?php echo $this->session->userdata["adminPayroll"]["pengguna_id"]?>">
            </div>
            <br>
            <!--card header-->
            <div class="card-body table-responsive p-0">
              <table id="tableData" class="table table-striped table-bordered table-hover">
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

function template_tambah($controller, $table, $buttonTambah, $buttonTambahAksi, $buttonEdit, $buttonEditAksi, $buttonHapus){
    $ci =& get_instance();
    
    $allColumns = AllField($table);
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
            <label for="'.$fieldName.'">'.$langField.'</label>
            <input type="text" class="form-control" placeholder="'.$langField.'" name="'.$fieldName.'" value="<?php echo $'.$fieldName.' ?>">
        </div>
    ';
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

function template_edit($controller, $table, $buttonTambah, $buttonTambahAksi, $buttonEdit, $buttonEditAksi, $buttonHapus){
    $ci =& get_instance();
    
    $allColumns = AllField($table);
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

function template_pdf($controller, $table){
    $ci =& get_instance();
    
    $allColumns = AllField($table);
    $dataFilter = array();
    foreach($allColumns as $fieldName){
        array_push($dataFilter, $fieldName['column_name']);
    }

    $string ='
    <!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php $title= array("Dashboard"); if($menuHalaman){$title = explode("(",$menuHalaman->sub_judul_menu); }?>
  <title>Payroll Carstore | <?php echo $title[0] ?></title>
  <?php echo asset_icon("AdminLTELogo.png")?>
  <?php echo asset_plugin_css("tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css") ?>
  <?php echo asset_css("adminlte.min.css") ?>
  <style>
  table, th, td {
    border: 1px solid black;
    padding: 4px;word-wrap:break-word;
  }
  </style>
</head>
<body style="font-size:12px;">
	<div >
        <div class="float-right">
            <br><?php if($menuHalaman){$title = explode("(",$menuHalaman->sub_judul_menu); } echo $title[0] ?>,  <?php echo dateText(date("d-m-Y")) ?>
        </div>
        <br>
        <br>
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
    ';
    $i = 0;
    foreach($dataFilter as $fieldName){
        $i++;
        $langField = str_replace('_',' ', $fieldName);
        $langField = ucwords($langField);
        if($i > 1){
    $string .='
                    <th>'.$langField.'</th>
    ';
        }
    }
    $string .='
                </tr>
            </thead>
            <tbody>
                <?php $no=1; ?>
                <?php foreach($dataPdf->result() as $data): ?>
                <tr>
                    <td><?php echo $no; ?></td>
    ';
    $i = 0;
    foreach($dataFilter as $fieldName){
        $i++;
        if($i > 1){
    $string .='
                    <td style=""><?php echo $data->'.$fieldName.'; ?></td>
    ';
        }
    }
    $string .='
                </tr>
                <?php $no++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
	 </div>
</body>
</html>

    ';
    $path = APPPATH."views/pages/admin/".$table."/pdf.php";
    createFile($string, $path);
}

function js_generator($controller, $table, $buttonTambah, $buttonTambahAksi, $buttonEdit, $buttonEditAksi, $buttonHapus){
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
language: {
    "searchPlaceholder": "Cari ",
    "sSearch": "",
    "lengthMenu": "&emsp;Menampilkan _MENU_ per halaman",
    "processing": "<span class=\'fa fa-spinner fa-spin fa-lg\'></span><br>Memproses data...",
    "info": "&emsp;Menampilkan _START_ - _END_ dari _TOTAL_ data",
    "zeroRecords": "Maaf - tidak ada yang ditemukan",
    "infoEmpty": "&emsp;Tidak ada data yang tersedia",
    "infoFiltered": "&emsp;(filter dari _MAX_ total data)",
    "paginate": {
        "first": "Pertama",
        "last": "Terakhir",
        "next": "Selanjutnya",
        "previous": "Sebelumnya"
    },

},
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

?>