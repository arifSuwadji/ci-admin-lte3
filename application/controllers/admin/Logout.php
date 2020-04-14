<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_controller {
    public function __construct(){
        parent::__construct();

        $this->load->model('admin/ModelPengguna');
    }

    public function index(){
        is_logout();
    }
}
?>