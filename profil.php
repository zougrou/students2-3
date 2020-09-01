<?php
session_start();
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'zougroustd';
$user_id = $_SESSION["user_id"];
$conn = mysqli_connect($host, $user, $pass, $db);

$sql = mysqli_query($conn, "select username, phone, email, password, file_name, uploaded_on from users where id=$user_id");
$row = mysqli_fetch_assoc($sql);
$username = $row["username"];
$phone = $row["phone"];
$email = $row["email"];
$kkcz = $row["password"];
$file_name = $row["file_name"];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Attendance profile</title>
    <meta charset="utf-8">
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/css/bootstrap.min.css" integrity="sha384-VCmXjywReHh4PwowAiWNagnWcLhlEJLA5buUprzK8rxFgeH0kww/aWY76TfkUoSX" crossorigin="anonymous">

    <!-- JS, Popper.js, and jQuery -->

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!------ Include the above in your HEAD tag -------- -->
    <SCRIPT language="Javascript">
        function checkpass() {
            if (document.profile_form.password1.value != document.profile_form.password2.value) {
                window.alert("mots de passe non conforme");
            }
            //     else {
            //     //    function bien(){ok}
        }
    </SCRIPT>
</head>

<?php

$error_name = '';
$error_phone = '';
$error_email = '';
$error_image = '';
$error_pass = '';
$error = 0;
$success = '';

if (isset($_POST["button_action"])) {
    $name_new = $_POST["name"];
    $email_new = $_POST["email"];
    $phone_new = $_POST["phone"];
    $pass1_new = $_POST["password"];
    $pass2_new = $_POST["password1"];
    $Newpass = $kkcz;

    if ($kkcz != $pass1_new || $name_new == '' || $phone_new == '') {
        if ($name_new == '') {
            $error_name = 'le nom est requis';
        }
        if ($phone_new == '') {
            $error_phone = 'le numéro est requis';
        }
        if ($kkcz != $pass1_new) {
            $error_pass = 'mot de passe saisi est incorrect';
        }
    } else {
        if ($pass2_new != '') {
            $Newpass = $pass2_new;
        }

        if ($_FILES['file']['name']) {
            $FName = md5($_FILES['file']['name']);
            echo $_FILES['file']['name'];
            echo "je suis la";
            $NewFile = "images/" . $FName;
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $NewFile)) {
                die("Failed to move file " . $_FILES['file']['tmp_name'] . " to " . $FName);
            } else {
                $update = mysqli_query($conn, "UPDATE users SET username = '$name_new', phone = '$phone_new', email= '$email_new', password = '$Newpass' , file_name = '$NewFile' WHERE id='$user_id'");
            }
        } //si fichier n'existe pas
        else {
            $update = mysqli_query($conn, "UPDATE users SET username = '$name_new', phone = '$phone_new', email= '$email_new', password = '$Newpass' WHERE id='$user_id'");
        }
        $update = mysqli_query($conn, "UPDATE users SET username = '$name_new', phone = '$phone_new', email= '$email_new', password = '$Newpass' WHERE id='$user_id'");

        if ($update) {
            $status = 'success';
            header('Location: profil.php');
        } else {
            echo  'Echec modification, Veuillez reprendre.';
        }


        mysqli_close($conn);
    }
}




?>

<body>
<br>
    <a href="student_dash.php">Retour</a>
    <div class="container" style="margin-top:30px">
        <span><?php echo $success; ?></span>
        <div class="card">
            <form method="post" name="profile_form" id="profile_form" enctype="multipart/form-data">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-9">Profile</div>
                        <div class="col-md-3" align="right">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo$username?>" />
                                <span class="text-danger"><?php echo $error_name ?> </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Telephone <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="phone" id="phone" class="form-control" value="<?php echo$phone?>" />
                                <span class="text-danger"><?php echo $error_phone ?> </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Email<span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="email" id="email" class="form-control" value="<?php echo$email?>" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Ancien password <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="password" name="password" id="password" class="form-control" value="<?php echo$kkcz?>" />
                                <span class="text-danger"> <?php echo $error_pass ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Nouveau password <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="password" name="password1" id="password1" class="form-control" placeholder="Leave blank to not change it" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Confirmez Nouveau password <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="password" name="password2" id="password2" class="form-control" placeholder="Leave blank to not change it" onchange="checkpass();" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Image <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="file" name="file" />
                                <span class="text-muted">Only .jpg and .png allowed</span><br />
                                <img src=<?php echo htmlspecialchars($file_name) ?> class="img-thumbnail" style="width:200px;height:210px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer" align="center">


                    <input type="submit" name="button_action" id="button_action" class="btn btn-success btn-sm" value="Save" />
                </div>
            </form>
        </div>
    </div>
    <br />
    <br />

</body>

</html>


<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<link rel="stylesheet" href="css/datepicker.css" />

<style>
    .datepicker {
        z-index: 1600 !important;
        /* has to be larger than 1050 */
    }
</style>