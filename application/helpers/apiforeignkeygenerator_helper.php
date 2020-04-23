<?php
/**
 * controller function
 */
function api_foreignkey_controller($controller, $table, $table_foreignkey_one, $table_foreignkey_two){
        $ci =& get_instance();
        
        $allColumns = AllField($table);
        $dataFilter = array();
        foreach($allColumns as $fieldName){
            array_push($dataFilter, $fieldName['column_name']);
        }

        $allColumns_foreignkey_one = AllField($table_foreignkey_one);
        $dataFilter_foreignkey_one = array();
        foreach($allColumns_foreignkey_one as $fieldName){
            array_push($dataFilter_foreignkey_one, $fieldName['column_name']);
        }

        $allColumns_foreignkey_two = AllField($table_foreignkey_two);
        $dataFilter_foreignkey_two = array();
        foreach($allColumns_foreignkey_two as $fieldName){
            array_push($dataFilter_foreignkey_two, $fieldName['column_name']);
        }

        $string = "<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

class ".$controller." extends RestController {
    public function __construct(){
        parent::__construct();
        
    }
        ";

        $string .='
    /**
     * data '.$table.' all atau dengan param
     * Method GET
     * @params '.$dataFilter[0].'
     * 
     */
    public function index_get(){
        $token = $this->input->get_request_header("Authorization");

        $validToken = session_mobile($token);
        if($validToken["status"] == TRUE){
            $id = $this->get("'.$dataFilter[0].'");
            if($id){
                $this->db->where("'.$dataFilter[0].'", $id);
                $data = $this->db->get("'.$table.'")->result();
            }else{
                $data = $this->db->get("'.$table.'")->result();
            }
            $this->response([
                "status" => true,
                "message" => "data '.ucwords(str_replace('_',' ',$table)).'",
                "data" => $data,
            ], 200);
        }else{
            $this->response([
                "status" => false,
                "message" => "Authorization failed",
                "data" => ""
            ], 404);
        }
    }
        ';
        $string .='
    /**
     * get data '.$table_foreignkey_one.'
     * method GET
     * @params '.$table_foreignkey_one.'
     */
    public function '.$table_foreignkey_one.'_get(){
        $token = $this->input->get_request_header("Authorization");

        $validToken = session_mobile($token);
        if($validToken["status"] == TRUE){
            //validation params
            $validate = validation_get_params(array("'.$table_foreignkey_one.'"));
            if($validate["status"] == TRUE) {
                $id = $this->get("'.$table_foreignkey_one.'");
                $this->db->where("'.$dataFilter_foreignkey_one[0].'", $id);
                $data = $this->db->get("'.$table_foreignkey_one.'")->result();
                $this->response([
                    "status" => true,
                    "message" => "data '.ucwords(str_replace('_',' ',$table_foreignkey_one)).'",
                    "data" => $data,
                ], 200);
            }else{
                $this->response( [
                    "status" => false,
                    "message" => $validate["message"],
                    "token" => ""
                ], 404 );
            }
        }else{
            $this->response([
                "status" => false,
                "message" => "Authorization failed",
                "data" => ""
            ], 404);
        }
    }
        ';
        $string .='
    /**
     * get data '.$table_foreignkey_two.'
     * method GET
     * @params '.$table_foreignkey_two.'
     */
    public function '.$table_foreignkey_two.'_get(){
        $token = $this->input->get_request_header("Authorization");

        $validToken = session_mobile($token);
        if($validToken["status"] == TRUE){
            //validation params
            $validate = validation_get_params(array("'.$table_foreignkey_two.'"));
            if($validate["status"] == TRUE) {
                $id = $this->get("'.$table_foreignkey_two.'");
                $this->db->where("'.$dataFilter_foreignkey_two[0].'", $id);
                $data = $this->db->get("'.$table_foreignkey_two.'")->result();
                $this->response([
                    "status" => true,
                    "message" => "data '.ucwords(str_replace('_',' ',$table_foreignkey_two)).'",
                    "data" => $data,
                ], 200);
            }else{
                $this->response( [
                    "status" => false,
                    "message" => $validate["message"],
                    "token" => ""
                ], 404 );
            }
        }else{
            $this->response([
                "status" => false,
                "message" => "Authorization failed",
                "data" => ""
            ], 404);
        }
    }
        ';
        $string .='
    /**
     * insert '.$table.'
     * method POST
     * @params
        ';
    foreach($dataFilter as $fieldName){
        $string .='
     * '.$fieldName.'
        ';
    }
        $string .='
     * 
     */
    public function insert_post(){
        $token = $this->input->get_request_header("Authorization");

        $validToken = session_mobile($token);
        if($validToken["status"] == TRUE){
            //validation params
            $validate = validation_params(array(
        ';
        $i = 0;
        foreach($dataFilter as $fieldName){
            if($i > 0){
        $string .='
                "'.$fieldName.'",
        ';
            }
        }
        $string .='
            ));
            if($validate["status"] == TRUE) {
                $insert = array();
        ';
        $i = 0;
        foreach($dataFilter as $fieldName){
            if($i > 0){
        $string .='
                $insert["'.$fieldName.'"] = $this->post("'.$fieldName.'");
        ';
            }
            $i++;
        }
        $string .='
                $forinsert = $this->db->insert("'.$table.'", $insert);
                if($forinsert){
                    $this->response([
                        "status" => true,
                        "message" => "insert table '.ucwords(str_replace('_',' ',$table)).' success",
                    ], 200);
                }else{
                    $this->response([
                        "status" => true,
                        "message" => "insert table '.ucwords(str_replace('_',' ',$table)).' failed",
                    ], 404);
                }
            }else{
                $this->response( [
                    "status" => false,
                    "message" => $validate["message"],
                    "token" => ""
                ], 404 );
            }
        ';
        $string .='
        }else{
            $this->response([
                "status" => false,
                "message" => "Authorization failed",
                "data" => ""
            ], 404);
        }
    }

    /**
     * update '.$table.'
     * method POST 
     * @params
        ';
    foreach($dataFilter as $fieldName){
        $string .='
     * '.$fieldName.'
        ';
    }
        $string .='
     */
    public function update_post(){
        $token = $this->input->get_request_header("Authorization");

        $validToken = session_mobile($token);
        if($validToken["status"] == TRUE){
            //validation params
            $validate = validation_params(array("'.$dataFilter[0].'"));
            if($validate["status"] == TRUE) {
                $update = array();
                $id = $this->post("'.$dataFilter[0].'");
        ';
        $i = 0;
        foreach($dataFilter as $fieldName){
            if($i > 0){
        $string .='
                $'.$fieldName.' = $this->post("'.$fieldName.'");
                if($'.$fieldName.') $update["'.$fieldName.'"] = $'.$fieldName.';
        ';
            }
            $i++;
        }
        $string .='
                $this->db->where("'.$dataFilter[0].'", $id);
                $forupdate = $this->db->update("'.$table.'", $update);
                if ($forupdate) {
                    $this->response([
                        "status" => true,
                        "message" => "update table '.ucwords(str_replace('_',' ',$table)).' success",
                    ], 200);
                } else {
                    $this->response([
                        "status" => false,
                        "message" => "update table '.ucwords(str_replace('_',' ',$table)).' failed",
                    ], 404);
                }
            }else{
                $this->response( [
                    "status" => false,
                    "message" => $validate["message"],
                    "token" => ""
                ], 404 );
            }
            
        }else{
            $this->response([
                "status" => false,
                "message" => "Authorization failed",
                "data" => ""
            ], 404);
        }
    }

    /**
     * delete '.$table.' 
     * Method POST
     * @params '.$dataFilter[0].'
     */
    public function delete_post(){
        $token = $this->input->get_request_header("Authorization");

        $validToken = session_mobile($token);
        if($validToken["status"] == TRUE){
            //validation params
            $validate = validation_params(array("'.$dataFilter[0].'"));
            if($validate["status"] == TRUE) {
                $id = $this->post("'.$dataFilter[0].'");
                $this->db->where("'.$dataFilter[0].'", $id);
                $delete = $this->db->delete("'.$table.'");
                if($delete){
                    $this->response([
                        "status" => true,
                        "message" => "delete table '.ucwords(str_replace('_',' ',$table)).' success",
                        "data" => $id
                    ], 200);
                }else{
                    $this->response([
                        "status" => false,
                        "message" => "delete table '.ucwords(str_replace('_',' ',$table)).' failed",
                        "data" => $id
                    ], 404);
                }
            }else{
                $this->response( [
                    "status" => false,
                    "message" => $validate["message"],
                    "token" => ""
                ], 404 );
            }
            
        }else{
            $this->response([
                "status" => false,
                "message" => "Authorization failed",
                "data" => ""
            ], 404);
        }
    }
}
?>
        ';
        
        $path = APPPATH."controllers/api/".$controller.".php";
        createFile($string, $path);
}

?>