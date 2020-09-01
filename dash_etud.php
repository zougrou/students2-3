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

    <?php
    $email = $_SESSION["email"];
    $sql = mysqli_query($conn, "select id, username, phone, email, sex, file_name, uploaded_on from users where email='$email'");
    $row = mysqli_fetch_assoc($sql);
    $id = $row["id"];
    $username = $row["username"];
    $phone = $row["phone"];
    $email = $row["email"];
    $sex = $row["sex"];
    $file_name = $row["file_name"];
    // $uploaded = $row["uploaded"];



    ?>
    <table style="width:1000px" class="center">
        <tr>
            <td style="width:200px"><a href="chang.php">Change password</a></td>
            <td style="width:700px"></td>
            <td style="width:100px"><a href="logout.php">Logout</a></td>
        </tr>
    </table>
    <br>
    <div>
        <p><a href="index.php">Accueil</a></p> <a href="profile.php">Profile</a>
    </div>

    <h1>Information Etudiant</h1>
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
                <table>
                    <tbody>
                        <tr>
                            <td><img src=<?php echo htmlspecialchars($file_name) ?> class="img-thumbnail" style="width:128px;height:128px;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <table>
                        <tbody>
                            <tr>
                                <td><b> Information </b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td style="width:200px">Email : </td>
                                <td><?php echo htmlspecialchars($email); ?></td>
                            </tr>
                            <tr>
                                <td style="width:200px">Contact : </td>
                                <td><?php echo htmlspecialchars($phone); ?></td>
                            </tr>
                            <tr>
                                <td style="height:15px"></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td> <b> Information General</b></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Nom : </td>
                                <td><?php echo htmlspecialchars($username); ?></td>
                            </tr>
                            <tr>
                                <td>Sex : </td>
                                <td><?php echo htmlspecialchars($sex); ?></td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>

    <table>
        <tbody>
            <tr>
                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
            </tr>
        </tbody>
    </table>


    <!-- signature -->
    <?php
    $sql = "SELECT attendance_date, time_ed
FROM attendance WHERE student_id = $user_id AND attendance_statut = 'present'";
    $result = mysqli_query($conn, $sql);

    ?>

    <div class="container">
        <div class="demo-content">
            <h2 class="title_with_link"><b>Date des signatures</b></h2>

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
    <br>
    <br>


    <!-- fin signature -->

</body>

</html>