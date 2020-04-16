<?php
class rumah_sakit extends Seeder {
    private $table = "rumah_sakit";

    public function run() {
        $this->db->truncate($this->table);

        //seed records array
        $dataArray = array(); 
        array_push($dataArray , array("nama_rumah_sakit" => "RS RSUP Dr. Mohammad Hoesin Palembang", 'alamat_rumah_sakit' => "Jl. Jendral Sudirman Km. 3,5 Palembang Telepon: (0711-354088), IGD (0711-315444) Fax: (0711-351318) Email: rsmhplg@yahoo.com"));
        array_push($dataArray , array("nama_rumah_sakit" => "RS Dr. Rivai Abdullah", 'alamat_rumah_sakit' => "Jl. Sungai Kundur Kelurahan Mariana Kec. Banyuasin I Telepon: (0711-7537201) Fax: (0711-7537204) Email: rsdr_rivaiabdullah@yahoo.co.id"));
        array_push($dataArray , array("nama_rumah_sakit" => "RSUD Lahat", 'alamat_rumah_sakit' => "Jl. Mayjend Harun Sohar II No.28 Lahat Telepon: (0731-323080) Fax: (0731-321785) Email: rsud_lahat@yahoo.co.id "));
        array_push($dataArray , array("nama_rumah_sakit" => "RSUD Siti Fatimah Provinsi Sumatera Selatan", 'alamat_rumah_sakit' => "Jl. Kol. H. Burlian Km 6 Kel. Sukabangun Kec. Sukarami, Palembang 30151 Telepon: (0711-5178883, 5718889) Fax: (0711-7421333) Email: rsudprovsumsel@gmail.com"));
        array_push($dataArray , array("nama_rumah_sakit" => "RSUD Kayuagung", 'alamat_rumah_sakit' => "Jln. Letjen Yusuf Singadekane Kel. Jua-jua Kec. Kayuagung Kab. Ogan Komering Ilir Telepon: (0712-323889) Email: rsud_kya@yahoo.com"));
        array_push($dataArray , array("nama_rumah_sakit" => "RS. Dokter Ibnu Sutowo Baturaja", 'alamat_rumah_sakit' => "Jl. Dr. M. Hatta No.1, Baturaja Lama, Kec. Baturaja Timur, Kabupaten Ogan Komering Ulu, Sumatera Selatan 32121"));
        array_push($dataArray , array("nama_rumah_sakit" => "Rumah Sakit Umum Daerah Palembang BARI", 'alamat_rumah_sakit' => "Jl. Panca Usaha No.1, 5 Ulu, Kecamatan Seberang Ulu I, Kota Palembang, Sumatera Selatan 30254"));
        array_push($dataArray , array("nama_rumah_sakit" => "RS Muhammadiyah Palembang", 'alamat_rumah_sakit' => "No.13, Jalan Jenderal A. Yani, 13 Ulu, Kec. Seberang Ulu II, Kota Palembang, Sumatera Selatan"));

        for($i=0; $i < count($dataArray); $i++){
            $dataInsert = array();
            foreach($dataArray[$i] as $key => $value){
                $dataInsert[$key] = $value;
            }
            $this->db->insert($this->table, $dataInsert);
        }
        echo "insert data ".$this->table.PHP_EOL;
    }
}
?>