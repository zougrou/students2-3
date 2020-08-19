<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'taken';

$conn = mysqli_connect($host, $user, $pass, $db);

   $christ = htmlspecialchars($_POST['christ']);
   $password1 = htmlspecialchars($_POST['password1']);
   $password2 = htmlspecialchars($_POST['password2']);

    // Insertion des données dans la base de données 
    
   $code = $_SESSION["user_id"];
    $update = mysqli_query($conn, "update users set `password` = '$password1' where id = '$code'");
if ($update) {
    $status = 'success';
    $_SESSION["kkcz"]= $password1;
    header('Location: dash_etud.php');
} else {
    echo  'Echec modification, Veuillez reprendre.';
}

                            
    mysqli_close($conn);
?>
