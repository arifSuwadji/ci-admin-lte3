<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Pengguna extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

    }

    public function login_post(){
        $validate = validation_params(array('email', 'password'));
        if ( $validate['status'] == TRUE ){
            $email = $this->post('email');
            $password = $this->post('password');
            
            if ( $email && $password ){
                $password = sha1($password);
                $token = login_mobile($email, $password);
                // Check if the users data store contains users
                if ( $token['status'] == TRUE){
    
                    // Set the response and exit
                    $response = array(
                        "status" => true,
                        "message" => "Login Success",
                        "token" => $token['token']
                    );
                    $this->response( $response, 200 );
                }
                else{
                    // Set the response and exit
                    $this->response( [
                        'status' => false,
                        'message' => 'No users were found',
                        'token' => ''
                    ], 404 );
                }
            }else{
                $this->response( [
                    'status' => false,
                    'message' => 'Your params nothing',
                    'token' => ''
                ], 404 );
            }
        }else{
            $this->response( [
                'status' => false,
                'message' => $validate['message'],
                'token' => ''
            ], 404 );
        }
    }

    public function register_post(){
        //validation params
        $validate = validation_params(array('grup', 'nama', 'hp', 'email','alamat', 'password'));
        
        if ( $validate['status'] == TRUE ){
            $grup = $this->post('grup');
            $nama = $this->post('nama');
            $arrNama = explode(' ',$nama);
            $user = $arrNama[0];
            $hp = $this->post('hp');
            $email = $this->post('email');
            $alamat = $this->post('alamat');
            $password = $this->post('password');
            $register_array = array(
                'pengguna_grup' => $grup,
                'nama_pengguna' => $nama,
                'username' => $user,
                'email' => $email,
                'password' => sha1($password)
            );
            $register = register_mobile($register_array);
            
            if ( $register['status'] == TRUE ){
                $idPengguna = $register['pengguna_id'];
                $pengguna_grup = $register['pengguna_grup'];
                //insert by grup
                if($pengguna_grup == 1){
                    //admin
                    //nothing to do
                }else if($pengguna_grup == 2){
                    //rs
                    //insert table rumah sakit
                    $insert = array(
                        'nama_rumah_sakit' => $nama,
                        'alamat_rumah_sakit' => $alamat,
                        'no_hp_rumah_sakit' => $hp,
                        'email_rumah_sakit' => $email,
                        'admin_rumah_sakit' => $idPengguna
                    );
                    $this->db->insert('rumah_sakit', $insert);
                }else if($pengguna_grup == 3){
                    //relawan
                    //insert table relawan
                    $insert = array(
                        'nama_relawan' => $nama,
                        'alamat_relawan' => $alamat,
                        'no_hp_relawan' => $hp,
                        'email_relawan' => $email,
                        'admin_relawan' => $idPengguna
                    );
                    $this->db->insert('relawan', $insert);
                }
                
                // Set the response and exit
                $response = array(
                    "status" => true,
                    "message" => "Register Success",
                    "token" => $token
                );
                $this->response( $response, 200 );
            }
            else{
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => 'No users were found',
                    'token' => ''
                ], 404 );
            }
        }else{
            $this->response( [
                'status' => false,
                'message' => $validate['message'],
                'token' => ''
            ], 404 );
        }
    }

    /**
     * data pengguna all atau dengan param
     * Method GET
     * @params pengguna_id
     * 
     */
    public function index_get(){
        $token = $this->input->get_request_header('Authorization');

        $validToken = session_mobile($token);
        if($validToken['status'] == TRUE){
            $id = $this->get('pengguna_id');
            if($id){
                $this->db->where('pengguna_id', $id);
                $data = $this->db->get('pengguna')->result();
            }else{
                $data = $this->db->get('pengguna')->result();
            }
            $this->response([
                'status' => true,
                'message' => 'data pengguna',
                'data' => $data,
            ], 200);
        }else{
            $this->response([
                'status' => false,
                'message' => 'Authorization failed',
                'data' => ''
            ], 404);
        }
    }

    /**
     * update pengguna
     * method POST params pengguna_id pengguna_grup nama_pengguna username email
     * @params
     */
    public function update_post(){
        $token = $this->input->get_request_header('Authorization');

        $validToken = session_mobile($token);
        if($validToken['status'] == TRUE){
            //validation params
            $validate = validation_params(array('pengguna_id'));
            if($validate['status'] == TRUE) {
                $update = array();
                $id = $this->post('pengguna_id');
                $grup = $this->post('pengguna_grup');
                if($grup) $update['pengguna_grup'] = $grup;
                $nama_pengguna = $this->post('nama_pengguna');
                if($nama_pengguna) $update['nama_pengguna'] = $nama_pengguna;
                $username = $this->post('username');
                if($username) $update['username'] = $username;
                $email = $this->post('email');
                if($email) $update['email'] = $email;
                $this->db->where('pengguna_id', $id);
                $forupdate = $this->db->update('pengguna', $update);
                if ($forupdate) {
                    $this->response([
                        'status' => true,
                        'message' => 'update success',
                    ], 200);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => 'update failed',
                    ], 404);
                }
            }else{
                $this->response( [
                    'status' => false,
                    'message' => $validate['message'],
                    'token' => ''
                ], 404 );
            }
            
        }else{
            $this->response([
                'status' => false,
                'message' => 'Authorization failed',
                'data' => ''
            ], 404);
        }
    }

    /**
     * delete pengguna 
     * Method POST
     * @params pengguna_id
     */
    public function delete_post(){
        $token = $this->input->get_request_header('Authorization');

        $validToken = session_mobile($token);
        if($validToken['status'] == TRUE){
            //validation params
            $validate = validation_params(array('pengguna_id'));
            if($validate['status'] == TRUE) {
                $id = $this->post('pengguna_id');
                $this->db->where('pengguna_id', $id);
                $delete = $this->db->delete('pengguna');
                if($delete){
                    $this->response([
                        'status' => true,
                        'message' => 'delete success',
                        'data' => $id
                    ], 200);
                }else{
                    $this->response([
                        'status' => false,
                        'message' => 'delete failed',
                        'data' => $id
                    ], 404);
                }
            }else{
                $this->response( [
                    'status' => false,
                    'message' => $validate['message'],
                    'token' => ''
                ], 404 );
            }
            
        }else{
            $this->response([
                'status' => false,
                'message' => 'Authorization failed',
                'data' => ''
            ], 404);
        }
    }
}

?>