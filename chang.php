<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Student attendance</title>
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
        function verifier_pw() {
            // if (document.form_pw.christ.value != $aaa){
            //     window.alert("ancien mot de passe saisie est incorect");
            // } else {
                // window.alert("bonjour");
                if (document.form_pw.password1.value != document.form_pw.password2.value || document.form_pw.password1.value == "") {
                    window.alert("mots de passe pas conforme");
                } else {
                    form_pw.submit();
                }
            // }


        }
    </SCRIPT>
</head>

<body>

    <?php
    $userid = $_SESSION["user_id"];
    $aaa = $_SESSION["kkcz"];
    ?>
    <br>
    <br>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Change password</div>
                    <div class="card-body">
                        <form id="login_form" name="form_pw" action="verifier.php" method="post">

                            <div class="form-group">
                                <input type="password" class="form-control" id="password_log" placeholder="Ancien password" name="christ">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password_log" placeholder="Nouveau password" name="password1">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password_log" placeholder=" Confirmer nouveau password" name="password2">
                            </div>
                            <div>
                                <input type="submit" name="submit" class="form-submit" value="Enregistrer" onclick="verifier_pw();">
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</body>

</html>