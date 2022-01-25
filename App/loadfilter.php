<?php

{

    $index = 0;
    $file = fopen('daten.csv', 'r');
    
    while(! feof($file))
    {
        $array[$index] = fgetcsv($file); // Speichert CSV-Zeile in Array
        $index++;
    }

 #$response =array($f_name,$f_email,$f_username);
}
   echo json_encode($array);
exit;
?>