<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'zougroustd';

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
    echo "Vous avez signé pour aujourd'hui " . date("l /d /m /y ");
    // echo  "aujourd'hui c'est " . date("l") . "<br>";
    echo " à " . date("H:i:s");
    ?>

    <a class="btn btn-success btn-sm" id="register" href="student_dash.php"> OK</a>




    <?php
    $email = $_SESSION["email"];
    $sql = mysqli_query($conn, "select * from users where email='$email'");
    $row = mysqli_fetch_assoc($sql);
    $id = $row["id"];
    $name = $row["username"];
    $kkcz = $row["password"];
    $date = date("Y-m-d");
    $_SESSION["user_id"] = $id;
    $_SESSION["kkcz"] = $kkcz;

    // le script qui permet de signer une fois

    $date = date("Y-m-d");
    

    $verif = mysqli_query($conn, "SELECT student_id, attendance_date, attendance_statut, course_status FROM attendance WHERE student_id='$id' AND attendance_date='$date'");
    if (mysqli_num_rows($verif) == 0) {
        echo "<script>alert(\"le cours n'a pas encor debuté\")</script>"; 
    }
    else{
        $row_verif= mysqli_fetch_assoc($verif);
        $course_status = $row_verif["course_status"];
    
        $statut = $row_verif["attendance_statut"];
        if ($course_status == 1) {
            echo "<script>alert(\"le cours est fini\")</script>";
        } else {
            if (mysqli_num_rows($verif) == 1 && $statut != 'present') {
                $insertion = "UPDATE attendance SET student_name='$name', attendance_statut='present' WHERE student_id= '$id' AND attendance_date='$date'";
                mysqli_query($conn, $insertion);
                echo "<script>alert(\"Vous avez bien signé\")</script>";
            } else {
                if (mysqli_num_rows($verif) == 0) {
                    echo "<script>alert(\"le cours n'a pas encor debuté\")</script>";
                } else {
                    echo "<script>alert(\"Vous avez deja signé\")</script>";
                }
            }
        }
    }
    
    ?>

</body>

</html>