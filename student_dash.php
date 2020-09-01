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
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="teacher/css/styles.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
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

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- <a class="navbar-brand" href="index.html">Start Bootstrap</a><button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button -->
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0"></form>
        <!-- Navbar-->
        <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="profil.php">Modifier Profil</a>
                    <a class="dropdown-item" href="abscent.php">Status</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="student_dash.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseAuth" aria-expanded="false" aria-controls="pagesCollapseAuth">Authentication
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                                <div class="collapse" id="pagesCollapseAuth" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="login.html">Login</a><a class="nav-link" href="register.html">Register</a><a class="nav-link" href="password.html">Forgot Password</a></nav>
                                </div>
                                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pagesCollapseError" aria-expanded="false" aria-controls="pagesCollapseError">Error
                                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div></a>
                                <div class="collapse" id="pagesCollapseError" aria-labelledby="headingOne" data-parent="#sidenavAccordionPages">
                                    <nav class="sb-sidenav-menu-nested nav"><a class="nav-link" href="401.html">401 Page</a><a class="nav-link" href="404.html">404 Page</a><a class="nav-link" href="500.html">500 Page</a></nav>
                                </div>
                            </nav>
                        </div>
                        <div class="sb-sidenav-menu-heading">Addons</div>
                        <a class="nav-link" href="charts.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Charts
                        </a><a class="nav-link" href="present.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Present
                        </a>
                        <a class="nav-link" href="abscent.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Abscent
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">@Nom:</div>
                    Kouassi koffi christ zougrou
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <!-- premier container -->
            <main>
                <div class="container-fluid">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard Student</li>
                    </ol>
                </div>

                <!-- inclu body dash_etud.php -->


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

                <!-- donner sur l'etudiant -->
                <h1>Information Etudiant</h1>
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row no-gutters">
                        <div class="col-md-4">
                            <table>
                                <tbody>
                                    <tr>
                                        <td><img src=<?php echo htmlspecialchars($file_name) ?> class="img-thumbnail" style="width:200px;height:210px;"></td>
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
                <!-- fin -->
                <br>
                <br>
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


                <!-- date de signature -->
                <?php
                $sql = "SELECT attendance_date, time_ed, attendance_statut
                FROM attendance WHERE student_id = $user_id";
                $result = mysqli_query($conn, $sql);

                ?>

                <div class="container">
                    <div class="demo-content">
                        <h2 class="title_with_link"><b>Date Absence/Presence</b></h2>

                        <?php if (!empty($result)) { ?>
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col"><span>Date</span></th>
                                        <th scope="col"><span>statut</span></th>
                                        <th scope="col"><span>time</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_array($result)) {
                                    ?>
                                        <tr>
                                            <td scope="row"><?php echo $row["attendance_date"]; ?></td>
                                            <td scope="row"><?php echo $row["attendance_statut"]; ?></td>
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
                <!-- <a href="status.php">status</a> -->
                <!-- fin signature -->

                <!-- fin inclu -->

            </main>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

</body>

</html>