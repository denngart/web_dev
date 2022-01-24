<?php
include "config.php";
#$query = "select * from users WHERE  name LIKE '%".$_GET['username']."%' OR username LIKE '%".$_GET['name']."%";



if(isset($_GET['username']))
{
   $condition = "name LIKE '%".$_GET['name']."%' AND email LIKE '%".$_GET['email']."%'AND username Like '%".$_GET['username']."%'";

   $userData = mysqli_query($con,"select * from users WHERE ".$condition);
}
#elseif(isset($GET['load']))

else
{
   $userData = mysqli_query($con,"select * from users");
  
}

$response = array();

while($row = mysqli_fetch_assoc($userData)){
   
   $response[] = $row;

}

echo json_encode($response);

exit;