<?php
include "config.php";

# Suche die Einträge nachdem Filter
if(isset($_GET['username']))
{
   $condition = "name LIKE '%".$_GET['name']."%' AND email LIKE '%".$_GET['email']."%'AND username Like '%".$_GET['username']."%'";
   $userData = mysqli_query($con,"select * from users WHERE ".$condition);
#Speichert die Letzte Suche in eine csv Datei, Datei wird beim nächsten Aufruf überschrieben
   $daten = array($_GET['username'], $_GET['name'], $_GET['email']);
   $fp = fopen('daten.csv', 'w');
   fputcsv($fp, $daten);
   fclose($fp);
   #Speichert Dateinbankeinträg in das Array response 
while($row = mysqli_fetch_assoc($userData)){
   
   $response[] = $row;

}
}
#Zeigt alle Einträge in der Datenbank an     
else
{
   $userData = mysqli_query($con,"select * from users");
   $response = array();

   while($row = mysqli_fetch_assoc($userData)){
      
      $response[] = $row;
   
   
   }
}

echo json_encode($response);

exit;
?>