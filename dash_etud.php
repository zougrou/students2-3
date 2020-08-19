<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'taken';
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
 FROM `attendance` WHERE student_id = '$user_id' GROUP BY  MONTH (attendance_date),YEAR (attendance_date)
 ) as t";
//  chercher les informations ligne par ligne
// $resultat = mysqli_query($conn, $req);
if ($result = $conn->query($req)) {
    //     // $graph = array();
    // $graph = "array(";
    //     $row_cnt = $result->num_rows;
    //     $i = 0;
    //     while ($row = $result->fetch_row()) {
    //          $graph .= 'array("y" => '.$row[1].', "label" => '.$row[0].')';
    //          $i = $i+1;
    //          if($i != $row_cnt){
    //              $graph .= ',';
    //          }
    //          else{
    //              if ($i == $row_cnt) {
    //                  $graph .= ')';
    //              }
    //          }
    // //         // printf("%s (%s)\n", $row[0], $row[1]);            
    // //         // array_push($graph, array("x" => $row[0], "y" => $row[1]));
    //     }
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashbord Etudiant</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- script pour graphe -->
    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Company Revenue by Year"
                },
                axisX: {
                    title: "mois",
                    // valueFormatString: "#0,,.",
                    // suffix: "mn",
                    // prefix: "$"
                },
                axisY: {
                    title: "Nombres de signature",
                    // valueFormatString: "#0,,.",
                    // suffix: "mn",
                    // prefix: "$"
                },
                data: [{
                    type: "spline",
                    markerSize: 2,
                    // xValueFormatString: "YYYY",
                    // yValueFormatString: "$#,##0.##",
                    //  xValueType: "string",
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



    // $inserer = "INSERT INTO attendance(student_id, student_name)VALUES('" . $row["id"] . "', '" . $row["username"] . "')";
    // mysqli_query($conn, $inserer);

    //         $req= "select  case when mois=1 then CONCAT('Janavier-',ANNEE)
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
    //  FROM `attendance` WHERE student_id = '$id' GROUP BY  MONTH (attendance_date),YEAR (attendance_date)
    //  ) as t";
    // //  chercher les informations ligne par ligne
    //  $resultat = mysqli_query($conn, $req);
    //         if ($result = $conn->query($req)) {
    //             $graph = array();
    //             while ($row = $result->fetch_row()) {
    //                 // printf("%s (%s)\n", $row[0], $row[1]);            
    //                 array_push($graph,array("x" => $row[0], "y" => $row[1]));
    //             }
    //         }

    // print_r($graph);



    ?>
    <table style="width:1000px" class="center">
        <tr>
            <td style="width:200px"><a href="chang.php">Change password</a></td>
            <td style="width:700px"></td>
            <td style="width:100px"><a href="">Logout</a></td>
        </tr>
    </table>
    <br>
    <div>
        <p><a href="index.php">Accueil</a></p>
    </div>

    <h1>Information Etudiant</h1>
    <table>
        <tbody>

            <tr>
                <td><img src=<?php echo htmlspecialchars($file_name) ?> class="img-thumbnail" style="width:128px;height:128px;"></td>
                <td style="width:200px"></td>

                <td>
                    <table class="unstyledTable">

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
            </tr>
    </table>
    </td>

    </tr>

    </tbody>
    </table>

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
FROM attendance WHERE student_id = $user_id";
    $result = mysqli_query($conn, $sql);


    ?>


    <div class="demo-content">
        <h2 class="title_with_link">Student attendance</h2>

        <?php if (!empty($result)) { ?>
            <table class="table-content">
                <thead>
                    <tr>

                        <th width="30%"><span>Date</span></th>
                        <th width="50%"><span>time</span></th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($result)) {
                    ?>
                        <tr>

                            <td><?php echo $row["attendance_date"]; ?></td>
                            <td><?php echo $row["time_ed"]; ?></td>

                        </tr>
                    <?php
                    }
                    ?>
                <tbody>
            </table>
        <?php } ?>

    </div>

<br>
<br>
<br>
<br>


    <!-- fin signature -->

</body>

</html>