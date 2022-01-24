<?php
include "config.php";
#$query = "select * from users WHERE  name LIKE '%".$_GET['username']."%' OR username LIKE '%".$_GET['name']."%";



if(isset($_GET['username']))
{
   $condition = "name LIKE '%".$_GET['name']."%' AND email LIKE '%".$_GET['email']."%'AND username Like '%".$_GET['username']."%'";

   $userData = mysqli_query($con,"select * from users WHERE ".$condition);
   $filterfile = fopen("filter.txt","w");
   fwrite($filterfile,$_GET['name']."\n".$_GET['email']."\n".$_GET['username']);
   fclose($filterfile);
   $response = array();

while($row = mysqli_fetch_assoc($userData)){
   
   $response[] = $row;

}
}    
elseif(isset($GET['load']))
{
   $filterfile = fopen("filter.txt","r");
   $f_name =fgets($filterfile);
   $f_username =fgets($filterfile);
   $f_email=fgets($filterfile);
   fread();
   fclose($filterfile);
   $response = array();
   $response[f_name] = $f_name;
   $response[f_username] = $f_username;
   $response[f_email] = $f_email;  
   }

#elseif(isset($_GET['load']))



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