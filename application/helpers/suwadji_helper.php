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

?>
