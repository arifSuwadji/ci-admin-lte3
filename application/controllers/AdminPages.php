<?php

class AdminPages extends CI_Controller {
    public function __construct(){
        parent::__construct();

        is_login();

        $this->load->model('admin/ModelPengguna');
        $this->load->model('admin/ModelHalamanMenu');
    }

    public function view($page = 'dashboard'){
        if(!file_exists(APPPATH.'views/pages/admin/'.$page.'.php')){
            show_404();
        }

        $dataAdmin = data_admin($this->ModelPengguna);
        if($dataAdmin){
            $row = $dataAdmin->row_array();
            $data = array();
            $data['title'] = ucfirst($page);
            $data['filejs'] = '';
            $current_url = $this->uri->segment(1);
            if($this->uri->segment(2)){
                $current_url .= '/'.$this->uri->segment(2);
            }
            if(!$current_url){
                $current_url ='admin';
            }
            $data['current_url'] = $current_url;
            $data['fixed'] = 'fixed';
            if($row){
                $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
                $data['nama_pengguna'] = $row['nama_pengguna'];
                $data['nama_grup'] = $dataGrup['nama_grup'];
                $data['pengguna_grup'] = $row['pengguna_grup'];
                $data['errmsg'] = $_GET ? $_GET['errmsg'] : '';
                $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
                $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
                $data['privilegeButton'] = '';
            }
            template_admin($page, $data);
        }
    }
}
?>