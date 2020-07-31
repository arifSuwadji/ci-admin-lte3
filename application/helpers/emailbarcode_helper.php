<?php

function send_email_barcode($idPeserta, $idAcara, $subject){
    $ci =& get_instance();

    $ci->load->library('email');
    
    $config = array(
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'priority' => 1,
    );
    $ci->email->initialize($config);
    $ci->email->from('no-reply@absensi.datanetwork.id', 'Absensi Digital Data Network Indonesia');
    
    $dataPeserta = $ci->db->get_where('peserta', array('perserta_id' => $idPeserta))->row();
    $dataAcara = $ci->db->get_where('acara', array('acara_id' => $idAcara))->row();

    $data_barcode = json_decode($dataPeserta->images_barcode);
    $image_acara = json_decode($dataAcara->images);

    $ci->email->to($dataPeserta->email_peserta);
    $ci->email->subject($subject);

    $data = array(
        'nama_peserta' => $dataPeserta->nama_peserta,
        'no_telp_peserta' => $dataPeserta->no_telp_peserta,
        'email_peserta' => $dataPeserta->email_peserta,
        'image_barcode' => base_url().$data_barcode->image,
        'nama_acara' => $dataAcara->nama_acara,
        'tanggal_acara' => dateText($dataAcara->tanggal_acara),
        'image_acara' => base_url().$image_acara->image
    );

    $body = $ci->load->view('email/barcode.php', $data, TRUE);
    $ci->email->message($body);
    $ci->email->send();

}

?>