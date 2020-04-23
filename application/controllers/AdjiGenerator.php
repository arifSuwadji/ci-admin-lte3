<?php

class AdjiGenerator extends CI_Controller {
    private $buttonTambah = '';
    private $buttonTambahAksi = '';
    private $buttonEdit = '';
    private $buttonEditAksi = '';
    private $buttonHapus = '';
    private $buttonPdf = '';
    private $buttonExcel = '';
    
    public function __construct(){
        parent::__construct();
    }

    public function help(){
        $result = "Adji Generator commands\r\n";
        $result .= "php index.php AdjiGenerator crud ControllerName table_Name \r\n";
        $result .= "php index.php AdjiGenerator crud_foreignkey ControllerName table_Name table_foreign_one table_foreign_two \r\n";
        $result .= "php index.php AdjiGenerator restApi ControllerName table_Name \r\n";
        $result .= "php index.php AdjiGenerator restApi_foreignkey ControllerName table_Name table_foreign_one table_foreing_two \r\n";

        echo $result. PHP_EOL;
    }

    public function crud($controller="", $table=""){
        //load controller
        $admin_controller = admin_controller($controller, $table, $this->buttonTambah, $this->buttonTambahAksi, $this->buttonEdit, $this->buttonEditAksi, $this->buttonHapus, $this->buttonPdf, $this->buttonExcel);

        //load template index
        template_index($controller, $table, $admin_controller['buttonTambah'], $admin_controller['buttonTambahAksi'], $admin_controller['buttonEdit'], $admin_controller['buttonEditAksi'], $admin_controller['buttonHapus'], $admin_controller['buttonPdf'], $admin_controller['buttonExcel']);

        //load template tambah
        template_tambah($controller, $table, $admin_controller['buttonTambah'], $admin_controller['buttonTambahAksi'], $admin_controller['buttonEdit'], $admin_controller['buttonEditAksi'], $admin_controller['buttonHapus']);

        //load template edit
        template_edit($controller, $table, $admin_controller['buttonTambah'], $admin_controller['buttonTambahAksi'], $admin_controller['buttonEdit'], $admin_controller['buttonEditAksi'], $admin_controller['buttonHapus']);

        //load template pdf
        template_pdf($controller, $table);

        //load models
        model_generator($controller, $table);

        //load js
        js_generator($controller, $table, $admin_controller['buttonTambah'], $admin_controller['buttonTambahAksi'], $admin_controller['buttonEdit'], $admin_controller['buttonEditAksi'], $admin_controller['buttonHapus']);
        
        echo "Class ".$controller."\r\n";
        echo "table ".$table."\r\n";
    }

    public function crud_foreignkey ($controller="", $table="", $table_foreignkey_one="", $table_foreignkey_two=""){
        //load controller
        $admin_controller = admin_foreignkey_controller($controller, $table, $table_foreignkey_one, $table_foreignkey_two, $this->buttonTambah, $this->buttonTambahAksi, $this->buttonEdit, $this->buttonEditAksi, $this->buttonHapus, $this->buttonPdf, $this->buttonExcel);

        //load template index
        template_foreignkey_index($controller, $table, $table_foreignkey_one, $table_foreignkey_two, $admin_controller['buttonTambah'], $admin_controller['buttonTambahAksi'], $admin_controller['buttonEdit'], $admin_controller['buttonEditAksi'], $admin_controller['buttonHapus'], $admin_controller['buttonPdf'], $admin_controller['buttonExcel']);

        //load template tambah
        template_foreignkey_tambah($controller, $table, $table_foreignkey_one, $table_foreignkey_two, $admin_controller['buttonTambah'], $admin_controller['buttonTambahAksi'], $admin_controller['buttonEdit'], $admin_controller['buttonEditAksi'], $admin_controller['buttonHapus']);

        //load template edit
        template_foreignkey_edit($controller, $table, $table_foreignkey_one, $table_foreignkey_two, $admin_controller['buttonTambah'], $admin_controller['buttonTambahAksi'], $admin_controller['buttonEdit'], $admin_controller['buttonEditAksi'], $admin_controller['buttonHapus']);

        //load template pdf
        template_foreignkey_pdf($controller, $table);
        
        //load models
        model_foreignkey_generator($controller, $table, $table_foreignkey_one, $table_foreignkey_two);

        //load js
        js_foreignkey_generator($controller, $table, $admin_controller['buttonTambah'], $admin_controller['buttonTambahAksi'], $admin_controller['buttonEdit'], $admin_controller['buttonEditAksi'], $admin_controller['buttonHapus']);

        echo "Class ".$controller."\r\n";
        echo "table ".$table."\r\n";
        echo "table foreign one ".$table_foreignkey_one."\r\n";
        echo "table foreign two ".$table_foreignkey_two."\r\n";
    }

    public function restApi ($controller="", $table=""){
        //load api controller
        $api_controller = api_controller($controller, $table);

        echo "RestAPI ".$controller."\r\n";
        echo "table ".$table."\r\n";
    }

    public function restApi_foreignkey ($controller="", $table="", $table_foreignkey_one="", $table_foreignkey_two=""){
        //load api controller
        $api_controller = api_foreignkey_controller($controller, $table, $table_foreignkey_one, $table_foreignkey_two);

        echo "RestAPI ".$controller."\r\n";
        echo "table ".$table."\r\n";
    }
}

?>