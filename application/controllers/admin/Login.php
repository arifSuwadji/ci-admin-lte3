<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_controller {
    public function __construct(){
        parent::__construct();

        $this->load->model('admin/ModelPengguna');
    }

    public function index(){
        if(!file_exists(APPPATH.'views/pages/admin/login.php')){
            show_404();
        }

        $data = array();
        $data['nama_pengguna'] =  '';
        $data['password'] =  '';
        $data['errmsg'] = $_GET ? $_GET['errmsg'] : '';
        $this->load->view('pages/admin/login.php', $data);
    }

    public function action(){
        $this->form_validation->set_rules('nama_pengguna','user', 'required', array('required' => '%s belum diisi'));
        $this->form_validation->set_rules('password','Password', 'required', array('required' => '%s belum diisi'));

        $data = array(
            'username' => $this->input->post('nama_pengguna'),
            'password' => $this->input->post('password')
        );
        $data['nama_pengguna'] = $this->input->post('nama_pengguna');
        $data['errmsg'] = '';
        if($this->form_validation->run() == FALSE){
            $this->load->view('pages/admin/login', $data);
        }else{
            $password = sha1($this->input->post('password'));
            $dataAdmin = $this->ModelPengguna->byUserPassword($data['username'], $password);
            $row = $dataAdmin->row_array();
            if($row){
                $dataSession = array();
                $dataSession['pengguna_id'] = $row['pengguna_id'];
                $dataSession['nama_pengguna'] = $row['nama_pengguna'];
                $dataSession['username'] = $row['username'];
                $this->session->set_userdata('adminDistribusi', $dataSession);
                $this->db->where('pengguna', $row['pengguna_id']);
                redirect(base_url().'admin');
            }else{
                redirect(base_url().'admin/login?errmsg=password yang anda masukkan salah');
            }
        }

    }
}
?>