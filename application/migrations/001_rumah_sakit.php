<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_create_table_rumah_sakit
 *
 * @property CI_DB_forge         $dbforge
 * @property CI_DB_query_builder $db
 */

class Migration_rumah_sakit extends CI_Migration {
    private $table = 'rumah_sakit';

    public function up(){
        $this->dbforge->add_field("rs_id INT UNSIGNED NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("nama_rs VARCHAR(100)");
        $this->dbforge->add_field("alamat_rs TEXT");
        $this->dbforge->add_field("PRIMARY KEY(rs_id)");
        $this->dbforge->create_table($this->table);
        echo "create table $this->table\n";
    }

    public function down(){
        $this->dbforge->drop_table($this->table);
    }
}