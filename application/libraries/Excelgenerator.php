<?php

// reference the Spreadsheet namespace
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelGenerator{
    public function generate($header, $content, $filename, $creator=""){
        // instantiate and use the Spreadsheet class
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getProperties()->setCreator($creator);

        // Output the generated Xlsx
        $sheet = $spreadsheet->getActiveSheet();

        //set address
        $addres = array();
        foreach(range('a','z') as $v){
            array_push($addres, $v);
        }

        //header title
        $i = 0;
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
            foreach($header as $title){
                $cell = $addres[$n-1];
                $sheet->setCellValue($cell.$numberCell, $value[$title]);
                $n++;
            }
            $i++;
        }

        //download file
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $filename . "");
        header("Content-Transfer-Encoding: binary ");

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
?>