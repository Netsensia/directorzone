<?php
namespace Netsensia\Library\Csv;

class Csv
{
    public static function read($filepath)
    {
        ini_set("auto_detect_line_endings", true);
    
        $file = new \SplFileInfo($filepath);
         
        $fileHandle = $file->openFile();
    
        $headers = $fileHandle->fgetcsv();
    
        $rows = [];
    
        while (!$fileHandle->eof()) {
    
            $fields = [];
            $fieldNumber = 0;
    
            $array = $fileHandle->fgetcsv();
    
            foreach ($array as $dataItem) {
                $fieldName = trim(strtolower($headers[$fieldNumber++]));
                $fieldName = str_replace('-', '', $fieldName);
                $fieldName = str_replace(' ', '', $fieldName);
                $fields[$fieldName] = $dataItem;
            }
    
            if (count($array) > 2) {
                $rows[] = $fields;
            }
        }
    
        return $rows;
    }
}
