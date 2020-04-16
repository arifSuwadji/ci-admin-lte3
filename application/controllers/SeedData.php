<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 * php index.php SeedData help
 * 
 * @author Arif Suwadji <arifsuwadji@gmail.com> 2020/04
 */
class SeedData extends CI_Controller {

    public $seeder;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Database/seeder');
        $this->seeder = new Seeder();
        if(ENVIRONMENT!="development"){
            exit("Development Only");
        }
    }

    public function help(){
        $result = "Seed Data commands\r\n";
        $result .= "php index.php SeedData create \"file_name\"              Run the specified seed file.\n";
        echo $result. PHP_EOL;
    }

    public function create($name){
        $this->seeder->call($name);
    }
}