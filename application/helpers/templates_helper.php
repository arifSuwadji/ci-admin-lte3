<?php

function template_admin($content, $data){
    $ci =& get_instance();
    
    $ci->load->view("templates/admin/header", $data);
    $ci->load->view("templates/admin/menu", $data);
    $ci->load->view("pages/admin/".$content, $data);
    $ci->load->view("templates/admin/footer", $data);
}

function is_login(){
    $ci =& get_instance();
    
    if(isset($ci->session->userdata['adminDistribusi'])){
    }else{
        $data = array();
        $data['nama_pengguna'] = $_GET ? $ci->input->get('nama_pengguna') : '';
        $data['password'] = $_GET ? $ci->input->get('password') : '';
        $data['errmsg'] = $_GET ? $ci->input->get('errmsg') : '';
        $ci->load->view('pages/admin/login', $data);
    }
}

function is_logout(){
    $ci =& get_instance();
    
    $ci->db->where('pengguna', $ci->session->userdata['adminDistribusi']['pengguna_id']);
    $sess_data = array(
        'pengguna_id' => '',
        'nama_pengguna' => '',
    );
    $ci->session->unset_userdata('adminDistribusi', $sess_data);
    redirect(base_url().'admin');
}

function button_halaman($dataButtonHalaman){
    $ci =& get_instance();
    
    $arrayData = array();
    $object = (object) array();
    $objectOut = (object) array();
    foreach($dataButtonHalaman->result() as $hal){
        array_push($arrayData, [$hal->halaman_menu => $hal->pengguna_grup]);
    }
    foreach($arrayData as $key => $value){
        foreach($value  as $key2 => $value2){
            $object->$key2 = $value2;
        }
    }
    foreach($object as $key => $value){
        $objectOut->$key = $value;
    }
    return $objectOut;
}

function is_validation($dataArray){
    $ci =& get_instance();
    
    foreach($dataArray as $key => $value){
        $langField = str_replace('_',' ', $key);
        $langField = ucwords($langField);
        $ci->form_validation->set_rules($key, $langField, 'required', array('required' => '%s '.$value));
    }
}

function data_admin($model){
    $ci =& get_instance();
    
    $row = 0;
    if(isset($ci->session->userdata['adminDistribusi'])){
        $row = $model->idAdmin($ci->session->userdata['adminDistribusi']['pengguna_id']);
    }
    return $row;
}
?>