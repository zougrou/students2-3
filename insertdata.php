<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'zougroustd';

$conn = mysqli_connect($host, $user, $pass, $db);

if( isset($_POST['submit_form']) )
{
    
    $name = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['useremail']);
    $phone = htmlspecialchars($_POST['userphone']);
    $password = htmlspecialchars($_POST['userpass']);

    $insert = mysqli_query($conn, "INSERT users (username,phone, email, password ,student_image)
     VALUES ('$name','$phone','$email','$password', '$path')");

    if($insert){echo "enregistrer";}
    else{echo "erreur". $insert . "<br>" . mysqli_error($conn);}

    mysqli_close($conn);

}
?>
  
  