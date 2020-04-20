<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
    public function __construct(){
        parent::__construct();

        is_login();

        $this->load->model('admin/ModelPengguna');
        $this->load->model('admin/ModelHalamanMenu');
    }

    public function index($page = 'user/data'){
        if(!file_exists(APPPATH.'views/pages/admin/user/data.php')){
            show_404();
        }

        $dataAdmin = data_admin($this->ModelPengguna);
        if($dataAdmin){
            $row = $dataAdmin->row_array();
            $data = array();
            $data['title'] = ucfirst('Data Admin');
            $data['filejs'] = base_url().'public/admin/assets/user.js';
            $data['dataJson'] = base_url().'admin/penggunaJson';
            $data['tambahData'] = base_url().'admin/tambahPengguna';
            $data['editData'] = base_url().'admin/editPengguna';
            $data['hapusData'] = base_url().'admin/hapusPengguna';
            $data['gantiPassword'] = base_url().'admin/gantiPassword';
            $current_url = $this->uri->segment(1);
            if($this->uri->segment(2)){
                $current_url .= '/'.$this->uri->segment(2);
            }
            $data['current_url'] = $current_url;
            $data['fixed'] = 'fixed';
            if($row){
                $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
                $data['nama_pengguna'] = $row['nama_pengguna'];
                $data['nama_grup'] = $dataGrup['nama_grup'];
                $data['pengguna_grup'] = $row['pengguna_grup'];
                $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
                $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
                $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
                $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
                $data['priviliges'] = button_halaman($dataHalaman);
            }
    
            template_admin($page, $data);
        }
    }

    public function dataJson(){
        $draw = (int)$this->input->get('draw');
        $value = $this->input->get('search')['value'];
        $start = (int)$this->input->get('start');
        $length = (int)$this->input->get('length');
        $column = (int)$this->input->get('order')[0]['column'];
        $sort = $this->input->get('order')[0]['dir'];
        $recodsTotal = $this->ModelPengguna->countAdmin($value);
        $listAdmin = $this->ModelPengguna->listAdmin($value, $start, $length, $column, $sort);
        $results = array();
        $dataAdmin = data_admin($this->ModelPengguna);
        $idHalamanEdit = 10;
        $row = $dataAdmin->row_array();
        $idHalamanHapus = 12;
        $idHalamanPassword = 19;
        if($row){
            $dataHalaman = $this->ModelHalamanMenu->byPetaHalaman($row['pengguna_grup'], $idHalamanHapus);
            $privilegesDelete = $dataHalaman->row_array();
            $dataHalamanEdit = $this->ModelHalamanMenu->byPetaHalaman($row['pengguna_grup'], $idHalamanEdit);
            $privilegesDetail = $dataHalamanEdit->row_array();
            $dataHalamanPassword = $this->ModelHalamanMenu->byPetaHalaman($row['pengguna_grup'], $idHalamanPassword);
            $privilegesPassword = $dataHalamanPassword->row_array();
            foreach ($listAdmin->result() as $list) {
                array_push($results, [
                    'pengguna_id' => $list->pengguna_id, 'nama_pengguna' => $list->nama_pengguna, 'username' => $list->username, 'email' => $list->email, 'nama_grup' => $list->nama_grup, $idHalamanHapus => $privilegesDelete['pengguna_grup'], $idHalamanEdit => $privilegesDetail['pengguna_grup'], $idHalamanPassword => $privilegesPassword['pengguna_grup']]);
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
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;
    }

    public function tambah($page = 'user/tambah_user'){
        if(!file_exists(APPPATH.'views/pages/admin/'.$page.'.php')){
            show_404();
        }

        $dataAdmin = data_admin($this->ModelPengguna);
        $row = $dataAdmin->row_array();
        $data = array();
        $data['filejs'] = '';
        $data['nama_tambah_pengguna'] = '';
        $data['nama_tambah_email'] = '';
        $data['select_pengguna_grup'] = '';
        $data['password'] = '';
        $data['konf_password'] = '';
        $current_url = $this->uri->segment(1);
        if($this->uri->segment(2)){
            $current_url .= '/'.$this->uri->segment(2);
        }
        $data['current_url'] = $current_url;
        $data['fixed'] = 'fixed';
        if($row){
            $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
            $data['nama_pengguna'] = $row['nama_pengguna'];
            $data['nama_grup'] = $dataGrup['nama_grup'];
            $data['pengguna_grup'] = $row['pengguna_grup'];
            $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
            $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
            $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
            $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
            $data['priviliges'] = button_halaman($dataHalaman);
        }
        $dataGrup = $this->ModelPengguna->dataGrup();
        $data['data_grup'] = $dataGrup;

        template_admin($page, $data);
    }

    public function tambahBaru($page = 'user/tambah_user'){
        $dataValidation = array('nama_pengguna' => 'belum diisi', 'email_pengguna' => 'belum diisi', 'pengguna_grup' => 'belum dipilih', 'password' => 'belum diisi', 'konf_password' => 'belum diisi');
        is_validation($dataValidation);

        $data = array();
        $data['nama_tambah_pengguna'] = $this->input->post('nama_pengguna');
        $data['nama_tambah_email'] = $this->input->post('email_pengguna');
        $data['select_pengguna_grup'] = $this->input->post('pengguna_grup');
        $data['password'] = $this->input->post('password');
        $data['konf_password'] = $this->input->post('konf_password');
        $data['errmsg'] = '';
        $data['filejs'] = '';
        $dataAdmin = data_admin($this->ModelPengguna);
        $row = $dataAdmin->row_array();
        $current_url = $this->uri->segment(1);
        if($this->uri->segment(2)){
            $current_url .= '/'.$this->uri->segment(2);
        }
        $data['current_url'] = $current_url;
        $data['fixed'] = '';
        if($row){
            $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
            $data['nama_pengguna'] = $row['nama_pengguna'];
            $data['nama_grup'] = $dataGrup['nama_grup'];
            $data['pengguna_grup'] = $row['pengguna_grup'];
            $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
            $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
            $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
            $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
            $data['priviliges'] = button_halaman($dataHalaman);
        }
        $dataGrup = $this->ModelPengguna->dataGrup();
        $data['data_grup'] = $dataGrup;
        if($this->form_validation->run() == FALSE){
            template_admin($page, $data);
        }else{
            if($this->input->post('password') != $this->input->post('konf_password')){
                redirect(base_url().'admin/tambahPengguna?errmsg=password dan konfirmasi password tidak sama');
            }else{
                $insert = array();
                $insert['nama_pengguna'] = $this->input->post('nama_pengguna');
                $insert['username'] = str_replace(' ','',$this->input->post('nama_pengguna'));
                $insert['email'] = $this->input->post('email_pengguna');
                $insert['pengguna_grup'] = $this->input->post('pengguna_grup');
                $insert['password'] = sha1($this->input->post('password'));
                $this->db->insert('pengguna', $insert);
                $errmsg = '';
                $this->db->affected_rows() != 1 ? $errmsg = 'gagal' : $errmsg = 'berhasil';
                if($errmsg == 'gagal'){
                    redirect(base_url().'admin/tambahUser?errmsg='.$errmsg.'&nama_pengguna='.$this->input->post('nama_pengguna').'&pengguna_grup='.$this->input->post('pengguna_grup'));
                }else if($errmsg == 'berhasil'){
                    redirect(base_url().'admin/pengguna');
                }
            }
        }
    }

    public function edit($page = 'user/edit_user'){
        if(!file_exists(APPPATH.'views/pages/admin/'.$page.'.php')){
            show_404();
        }

        $dataAdmin = data_admin($this->ModelPengguna);
        if($dataAdmin){
            $row = $dataAdmin->row_array();
            $data = array();
            $data['filejs'] = '';
            $data['nama_edit_pengguna'] = '';
            $data['select_pengguna_grup'] = '';
            $current_url = $this->uri->segment(1);
            if($this->uri->segment(2)){
                $current_url .= '/'.$this->uri->segment(2);
            }
            $data['current_url'] = $current_url;
            $data['fixed'] = 'fixed';
            if($row){
                $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
                $data['nama_pengguna'] = $row['nama_pengguna'];
                $data['nama_grup'] = $dataGrup['nama_grup'];
                $data['pengguna_grup'] = $row['pengguna_grup'];
                $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
                $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
                $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
                $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
                $data['priviliges'] = button_halaman($dataHalaman);
                $dataEdit = $this->ModelPengguna->idAdmin($this->uri->segment(3));
                $rowEdit = $dataEdit->row_array();
                if($rowEdit){
                    $data['nama_edit_pengguna'] = $rowEdit['nama_pengguna'];
                    $data['nama_edit_email'] = $rowEdit['email'];
                    $data['select_pengguna_grup'] = $rowEdit['pengguna_grup'];
                    $data['pengguna_id_edit'] = $rowEdit['pengguna_id'];
                }
            }
            $dataGrup = $this->ModelPengguna->dataGrup();
            $data['data_grup'] = $dataGrup;
    
            template_admin($page, $data);
        }
    }

    public function update($page = 'user/edit_user'){
        $dataValidation = array('nama_pengguna' => 'belum diisi', 'email_pengguna' => 'belum diisi', 'pengguna_grup' => 'belum dipilih');
        is_validation($dataValidation);
        
        $data = array();
        $data['nama_edit_pengguna'] = $this->input->post('nama_pengguna');
        $data['nama_edit_email'] = $this->input->post('email_pengguna');
        $data['select_pengguna_grup'] = $this->input->post('pengguna_grup');
        $data['errmsg'] = '';
        $data['filejs'] = '';
        $dataAdmin = data_admin($this->ModelPengguna);
        $row = $dataAdmin->row_array();
        $current_url = $this->uri->segment(1);
        if($this->uri->segment(2)){
            $current_url .= '/'.$this->uri->segment(2);
        }
        $data['current_url'] = $current_url;
        $data['fixed'] = '';
        if($row){
            $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
            $data['nama_pengguna'] = $row['nama_pengguna'];
            $data['nama_grup'] = $dataGrup['nama_grup'];
            $data['pengguna_grup'] = $row['pengguna_grup'];
            $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
            $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
            $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
            $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
            $data['priviliges'] = button_halaman($dataHalaman);
            $dataEdit = $this->ModelPengguna->idAdmin($this->input->post('pengguna_id_edit'));
            $rowEdit = $dataEdit->row_array();
            if($rowEdit){
                $data['nama_edit_admin'] = $rowEdit['nama_pengguna'];
                $data['select_pengguna_grup'] = $rowEdit['pengguna_grup'];
                $data['pengguna_id_edit'] = $rowEdit['pengguna_id'];
            }
        }
        $dataGrup = $this->ModelPengguna->dataGrup();
        $data['data_grup'] = $dataGrup;
        if($this->form_validation->run() == FALSE){
            template_admin($page, $data);
        }else{
            $update = array();
            $update['nama_pengguna'] = $this->input->post('nama_pengguna');
            $update['email'] = $this->input->post('email_pengguna');
            $update['pengguna_grup'] = $this->input->post('pengguna_grup');
            $this->db->where('pengguna_id', $this->input->post('pengguna_id_edit'));
            $this->db->update('pengguna', $update);
            $errmsg = '';
            $this->db->affected_rows() != 1 ? $errmsg = 'gagal' : $errmsg = 'berhasil';
            if($errmsg == 'gagal'){
                redirect(base_url().'admin/editPengguna/'.$this->input->post('pengguna_id_edit').'?errmsg='.$errmsg.'&nama_pengguna='.$this->input->post('nama_pengguna').'&pengguna_grup='.$this->input->post('pengguna_grup'));
            }else if($errmsg == 'berhasil'){
                redirect(base_url().'admin/pengguna');
            }
        }
    }

    public function hapus(){
        $penggunaId = $this->input->post('pengguna_id');
        $this->ModelPengguna->hapusData($penggunaId);
        $response = array(
            "status" => "success",
            "message" => "Data Berhasil dihapus"
        );
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function grup($page = 'user/user_grup'){
        if(!file_exists(APPPATH.'views/pages/admin/'.$page.'.php')){
            show_404();
        }

        $dataAdmin = data_admin($this->ModelPengguna);
        if($dataAdmin){
            $row = $dataAdmin->row_array();
            $data = array();
            $data['title'] = ucfirst('Data Admin Grup');
            $data['filejs'] = base_url().'public/admin/assets/user_grup.js';
            $data['dataJson'] = base_url().'admin/penggunaGrupJson';
            $data['tambahData'] = base_url().'admin/tambahGrup';
            $data['editData'] = base_url().'admin/editGrup';
            $data['hapusData'] = base_url().'admin/hapusGrup';
            $data['hakAkses'] = base_url().'admin/hakAkses';
            $current_url = $this->uri->segment(1);
            if($this->uri->segment(2)){
                $current_url .= '/'.$this->uri->segment(2);
            }
            $data['current_url'] = $current_url;
            $data['fixed'] = 'fixed';
            if($row){
                $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
                $data['nama_pengguna'] = $row['nama_pengguna'];
                $data['nama_grup'] = $dataGrup['nama_grup'];
                $data['pengguna_grup'] = $row['pengguna_grup'];
                $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
                $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
                $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
                $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
                $data['priviliges'] = button_halaman($dataHalaman);
            }
            template_admin($page, $data);
        }
    }

    public function dataGrupJson(){
        $draw = (int)$this->input->get('draw');
        $value = $this->input->get('search')['value'];
        $start = (int)$this->input->get('start');
        $length = (int)$this->input->get('length');
        $column = (int)$this->input->get('order')[0]['column'];
        $sort = $this->input->get('order')[0]['dir'];
        $recodsTotal = $this->ModelPengguna->countAdminGrup($value);
        $listGrup = $this->ModelPengguna->listAdminGrup($value, $start, $length, $column, $sort);
        $results = array();
        $dataAdmin = data_admin($this->ModelPengguna);
        $row = $dataAdmin->row_array();
        $idHalamanEdit = 16;
        $idHalamanHapus = 18;
        $idHalamanHakAkses = 21;
        if($row){
            $dataHalaman = $this->ModelHalamanMenu->byPetaHalaman($row['pengguna_grup'], $idHalamanHapus);
            $privilegesDelete = $dataHalaman->row_array();
            $dataHalamanEdit = $this->ModelHalamanMenu->byPetaHalaman($row['pengguna_grup'], $idHalamanEdit);
            $privilegesDetail = $dataHalamanEdit->row_array();
            $dataHalamanAkses = $this->ModelHalamanMenu->byPetaHalaman($row['pengguna_grup'], $idHalamanHakAkses);
            $privilegesHakAkses = $dataHalamanAkses->row_array();
            foreach ($listGrup->result() as $row) {
                array_push($results, [
                    'grup_id' => $row->grup_id, 'nama_grup' => $row->nama_grup, $idHalamanHapus => $privilegesDelete['pengguna_grup'], $idHalamanEdit => $privilegesDetail['pengguna_grup'], $idHalamanHakAkses => $privilegesHakAkses['pengguna_grup']
                ]);
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
        ->set_content_type('application/json', 'utf-8')
        ->set_output(json_encode($response, JSON_PRETTY_PRINT))
        ->_display();
        exit;
    }

    public function tambahGrup($page = 'user/tambah_grup'){
        if(!file_exists(APPPATH.'views/pages/admin/'.$page.'.php')){
            show_404();
        }

        $dataAdmin = data_admin($this->ModelPengguna);
        if($dataAdmin){
            $row = $dataAdmin->row_array();
            $data = array();
            $data['filejs'] = '';
            $data['nama_tambah_grup'] = '';
            $current_url = $this->uri->segment(1);
            if($this->uri->segment(2)){
                $current_url .= '/'.$this->uri->segment(2);
            }
            $data['current_url'] = $current_url;
            $data['fixed'] = 'fixed';
            if($row){
                $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
                $data['nama_pengguna'] = $row['nama_pengguna'];
                $data['nama_grup'] = $dataGrup['nama_grup'];
                $data['pengguna_grup'] = $row['pengguna_grup'];
                $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
                $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
                $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
                $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
                $data['priviliges'] = button_halaman($dataHalaman);
            }
            $dataGrup = $this->ModelPengguna->dataGrup();
            $data['data_grup'] = $dataGrup;

            template_admin($page, $data);
        }
    }

    public function tambahGrupBaru($page = 'user/tambah_grup'){
        $dataValidation = array('nama_grup' => 'belum diisi');
        is_validation($dataValidation);

        $data = array();
        $data['nama_tambah_grup'] = $this->input->post('nama_grup');
        $data['errmsg'] = '';
        $data['title'] = ucfirst('Tambah Admin Grup');
        $data['filejs'] = '';
        $dataAdmin = data_admin($this->ModelPengguna);
        $row = $dataAdmin->row_array();
        $current_url = $this->uri->segment(1);
        if($this->uri->segment(2)){
            $current_url .= '/'.$this->uri->segment(2);
        }
        $data['current_url'] = $current_url;
        $data['fixed'] = 'fixed';
        if($row){
            $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
            $data['nama_pengguna'] = $row['nama_pengguna'];
            $data['nama_grup'] = $dataGrup['nama_grup'];
            $data['pengguna_grup'] = $row['pengguna_grup'];
            $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
            $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
            $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
            $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
            $data['priviliges'] = button_halaman($dataHalaman);
        }
        $dataGrup = $this->ModelPengguna->dataGrup();
        $data['data_grup'] = $dataGrup;
        if($this->form_validation->run() == FALSE){
            template_admin($page, $data);
        }else{
            $insert = array();
            $insert['nama_grup'] = $this->input->post('nama_grup');
            $this->db->insert('pengguna_grup', $insert);
            $errmsg = '';
            $this->db->affected_rows() != 1 ? $errmsg = 'gagal' : $errmsg = 'berhasil';
            if($errmsg == 'gagal'){
                redirect(base_url().'admin/tambahGrup?errmsg='.$errmsg.'&nama_grup='.$this->input->post('nama_grup'));
            }else if($errmsg == 'berhasil'){
                redirect(base_url().'admin/penggunaGrup');
            }
        }
    }

    public function editGrup($page = 'user/edit_grup'){
        if(!file_exists(APPPATH.'views/pages/admin/'.$page.'.php')){
            show_404();
        }

        $dataAdmin = data_admin($this->ModelPengguna);
        if($dataAdmin){
            $row = $dataAdmin->row_array();
            $data = array();
            $data['filejs'] = '';
            $data['nama_edit_grup'] = '';
            $current_url = $this->uri->segment(1);
            if($this->uri->segment(2)){
                $current_url .= '/'.$this->uri->segment(2);
            }
            $data['current_url'] = $current_url;
            $data['fixed'] = 'fixed';
            if($row){
                $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
                $data['nama_pengguna'] = $row['nama_pengguna'];
                $data['nama_grup'] = $dataGrup['nama_grup'];
                $data['pengguna_grup'] = $row['pengguna_grup'];
                $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
                $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
                $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
                $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
                $data['priviliges'] = button_halaman($dataHalaman);
                $dataEdit = $this->ModelPengguna->idGrup($this->uri->segment(3));
                $rowEdit = $dataEdit->row_array();
                if($rowEdit){
                    $data['nama_edit_grup'] = $rowEdit['nama_grup'];
                    $data['grup_id_edit'] = $rowEdit['grup_id'];
                }
            }
            $dataGrup = $this->ModelPengguna->dataGrup();
            $data['data_grup'] = $dataGrup;

            template_admin($page, $data);
        }
    }

    public function updateGrup($page = 'user/edit_grup'){
        $dataValidation = array('nama_grup' => 'belum diisi');
        is_validation($dataValidation);

        $data = array();
        $data['nama_edit_grup'] = $this->input->post('nama_grup');
        $data['errmsg'] = '';
        $data['filejs'] = '';
        $current_url = $this->uri->segment(1);
        if($this->uri->segment(2)){
            $current_url .= '/'.$this->uri->segment(2);
        }
        $data['current_url'] = $current_url;
        $data['fixed'] = 'fixed';
        $dataAdmin = data_admin($this->ModelPengguna);
        $row = $dataAdmin->row_array();
        if($row){
            $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
            $data['nama_pengguna'] = $row['nama_pengguna'];
            $data['nama_grup'] = $dataGrup['nama_grup'];
            $data['pengguna_grup'] = $row['pengguna_grup'];
            $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
            $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
            $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
            $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
            $data['priviliges'] = button_halaman($dataHalaman);
            $dataEdit = $this->ModelPengguna->idGrup($this->input->post('grup_id_edit'));
            $rowEdit = $dataEdit->row_array();
            if($rowEdit){
                $data['nama_edit_grup'] = $rowEdit['nama_grup'];
                $data['grup_id_edit'] = $rowEdit['grup_id'];
            }
        }
        $dataGrup = $this->ModelPengguna->dataGrup();
        $data['data_grup'] = $dataGrup;
        if($this->form_validation->run() == FALSE){
            template_admin($page, $data);
        }else{
            $update = array();
            $update['nama_grup'] = $this->input->post('nama_grup');
            $this->db->where('grup_id', $this->input->post('grup_id_edit'));
            $this->db->update('pengguna_grup', $update);
            $errmsg = '';
            $this->db->affected_rows() != 1 ? $errmsg = 'gagal' : $errmsg = 'berhasil';
            if($errmsg == 'gagal'){
                redirect(base_url().'admin/editGrup/'.$this->input->post('grup_id_edit').'?errmsg='.$errmsg.'&nama_grup='.$this->input->post('nama_grup'));
            }else if($errmsg == 'berhasil'){
                redirect(base_url().'admin/penggunaGrup');
            }
        }
    }

    public function hapusGrup(){
        $idGrup = $this->input->post('grup_id');
        $this->ModelPengguna->hapusDataGrup($idGrup);
        $response = array(
            "status" => "success",
            "message" => "Data Berhasil dihapus"
        );
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response, JSON_PRETTY_PRINT))
            ->_display();
        exit;
    }

    public function hakAkses($page = 'user/hak_akses'){
        if(!file_exists(APPPATH.'views/pages/admin/'.$page.'.php')){
            show_404();
        }

        $dataAdmin = data_admin($this->ModelPengguna);
        if($dataAdmin){
            $row = $dataAdmin->row_array();
            $data = array();
            $data['title'] = ucfirst('Hak Akses');
            $data['filejs'] = base_url().'public/admin/assets/hak_akses.js';
            $data['nama_edit_grup'] = '';
            $current_url = $this->uri->segment(1);
            if($this->uri->segment(2)){
                $current_url .= '/'.$this->uri->segment(2);
            }
            $data['current_url'] = $current_url;
            $data['fixed'] = 'fixed';
            if($row){
                $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
                $data['nama_pengguna'] = $row['nama_pengguna'];
                $data['nama_grup'] = $dataGrup['nama_grup'];
                $data['pengguna_grup'] = $row['pengguna_grup'];
                $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
                $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
                $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
                $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
                $data['priviliges'] = button_halaman($dataHalaman);
                $dataEdit = $this->ModelPengguna->idGrup($this->uri->segment(3));
                $rowEdit = $dataEdit->row_array();
                if($rowEdit){
                    $data['nama_edit_grup'] = $rowEdit['nama_grup'];
                    $data['grup_id_edit'] = $rowEdit['grup_id'];
                }
                $dataHalaman = $this->ModelHalamanMenu->byNama('admin', $this->uri->segment(3));
                $data['halaman_admin'] = $dataHalaman;
            }
            $dataGrup = $this->ModelPengguna->dataGrup();
            $data['data_grup'] = $dataGrup;

            template_admin($page, $data);
        }
    }

    public function updateHakAkses(){
        $data = array();
        $data['nama_edit_grup'] = '';
        $data['errmsg'] = '';
        $data['title'] = ucfirst('Hak Akses');
        $data['filejs'] = '';
        $dataAdmin = data_admin($this->ModelPengguna);
        $row = $dataAdmin->row_array();
        $current_url = $this->uri->segment(1);
        if($this->uri->segment(2)){
            $current_url .= '/'.$this->uri->segment(2);
        }
        $data['current_url'] = $current_url;
        $data['fixed'] = 'fixed';
        if($row){
            $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
            $data['nama_pengguna'] = $row['nama_pengguna'];
            $data['nama_grup'] = $dataGrup['nama_grup'];
            $data['pengguna_grup'] = $row['pengguna_grup'];
            $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
            $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
            $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
            $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
            $data['priviliges'] = button_halaman($dataHalaman);
            $dataEdit = $this->ModelPengguna->idGrup($this->input->post('grup_id_edit'));
            $rowEdit = $dataEdit->row_array();
            if($rowEdit){
                $data['nama_edit_grup'] = $rowEdit['nama_grup'];
                $data['grup_id_edit'] = $rowEdit['grup_id'];
            }
        }
        $dataGrup = $this->ModelPengguna->dataGrup();
        $data['data_grup'] = $dataGrup;
        $insert = array();
        $halaman = $this->input->post("halaman");
        $pengguna_grup = $this->input->post('grup_id_edit');
        $this->ModelHalamanMenu->deletePeta($pengguna_grup);
        $errmsg = '';
        if(isset($halaman)){
            for($i=0; $i < count($halaman); $i++){
                $insert = array(
                    'pengguna_grup' => $pengguna_grup,
                    'halaman_menu' => $halaman[$i]
                );
                $this->db->insert('hak_akses_menu', $insert);
                $this->db->affected_rows() != 1 ? $errmsg = 'gagal' : $errmsg = 'berhasil';
            }
        }
        if($errmsg == 'gagal'){
            redirect(base_url().'admin/hakAkses/'.$this->input->post('grup_id_edit').'?errmsg='.$errmsg);
        }else if($errmsg == 'berhasil'){
            redirect(base_url().'admin/penggunaGrup');
        }else{
            redirect(base_url().'admin/hakAkses/'.$this->input->post('grup_id_edit'));
        }
    }

    public function gantiPassword($page = 'user/ganti_password'){
        if(!file_exists(APPPATH.'views/pages/admin/'.$page.'.php')){
            show_404();
        }

        $dataAdmin = data_admin($this->ModelPengguna);
        if($dataAdmin){
            $row = $dataAdmin->row_array();
            $data = array();
            $data['filejs'] = '';
            $data['password'] = '';
            $data['konf_password'] = '';
            $current_url = $this->uri->segment(1);
            if($this->uri->segment(2)){
                $current_url .= '/'.$this->uri->segment(2);
            }
            $data['current_url'] = $current_url;
            $data['fixed'] = 'fixed';
            if($row){
                $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
                $data['nama_pengguna'] = $row['nama_pengguna'];
                $data['nama_grup'] = $dataGrup['nama_grup'];
                $data['pengguna_grup'] = $row['pengguna_grup'];
                $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
                $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
                $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
                $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
                $data['priviliges'] = button_halaman($dataHalaman);
                $dataEdit = $this->ModelPengguna->idAdmin($this->uri->segment(3));
                $rowEdit = $dataEdit->row_array();
                if($rowEdit){
                    $data['nama_pengguna_edit'] = $rowEdit['nama_pengguna'];
                    $data['pengguna_id_edit'] = $rowEdit['pengguna_id'];
                }
            }
            $dataGrup = $this->ModelPengguna->dataGrup();
            $data['data_grup'] = $dataGrup;
            template_admin($page, $data);
        }
    }

    public function updatePassword($page = 'user/ganti_password'){
        $dataValidation = array('password' => 'belum diisi', 'konf_password' => 'belum diisi');
        is_validation($dataValidation);

        $data = array();
        $data['password'] = $this->input->post('password');
        $data['konf_password'] = $this->input->post('konf_password');
        $data['errmsg'] = '';
        $data['title'] = ucfirst('Ganti Password');
        $data['filejs'] = '';
        $dataAdmin = data_admin($this->ModelPengguna);
        $row = $dataAdmin->row_array();
        $current_url = $this->uri->segment(1);
        if($this->uri->segment(2)){
            $current_url .= '/'.$this->uri->segment(2);
        }
        $data['current_url'] = $current_url;
        $data['fixed'] = 'fixed';
        if($row){
            $dataGrup = $this->ModelPengguna->idGrup($row['pengguna_grup'])->row_array();
            $data['nama_pengguna'] = $row['nama_pengguna'];
            $data['nama_grup'] = $dataGrup['nama_grup'];
            $data['pengguna_grup'] = $row['pengguna_grup'];
            $data['errmsg'] = $_GET ? $this->input->get('errmsg') : '';
            $data['menuHalaman'] = $this->ModelHalamanMenu->byUrl($current_url)->row();
            $data['menuPriviliges'] = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'ya');
            $dataHalaman = $this->ModelHalamanMenu->byPeta($row['pengguna_grup'], 'tidak');
            $data['priviliges'] = button_halaman($dataHalaman);
        }
        $dataGrup = $this->ModelPengguna->dataGrup();
        $data['data_grup'] = $dataGrup;
        if($this->form_validation->run() == FALSE){
            $dataEdit = $this->ModelPengguna->idAdmin($this->input->post('pengguna_id_edit'));
            $rowEdit = $dataEdit->row_array();
            if($rowEdit){
                $data['nama_pengguna_edit'] = $rowEdit['nama_pengguna'];
                $data['pengguna_id_edit'] = $rowEdit['pengguna_id'];
            }
            template_admin($page, $data);
        }else{
            if($this->input->post('password') != $this->input->post('konf_password')){
                redirect(base_url().'admin/gantiPassword/'.$this->input->post('pengguna_id_edit').'?errmsg=password dan konfirmasi password tidak sama');
            }else{
                $update = array();
                $update['password'] = sha1($this->input->post('password'));
                $this->db->where('pengguna_id', $this->input->post('pengguna_id_edit'));
                $this->db->update('pengguna', $update);
                $errmsg = '';
                $this->db->affected_rows() != 1 ? $errmsg = 'gagal' : $errmsg = 'berhasil';
                if($errmsg == 'gagal'){
                    redirect(base_url().'admin/gantiPassword/'.$this->input->post('pengguna_id_edit').'?errmsg='.$errmsg);
                }else if($errmsg == 'berhasil'){
                    redirect(base_url().'admin/pengguna');
                }
            }
        }
    }
}
?>