<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'taken';

$conn = mysqli_connect($host, $user, $pass, $db);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>attendance signer</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>

<body>

    <h1>Vous avez bien signé</h1><br>
    
    <?php
    // date("d/m/y");
    echo "Vous avez signez pour aujourd'hui " . date("l /d /m /y ");
    // echo  "aujourd'hui c'est " . date("l") . "<br>";
    echo " à " . date("H:i:s");
    ?>

    <a class="btn btn-success btn-sm" id="register" href="dash_etud.php"> OK</a>

    <?php
    $email = $_SESSION["email"];
    $sql = mysqli_query($conn, "select id, username, password from users where email='$email'");
    $row = mysqli_fetch_assoc($sql);
    $id = $row["id"];
    $kkcz = $row["password"];
    $_SESSION["user_id"] = $id;
    $_SESSION["kkcz"] = $kkcz;

    $inserer = "INSERT INTO attendance(student_id, student_name)VALUES('".$row["id"]."', '".$row["username"]."')";
    mysqli_query($conn, $inserer);

    mysqli_close($conn);
    
    ?>

</body>

</html>