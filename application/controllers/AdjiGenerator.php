<?php

class AdjiGenerator extends CI_Controller {
    public function __construct(){
        parent::__construct();
    }

    public function create($controller="", $database=""){
        $allColumns = AllField($database);
        $dataFilter = array();
        foreach($allColumns as $fieldName){
            array_push($dataFilter, $fieldName['column_name']);
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
        $idHalamanEdit = 10;
        $row = $dataAdmin->row_array();
        $idHalamanHapus = 12;
        $idHalamanPassword = 19;
        if($row){
            $dataHalaman = $this->ModelHalamanMenu->byPetaHalaman($row["pengguna_grup"], $idHalamanHapus);
            $privilegesDelete = $dataHalaman->row_array();
            $dataHalamanEdit = $this->ModelHalamanMenu->byPetaHalaman($row["pengguna_grup"], $idHalamanEdit);
            $privilegesDetail = $dataHalamanEdit->row_array();
            $dataHalamanPassword = $this->ModelHalamanMenu->byPetaHalaman($row["pengguna_grup"], $idHalamanPassword);
            $privilegesPassword = $dataHalamanPassword->row_array();
            foreach ($list'.$controller.'->result() as $list) {
                $dataRow = [];
        ';
            foreach($dataFilter as $fieldName){
        $string .='
                $dataRow[] = array("'.$fieldName.'" => $list->'.$fieldName.');
        ';
                }
        $string .='
                $dataRow[] = array($idHalamanHapus => $privilegesDelete["pengguna_grup"], $idHalamanEdit => $privilegesDetail["pengguna_grup"], $idHalamanPassword => $privilegesPassword["pengguna_grup"]);
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
        //index and datajson
        //write router
        $routePath = APPPATH."config/routes.php";
        $data ="\$route['admin/".$controller."'] = 'admin/".$controller."';\r\n";
        if(!write_file($routePath, $data, 'a')){
            echo 'Unable to write the file';
        }else{
            echo 'File written!';
        }
        //load template index
        $this->template_index($controller, $database);

        $string.="
}
?>
        ";
        $path = APPPATH."controllers/admin/".$controller.".php";
        createFile($string, $path);

        //load models
        $this->model_generator($controller, $database);
        echo $controller."\r\n";
        echo $database."\r\n";
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
                $this->db->or_like('.$dataFilter[1].', $value);
                $this->db->or_like('.$dataFilter[2].', $value);
            }
            $this->db->from($this->table);
            return  $this->db->count_all_results();
        }

        function list'.$controller.'($value, $start, $length, $column, $sort){
            if($value){
                $this->db->or_like('.$dataFilter[1].', $value);
                $this->db->or_like('.$dataFilter[2].', $value);
            }
            if($column == 0){
                $this->db->order_by('.$dataFilter[0].', $sort);
            }else if($column == 1){
                $this->db->order_by('.$dataFilter[1].', $sort);
            }else if($column == 2){
                $this->db->order_by('.$dataFilter[2].', $sort);
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
                  <?php if(isset($priviliges->{8})){ ?><a href="<?php echo $tambahData ?>"><button class="btn btn-primary btn-sm float-right text-bold">Tambah Pengguna</button></a><?php }else{?><button class="btn btn-default btn-sm float-right text-bold" disabled>Tambah Pengguna</button><?php } ?>
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
}

?>