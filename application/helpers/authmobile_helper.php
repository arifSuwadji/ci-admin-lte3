<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

$table = 'pengguna';

/**
 * login_mobile params username and password
 */
function login_mobile($email, $password){
    $ci =& get_instance();

    $result = $ci->db->get_where('pengguna', array('email' => $email, 'password' => $password))->row();
    if($result){
        $key = $ci->config->config['encryption_key'];
        $payload = array(
            "pengguna_id" => $result->pengguna_id,
            "pengguna_grup" => $result->pengguna_grup,
            "nama_pengguna" => $result->nama_pengguna,
            "username" => $result->username,
            "email" => $result->email
        );
    
        $jwt = JWT::encode($payload, $key);
        return array('status' => TRUE, 'token' => $jwt);
    }else{
        return array('status' => FALSE, 'token' => '');
    }

}

/**
 * register param address array
 */
function register_mobile($dataDaftar){
    $ci =& get_instance();
    
    $dataInsert = array();
    foreach($dataDaftar as $key => $value){
        $dataInsert[$key] = $value;
    }
    try {
        //code...
        $ci->db->insert($table, $dataInsert);
        $idPengguna = $this->db->insert_id();
    
        $key = $ci->config->config['encryption_key'];
        $payload = array(
            "pengguna_id" => $idPengguna,
            "pengguna_grup" => $dataDaftar['pengguna_grup'],
            "nama_pengguna" => $dataDaftar['nama_pengguna'],
            "username" => $dataDaftar['username'],
            "email" => $dataDaftar['email']
        );
    
        $jwt = JWT::encode($payload, $key);
        $decoded = JWT::decode($jwt, $key, array('HS256'));
        return array('status' => TRUE, 'token' => $jwt, 'pengguna_id' => $idPengguna, 'pengguna_grup' => $decoded->pengguna_grup, 'message' => 'register success');
    } catch (\Throwable $th) {
        //throw $th;
        return array('status' => FALSE, 'token' => '', 'message' => 'register failed');
    }
}

/**
 * check session token
 */
function session_mobile($token){
    $ci =& get_instance();
    
    $key = $ci->config->config['encryption_key'];
    try {
        JWT::$leeway = 60; // $leeway in seconds
        $decoded = JWT::decode($token, $key, array('HS256'));
        if($decoded->pengguna_id){
            return array('status' => TRUE, 'user' => $decoded, 'message' => 'token valid');
        }else{
            return array('status' => FALSE, 'user' => $decoded, 'message' => 'token has ended');
        }
    } catch (\Throwable $th) {
        //throw $th;
        return array('status' => FALSE, 'user' => '', 'message' => $th);
    }
}

/**
 * validation params
 */
function validation_params($dataArray){
    $ci =& get_instance();

    for($i=0; $i < count($dataArray); $i++){
        $param = $ci->input->post($dataArray[$i]);
        if(!$param){
            return array('status' => FALSE, 'message' => 'params '.$dataArray[$i].' empty');
        }
    }
    return array('status' => TRUE, 'message' => 'params valid');
}

?>