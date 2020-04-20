<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ModelPengguna extends CI_model{
        private $table = 'pengguna';
        private $table_grup = 'pengguna_grup';

        public function idAdmin($idAdmin){
            return $this->db->get_where($this->table, array('pengguna_id' => $idAdmin));
        }

        public function byUserPassword($user, $password){
            return $this->db->get_where($this->table, array('username' => $user, 'password' => $password));
        }

        public function byEmailPassword($email, $password){
            return $this->db->get_where($this->table, array('email' => $email, 'password' => $password));
        }

        public function idGrup($idGrup){
            return $this->db->get_where($this->table_grup, array('grup_id' => $idGrup));
        }

        public function dataByKonselor(){
            $this->db->where(array("pengguna_grup" => 2, 'konselor' => 0));
            $this->db->order_by("pengguna_id","asc");
            return $this->db->get($this->table);
        }

        public function dataByKonselorSelected($idKonselor){
            $this->db->where(array("konselor" => $idKonselor, "pengguna_grup" => 2));
            $this->db->order_by("pengguna_id","asc");
            return $this->db->get($this->table);
        }

        function dataGrup(){
            $this->db->order_by("grup_id","asc");
            return $this->db->get($this->table_grup);
        }

        function hapusData($penggunaId){
            return $this->db->delete($this->table, array('pengguna_id' => $penggunaId));
        }

        function hapusDataGrup($idGrup){
            return $this->db->delete($this->table_grup, array('grup_id' => $idGrup));
        }

        function countAdmin($value){
            if($value){
                $this->db->or_like('nama_pengguna', $value);
                $this->db->or_like('nama_grup', $value);
            }
            $this->db->from($this->table);
            $this->db->join($this->table_grup, $this->table.'.pengguna_grup = '.$this->table_grup.'.grup_id');
            return  $this->db->count_all_results();
        }

        function listAdmin($value, $start, $length, $column, $sort){
            if($value){
                $this->db->or_like('nama_pengguna', $value);
                $this->db->or_like('nama_grup', $value);
            }
            if($column == 0){
                $this->db->order_by('pengguna_id', $sort);
            }else if($column == 1){
                $this->db->order_by('nama_pengguna', $sort);
            }else if($column == 2){
                $this->db->order_by('nama_grup', $sort);
            }
            
            if($start){
                $this->db->select('*');
                $this->db->from($this->table);
                $this->db->join($this->table_grup, $this->table.'.pengguna_grup = '.$this->table_grup.'.grup_id');
                return $this->db->limit($length, $start)->get();
            }else{
                $this->db->select('*');
                $this->db->from($this->table);
                $this->db->join($this->table_grup, $this->table.'.pengguna_grup = '.$this->table_grup.'.grup_id');
                return $this->db->limit($length)->get();
            }
        }

        function countAdminGrup($value){
            if($value){
                $this->db->or_like('nama_grup', $value);
            }
            $this->db->from($this->table_grup);
            return  $this->db->count_all_results();
        }

        function listAdminGrup($value, $start, $length, $column, $sort){
            if($value){
                $this->db->or_like('nama_grup', $value);
            }
            if($column == 0){
                $this->db->order_by('grup_id', $sort);
            }else if($column == 1){
                $this->db->order_by('nama_grup', $sort);
            }
            
            if($start){
                $this->db->from($this->table_grup);
                return $this->db->limit($length, $start)->get();
            }else{
                $this->db->from($this->table_grup);
                return $this->db->limit($length)->get();
            }
        }

    }

?>