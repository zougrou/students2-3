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

</head>

<body style="background: #007bff">
    <!-- <div class="main">
        <section class="signup"> -->
    <br>
    <br>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card">
                    <center>
                        <div class="card-header"><b> CONNECTEZ-VOUS</b></div>
                    </center>
                    <div class="card-body">
                        <form method="POST" action="checkdata.php" enctype="multipart/form-data" id="form">
                            <div class="form-group">
                                <input type="text" name="username" id="Username" class="form-control" placeholder="nom" onsubmit="return checkall();">
                            </div>
                            <div class="form-group">
                                <input type="email" name="useremail" id="UserEmail" class="form-control" placeholder="email" required onkeyup="checkemail();">
                                <span id="email_status"></span>
                            </div>
                            <div class="form-group">
                                <input type="tel" name="userphone" id="UserPhone" placeholder="Phone" class="form-control" maxlength="8" onkeyup="checkphone();">
                                <span id="phone_status"></span>
                                <!-- <input type="tel" name="userphone" id="UserPhone" maxlength="8" placeholder="Entrez votre numéro de tel" class="form-control" onkeyup="checkphone();">
                                <span id=" phone_status"></span> -->
                            </div>
                            <div class="form-group">
                                <input type="password" name="userpass" id="UserPassword" class="form-control" placeholder="password" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="userpass2" id="UserPassword2" class="form-control" placeholder="confirmer password" require onkeyup="checkpass();">
                                <span id="pass_status"></span>
                            </div>
                            <div class="form-group">
                                <input type="file" name="file" />
                            </div>
                            <div class="form-group">
                                <p>Quelle est votre genre ? </p>
                                <input type="radio" name="sex" id="agree-term" class="agree-term" value="Homme" checked />
                                <label for="agree-term" class="label-agree-term">Homme</label>
                                <input type="radio" name="sex" id="agree-term" class="agree-term" value="Femme" />
                                <label for="agree-term" class="label-agree-term">Femme</label>
                                <input type="radio" name="sex" id="agree-term" class="agree-term" value="autre" />
                                <label for="agree-term" class="label-agree-term">Autre</label>
                            </div>
                            <div>
                                <input type="submit" name="submit_form" class="form-submit" value="Enregistrer" /> <a href="index.php">&thinsp;&thinsp;Accueil</a><br><br>
                                <P>Vous avez un compte? signez <a href="login.php">ici</a></P>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <!-- JS -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>

    <script>
        function checkphone() //Fonction qui vérifie si le téléphone existe ou pas
        {
            var phone = document.getElementById("UserPhone").value;

            if (phone) {
                $.ajax({
                    type: 'post',
                    url: 'checkdata.php',
                    data: {
                        user_phone: phone,
                    },
                    success: function(response) {
                        $('#phone_status').html(response);
                        if (response == "OK") {
                            return true;
                        } else {
                            return false;
                        }
                    }
                });
            } else {
                $('#phone_status').html("");
                return false;
            }
        }

        function checkemail() //Fonction qui vérifie si le mail existe ou pas
        {
            var email = document.getElementById("UserEmail").value;

            if (email) {
                $.ajax({
                    type: 'post',
                    url: 'checkdata.php',
                    data: {
                        user_email: email,
                    },
                    success: function(response) {
                        $('#email_status').html(response);
                        if (response == "OK") {
                            return true;
                        } else {
                            return false;
                        }
                    }
                });
            } else {
                $('#email_status').html("");
                return false;
            }
        }

        function checkpass() //Fonction qui vérifie si les mMdp correspondent
        {
            var pass2 = document.getElementById("UserPassword2").value;
            var pass = document.getElementById("UserPassword").value;

            if (pass2) {
                $.ajax({
                    type: 'post',
                    url: 'checkdata.php',
                    data: {
                        user_pass2: pass2,
                        user_pass: pass,
                    },
                    success: function(response) {
                        $('#pass_status').html(response);
                        if (response == "OK") {
                            return true;
                        } else {
                            return false;
                        }
                    }
                });
            } else {
                $('#pass_status').html("");
                return false;
            }
        }


        function checkall() {
            var namehtml = document.getElementById("phone_status").innerHTML;
            var emailhtml = document.getElementById("email_status").innerHTML;
            var passhtml = document.getElementById("pass_status").innerHTML;

            if ((namehtml && emailhtml && passhtml) == "OK") {
                return true; //On peut s'inscrire
            } else {
                return false; //On ne peut pas s'incrire
            }
        }
    </script>

</body>

</html>