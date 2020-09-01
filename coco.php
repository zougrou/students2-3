<?php

session_start();
$host = 'localhost';
$login = 'root';
$pass = '';
// $db = 'zougroustd';
// $user_id = $_SESSION["user_id"];
$connect = new PDO("mysql:host=localhost;dbname=zougroustd", $login, $pass);
// $conn = mysqli_connect($host, $user, $pass, $db);

// session_start();
$user_id = $_SESSION["user_id"];

// if(!isset($_SESSION["teacher_id"]))
// {
//   header('location:login.php');
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Attendance System in PHP using Ajax</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap4.min.js"></script>
</head>

<body>
    <?php
    // fin herder

    $teacher_name = '';
    $teacher_phone = '';
    $teacher_emailid = '';
    $teacher_password = '';
    $teacher_image = '';
    $error_teacher_name = '';
    $error_teacher_phone = '';
    $error_teacher_emailid = '';
    $error_teacher_image = '';
    $error = 0;
    $success = '';

    if (isset($_POST["button_action"])) {
        $teacher_image = $_POST["hidden_teacher_image"];
        if ($_FILES["teacher_image"]["name"] != '') {
            $file_name = $_FILES["teacher_image"]["name"];
            $tmp_name = $_FILES["teacher_image"]["tmp_name"];
            $extension_array = explode(".", $file_name);
            $extension = strtolower($extension_array[1]);
            $allowed_extension = array('jpg', 'png');
            if (!in_array($extension, $allowed_extension)) {
                $error_teacher_image = "Invalid Image Format";
                $error++;
            } else {
                $teacher_image = uniqid() . '.' . $extension;
                $upload_path = 'images/' . $teacher_image;
                move_uploaded_file($tmp_name, $upload_path);
            }
        }

        if (empty($_POST["teacher_name"])) {
            $error_teacher_name = "Teacher Name is required";
            $error++;
        } else {
            $teacher_name = $_POST["teacher_name"];
        }

        if (empty($_POST["teacher_phone"])) {
            $error_teacher_phone = 'phone is required';
            $error++;
        } else {
            $teacher_address = $_POST["teacher_phone"];
        }

        if (empty($_POST["teacher_emailid"])) {
            $error_teacher_emailid = "Email Address is required";
            $error++;
        } else {
            if (!filter_var($_POST["teacher_emailid"], FILTER_VALIDATE_EMAIL)) {
                $error_teacher_emailid = "Invalid email format";
                $error;
            } else {
                $teacher_emailid = $_POST["teacher_emailid"];
            }
        }
        if (!empty($_POST["teacher_password"])) {
            $teacher_password = $_POST["teacher_password"];
        }

        if ($error == 0) {
            if ($teacher_password != '') {
                $data = array(
                    ':teacher_name'            =>    $teacher_name,
                    ':teacher_phone'        =>    $teacher_phone,
                    ':teacher_emailid'        =>    $teacher_emailid,
                    ':teacher_password'        =>    password_hash($teacher_password, PASSWORD_DEFAULT),
                    ':teacher_image'        =>    $teacher_image,
                    ':teacher_id'            =>    $_POST["teacher_id"]
                );
                $query = "
			UPDATE tbl_teacher 
		      SET teacher_name = :teacher_name, 
		      teacher_phone = :teacher_phone, 
		      teacher_emailid = :teacher_emailid, 
		      teacher_password = :teacher_password, 
		      teacher_image = :teacher_image 
		      WHERE teacher_id = :teacher_id
			";
            } else {
                $data = array(
                    ':teacher_name'            =>    $teacher_name,
                    ':teacher_phone'        =>    $teacher_phone,
                    ':teacher_emailid'        =>    $teacher_emailid,
                    ':teacher_image'        =>    $teacher_image,
                    ':teacher_id'            =>    $_POST["teacher_id"]
                );
                $query = "
			UPDATE tbl_teacher 
		      SET teacher_name = :teacher_name, 
		      teacher_phone = :teacher_phone, 
		      teacher_emailid = :teacher_emailid, 
		      teacher_image = :teacher_image 
		      WHERE teacher_id = :teacher_id
			";
            }

            $statement = $connect->prepare($query);
            if ($statement->execute($data)) {
                $success = '<div class="alert alert-success">Profile Details Change Successfully</div>';
            }
        }
    }
    $teacher_grade_id = '';
    $teacher_qualification = '';
    $teacher_doj = '';
    $query = "
SELECT * FROM tbl_teacher 
WHERE teacher_id = '" . $user_id . "'
";

    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();

    ?>

    <div class="container" style="margin-top:30px">
        <span><?php echo $success; ?></span>
        <div class="card">
            <form method="post" id="profile_form" enctype="multipart/form-data">
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
                            <label class="col-md-4 text-right">Teacher Name <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="teacher_name" id="teacher_name" class="form-control" />
                                <span class="text-danger"><?php echo $error_teacher_name; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">phone <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input name="teacher_phone" id="teacher_phone" class="form-control"></input>
                                <span class="text-danger"><?php echo $error_teacher_phone; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Email Address <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="text" name="teacher_emailid" id="teacher_emailid" class="form-control" />
                                <span class="text-danger"><?php echo $error_teacher_emailid; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Password <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="password" name="teacher_password" id="teacher_password" class="form-control" placeholder="Leave blank to not change it" />
                                <span class="text-danger"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-4 text-right">Image <span class="text-danger">*</span></label>
                            <div class="col-md-8">
                                <input type="file" name="teacher_image" id="teacher_image" />
                                <span class="text-muted">Only .jpg and .png allowed</span><br />
                                <span id="error_teacher_image" class="text-danger"><?php echo $error_teacher_image; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer" align="center">
                    <input type="hidden" name="hidden_teacher_image" id="hidden_teacher_image" />
                    <input type="hidden" name="teacher_id" id="teacher_id" />
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

<script>
    $(document).ready(function() {

        <?php
        foreach ($result as $row) {
        ?>
            $('#teacher_name').val("<?php echo $row["teacher_name"]; ?>");
            $('#teacher_phone').val("<?php echo $row["teacher_phone"]; ?>");
            $('#teacher_emailid').val("<?php echo $row["teacher_emailid"]; ?>");
            $('#error_teacher_image').html("<img src='admin/teacher_image/<?php echo $row['teacher_image']; ?>' class='img-thumbnail' width='100' />");
            $('#hidden_teacher_image').val('<?php echo $row["teacher_image"]; ?>');
            $('#teacher_id').val("<?php echo $row["teacher_id"]; ?>");

        <?php
        }
        ?>

        $('#teacher_doj').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true
        });

    });
</script>