<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class ModelHalamanMenu extends CI_model{
        private $table = 'halaman_menu';
        private $table_akses = 'hak_akses_menu';

        public function byId($menuId){
            return $this->db->get_where($this->table, array('menu_id' => $menuId));
        }

        public function byUrl($url){
            return $this->db->get_where($this->table, array('url_menu' => $url));
        }

        public function byNama($nama, $admin_grup){
            $this->db->join($this->table_akses, $this->table_akses.'.halaman_menu = '.$this->table.'.menu_id and '.$this->table_akses.'.pengguna_grup = '.$admin_grup, 'left');
            $this->db->or_like('url_menu', $nama.'/');
            $this->db->order_by('menu_id','asc');
            return $this->db->get($this->table);
        }

        public function deletePeta($adminGrup){
            return $this->db->delete($this->table_akses, array('pengguna_grup' => $adminGrup));
        }

        public function byPeta($adminGrup, $aktifMenu){
            $this->db->select('pengguna_grup, halaman_menu, menu_id, judul_menu, sub_judul_menu, url_menu, icon_menu, aktif_menu');
            if($aktifMenu == 'ya'){
                $this->db->select('COUNT(*) AS hitungMenu');
                $this->db->select("GROUP_CONCAT(CONCAT(icon_menu,'_',url_menu,'_',sub_judul_menu) SEPARATOR ';') AS tampilkanMenu");
                $this->db->select('GROUP_CONCAT(icon_menu) AS tampilkanIcon');
                $this->db->select('GROUP_CONCAT(url_menu) AS tampilkanUrl');
                $this->db->group_by(array('judul_menu'));
            }
            $this->db->join($this->table, $this->table.'.menu_id = '.$this->table_akses.'.halaman_menu');
            $this->db->where(array('pengguna_grup' => $adminGrup, 'aktif_menu' => $aktifMenu));
            return $this->db->get($this->table_akses);
        }

        public function byPetaHalaman($adminGrup, $halaman){
            return $this->db->get_where($this->table_akses, array('pengguna_grup' => $adminGrup, 'halaman_menu' => $halaman));
        }

        public function deleteById($idMenu){
            return $this->db->delete($this->table, array('menu_id' => $idMenu));
        }

        public function countMenu($value){
            if($value){
                $this->db->or_like('judul_menu', $value);
                $this->db->or_like('sub_judul_menu', $value);
                $this->db->or_like('url_menu', $value);
                $this->db->or_like('icon_menu', $value);
                $this->db->or_like('aktif_menu', $value);
            }
            $this->db->from($this->table);
            return  $this->db->count_all_results();
        }

        public function listMenu($value, $start, $length, $column, $sort){
            if($value){
                $this->db->or_like('judul_menu', $value);
                $this->db->or_like('sub_judul_menu', $value);
                $this->db->or_like('url_menu', $value);
                $this->db->or_like('icon_menu', $value);
                $this->db->or_like('aktif_menu', $value);
            }
            if($column == 0){
                $this->db->order_by('menu_id', $sort);
            }else if($column == 1){
                $this->db->order_by('judul_menu', $sort);
            }else if($column == 2){
                $this->db->order_by('url_menu', $sort);
            }else if($column == 3){
                $this->db->order_by('icon_menu', $sort);
            }else if($column == 4){
                $this->db->order_by('aktif_menu', $sort);
            }

            
            if($start){
                $this->db->select('*');
                $this->db->from($this->table);
                return $this->db->limit($length, $start)->get();
            }else{
                $this->db->select('*');
                $this->db->from($this->table);
                return $this->db->limit($length)->get();
            }
        }
    }

?>