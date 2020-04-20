<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ModelPengguna extends CI_model{
        private $table = 'pengguna';

        public function emailPassword($email, $password){
            return $this->db->get_where($this->table, array('email' => $email, 'password' => $password))->row();
        }
    }

?>