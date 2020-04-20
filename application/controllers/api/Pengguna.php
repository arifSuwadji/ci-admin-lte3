<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Pengguna extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

        $this->load->model("api/ModelPengguna");
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
                //insert by grup
                //sampai sini
                
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
}

?>