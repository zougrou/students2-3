<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'zougroustd';
$user_id = $_SESSION["user_id"];
$conn = mysqli_connect($host, $user, $pass, $db);

// $req = "select  case when mois=1 then CONCAT('Janavier-',ANNEE)
//               when mois=2 then CONCAT('Fevrier-',ANNEE)
// 			  when mois=3 then CONCAT('Mars-',ANNEE)
// 			  when mois=4 then CONCAT('Avril-',ANNEE)
// 			  when mois=5 then CONCAT('Mai-',ANNEE)
// 			  when mois=6 then CONCAT('Juin-',ANNEE)
// 			  when mois=7 then CONCAT('Juillet-',ANNEE)
// 			  when mois=8 then CONCAT('Aout-',ANNEE)
// 			  when mois=9 then CONCAT('Septembre-',ANNEE)
// 			  when mois=10 then CONCAT('Octobre-',ANNEE)
// 			  when mois=11 then CONCAT('Novembre-',ANNEE)
// 			  when mois=12 then CONCAT('Decembre-',ANNEE) end MOIS_NOM,
// 			  nonbre from(
//  SELECT YEAR (attendance_date) ANNEE,MONTH (attendance_date)  mois ,COUNT(id) nonbre 
//  FROM `attendance` WHERE student_id = '$user_id' AND attendance_statut = 'present' GROUP BY  MONTH (attendance_date),YEAR (attendance_date)
//  ) as t";

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body>

  

    <!-- signature -->
    <?php
    $sql = "SELECT attendance_date, time_ed
    FROM attendance WHERE student_id = $user_id AND attendance_statut = 'present'";
    $result = mysqli_query($conn, $sql);

    ?>

    <div class="container">
        <div class="demo-content">
            <h2 class="title_with_link"><b>Date Des Presences</b></h2>

            <?php if (!empty($result)) { ?>
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"><span>Date</span></th>
                            <th scope="col"><span>time</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                                <td scope="row"><?php echo $row["attendance_date"]; ?></td>
                                <td scope="row"><?php echo $row["time_ed"]; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    <tbody>
                </table>
            <?php } ?>
        </div>
    </div>

    <br>
    <br>
<a href="student_dash.php">Retour</a>

    <!-- fin signature -->

</body>

</html>