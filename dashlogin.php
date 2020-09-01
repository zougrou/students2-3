<!DOCTYPE html>
<html>

<head>
    <title>Attendance login</title>
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
    <br>
    <br>
    <br>

    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card">
                    <center>
                        <div class="card-header">
                            <b> Connectez-Vous</b>
                        </div>
                    </center>
                    <div class="card-body">
                        <form id="login_form" name="form1" method="post">

                            <div class="form-group">
                                <input type="email" class="form-control" id="UserEmail" placeholder="Email" name="useremail">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="UserPassword" placeholder="Password" name="userpass">
                            </div>
                            <div>
                                <input type="submit" name="submit" class="form-submit" value="connecter" id="butlogin">
                                &thinsp;&thinsp;<a href="index.php">Acceuil</a>
                                <br>
                                <br>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>


    <script>
        $(document).ready(function() {

            $('#butlogin').on('click', function() {
                $("butlogin").attr("disabled", "disabled");
                var email = $('#UserEmail').val();
                var password = $('#UserPassword').val();
                if (email != "" && password != "") {
                    $.ajax({
                        url: "check.php",
                        type: "POST",
                        data: {
                            type: 1,
                            email: email,
                            password: password
                        },
                        cache: false,
                        success: function(dataResult) {
                            var dataResult = JSON.parse(dataResult);
                            if (dataResult.statusCode == 200) {
                                location.href = 'student_dash.php';
                            } else if (dataResult.statusCode == 201) {
                                alert('Mauvais mail ou mdp');
                            }

                        }
                    });
                } else {
                    alert('Remplissez tous les champs !');
                }
            });
        });
    </script>
</body>

</html>