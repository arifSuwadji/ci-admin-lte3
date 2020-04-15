<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Migration class
 * hanya bisa di akses saat development mode
 * tidak perlu ada perubahan di file ini
 * 
 * php index.php migrate status
 * php index.php migrate version 1
 * 
 * @author Arif Suwadji <arifsuwadji@gmail.com> 2020/04
 */
class Migrate extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('migration');
        if(ENVIRONMENT!="development"){
            exit("Development Only");
        }
    }

    /**
     * Get list file migration & version
     * @return void
     */
    private function list()
    {
        echo "List Migration => \r\n\r\n";
        $lists=$this->migration->find_migrations();
        foreach ($lists as $klist => $list) {
            echo "$klist = $list\r\n";
        }
        
    }

    /**
     * Get current version + call list function
     * @return void
     */
    public function status(){
        $version=$this->db->get('migrations')->row()->version;
        echo "Current Version => ".$version."\r\n";
        $this->list();
    }

    /**
     * migrate by version
     * @param int $version - wanted version 
     * @param mixed $reset - input any except 0 for reset before migrate 
     * @return void
     */
    public function version($version,$reset=0)
    {
        $currentVersion=$this->db->get('migrations')->row()->version;
        echo "Current Version => ".$version."\r\n";
        echo "Version => ".$version."\r\n";
      
        if($reset!==0){
            $this->migration->version(0);

        }else {
            if($currentVersion==$version){
                echo "versi sekarang dan versi yg akan di migrasi sama, tidak ada yg berubah, gunakan\r\nphp index.php migrate version $version reset\r\n";
            }
        }
        if ($this->migration->version($version) === FALSE)
        {
                show_error($this->migration->error_string());
        }
        
    }
}