<?php

class AdjiGenerator extends CI_Controller {
    private $buttonTambah = '';
    private $buttonTambahAksi = '';
    private $buttonEdit = '';
    private $buttonEditAksi = '';
    private $buttonHapus = '';
    
    public function __construct(){
        parent::__construct();
    }

    public function help(){
        $result = "Adji Generator commands\r\n";
        $result .= "php index.php AdjiGenerator crud ControllerName table_Name \r\n";
        $result .= "php index.php AdjiGenerator crud_filter ControllerName table_Name table_foreign_one table_foreign_two \r\n";
        $result .= "php index.php AdjiGenerator api ControllerName table_Name \r\n";

        echo $result. PHP_EOL;
    }

    public function crud($controller="", $table=""){
        //load controller
        $admin_controller = admin_controller($controller, $table, $this->buttonTambah, $this->buttonTambahAksi, $this->buttonEdit, $this->buttonEditAksi, $this->buttonHapus);

        //load template index
        template_index($controller, $table, $admin_controller['buttonTambah'], $admin_controller['buttonTambahAksi'], $admin_controller['buttonEdit'], $admin_controller['buttonEditAksi'], $admin_controller['buttonHapus']);

        //load template tambah
        template_tambah($controller, $table, $admin_controller['buttonTambah'], $admin_controller['buttonTambahAksi'], $admin_controller['buttonEdit'], $admin_controller['buttonEditAksi'], $admin_controller['buttonHapus']);

        //load template edit
        template_edit($controller, $table, $admin_controller['buttonTambah'], $admin_controller['buttonTambahAksi'], $admin_controller['buttonEdit'], $admin_controller['buttonEditAksi'], $admin_controller['buttonHapus']);

        //load models
        model_generator($controller, $table);

        //load js
        js_generator($controller, $table, $admin_controller['buttonTambah'], $admin_controller['buttonTambahAksi'], $admin_controller['buttonEdit'], $admin_controller['buttonEditAksi'], $admin_controller['buttonHapus']);
        
        echo "Class ".$controller."\r\n";
        echo "table ".$table."\r\n";
    }

    public function crud_filter ($controller="", $table="", $table_foreign_one="", $table_foreign_two=""){
        echo "Class ".$controller."\r\n";
        echo "table ".$table."\r\n";
        echo "table foreign one ".$table_foreign_one."\r\n";
        echo "table foreign two ".$table_foreign_two."\r\n";
    }
}

?>