<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'zougroustd';
$user_id = $_SESSION["user_id"];
$conn = mysqli_connect($host, $user, $pass, $db);

$req = "select  case when mois=1 then CONCAT('Janavier-',ANNEE)
              when mois=2 then CONCAT('Fevrier-',ANNEE)
			  when mois=3 then CONCAT('Mars-',ANNEE)
			  when mois=4 then CONCAT('Avril-',ANNEE)
			  when mois=5 then CONCAT('Mai-',ANNEE)
			  when mois=6 then CONCAT('Juin-',ANNEE)
			  when mois=7 then CONCAT('Juillet-',ANNEE)
			  when mois=8 then CONCAT('Aout-',ANNEE)
			  when mois=9 then CONCAT('Septembre-',ANNEE)
			  when mois=10 then CONCAT('Octobre-',ANNEE)
			  when mois=11 then CONCAT('Novembre-',ANNEE)
			  when mois=12 then CONCAT('Decembre-',ANNEE) end MOIS_NOM,
			  nonbre from(
 SELECT YEAR (attendance_date) ANNEE,MONTH (attendance_date)  mois ,COUNT(id) nonbre 
 FROM `attendance` WHERE student_id = '$user_id' AND attendance_statut = 'present' GROUP BY  MONTH (attendance_date),YEAR (attendance_date)
 ) as t";

if ($result = $conn->query($req)) {
    $graph = array();
    while ($row = $result->fetch_row()) {
        array_push($graph, array("y" => $row[1], "label" => $row[0]));
    }
}
$dataPoints = $graph;


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

    <!-- <title>Dashbord Etudiant</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <!-- script pour graphe -->
    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Nombre de Signatures par Mois"
                },
                axisX: {
                    title: "mois",

                },
                axisY: {
                    title: "Nombres de signature",

                },
                data: [{
                    type: "spline",
                    markerSize: 2,

                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
</head>

<body>
    <div class="container">
        <table>
            <tbody>
                <tr>
                    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                </tr>
            </tbody>
        </table>
    </div>
    <br>
    <br>




    <a href="student_dash.php">Retour</a>

    <!-- signature -->


</body>

</html>