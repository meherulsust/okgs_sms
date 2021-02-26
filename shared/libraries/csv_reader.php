<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
* CSVReader Class
*
* $Id: csvreader.php 147 2007-07-09 23:12:45Z Pierre-Jean $
*
* Allows to retrieve a CSV file content as a two dimensional array.
* The first text line shall contains the column names.
*
* @author        Pierre-Jean Turpeau
* @link        http://www.codeigniter.com/wiki/CSVReader
*/
class Csv_reader {
    
    function parse_file($file_path, $questions)
    {
        $row = 0;
        if (($handle = fopen($file_path, "r")) !== FALSE)
        {
            while (($data = fgetcsv($handle, "", ",")) !== FALSE)
            {
                if($row == 0)
                {
                    foreach ($questions as $key => $value)
                    {
                        foreach($data as $d_key => $d_value)
                        {
                            if($data[$d_key] == $value)
                            {
                                $q_location[$value] = $d_key;
                            }
                        }
                    }
                }
                else
                {
                    foreach ($questions as $key => $value)
                    {
                        $new_row = $row -1;
                        $final_array[$new_row][$value] = $data[$q_location[$value]];
                    }
                }
 
                $row++;
            }
            fclose($handle);
        }
        return $final_array;
 
    }
}


?>