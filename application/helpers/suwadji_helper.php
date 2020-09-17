<?php

function AllField($table){
    $ci =& get_instance();
    
    $ci->db->select("COLUMN_NAME,COLUMN_KEY,DATA_TYPE");
    $ci->db->where(array("TABLE_SCHEMA" => $ci->db->database, "TABLE_NAME" => $table));
    $ci->db->from("INFORMATION_SCHEMA.COLUMNS");
    $columns = $ci->db->get();
    $column_name = [];
    foreach($columns->result() as $column){
        $column_name[] = array('column_name' => $column->COLUMN_NAME);
    }
    return $column_name;
}

function createFile($string, $path)
{
    $create = fopen($path, "wb") or die("Unable to open file!");
    fwrite($create, $string);
    fclose($create);
    return $path;
}

function nameMonth($bulan){
    $bulanb = array(
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember',
    );
    return $bulanb[$bulan];
}

function dateText($date){
    return date('d', strtotime($date))." ".nameMonth(date('m', strtotime($date)))." ".date('Y', strtotime($date));
}

// This function will return a random 
// string of specified length 
function random_image_name($length_of_string) { 
  
    // String of all alphanumeric character 
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'; 
  
    // Shufle the $str_result and returns substring 
    // of specified length 
    return substr(str_shuffle($str_result), 0, $length_of_string); 
}

?>
