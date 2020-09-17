<?php

// reference the Spreadsheet namespace
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelGenerator{
    public function generate($header, $content, $filename, $creator=""){
        
        $ci =& get_instance();
        
        //  Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        //Set document properties
        $spreadsheet->getProperties()->setCreator($creator)
            ->setLastModifiedBy('Arif Suwadji');

        // create sheet object
        $sheet = $spreadsheet->getActiveSheet();

        //set address
        $addres = array();
        foreach(range('a','z') as $v){
            array_push($addres, $v);
        }

        //header title
        $i = 1;
        $cell = $addres[0];
        $numberCell = 1;
        $sheet->setCellValue($cell.$numberCell, 'No');
        foreach($header as $title){
            $langField = str_replace('_',' ', $title);
            $langField = ucwords($langField);
            $cell = $addres[$i];
            $numberCell = 1;
            $sheet->setCellValue($cell.$numberCell, $langField);
            $i++;
        }

        //content value
        $i = 1;
        foreach($content as $key => $value){
            $numberCell = $i+1;
            $n = 1;
            $cell = $addres[0];
            $sheet->setCellValue($cell.$numberCell, $i);
            foreach($header as $title){
                $cell = $addres[$n];
                $sheet->setCellValue($cell.$numberCell, $value[$title]);
                $n++;
            }
            $i++;
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle($creator);

        //download - write file
        $writer = new Xlsx($spreadsheet);
        $writer->save('download/'.$filename);

        //download file
        header("Location: ".base_url().'download/'.$filename);
        $filepath = FCPATH."download/" . $filename;
        $ci->session->userdata['adminEkta']['fileExcel'] = $filepath;
        exit;
    }
}
?>