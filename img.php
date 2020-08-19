<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'taken';

$conn = mysqli_connect($host, $user, $pass, $db);


// $FName = "";
// $FName2 = "NULL";

if ($_FILES['image']['name']) {
    $FName = md5($_FILES['image']['name'] . time()) . "." . end(explode('.', $_FILES['image']['name']));
    $NewFile = "images/" . $FName;
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $NewFile)) {
        die("Failed to move file " . $_FILES['image']['tmp_name'] . " to " . $FName);
    }
}
echo 'bonjour';
if ($_FILES['image2']['name']) {
    $FName2 = md5($_FILES['image2']['name'] . time()) . "." . end(explode('.', $_FILES['image2']['name']));
    $NewFile = "images/" . $FName2;
    if (!move_uploaded_file($_FILES['image2']['tmp_name'], $NewFile)) {
        die("Failed to move file " . $_FILES['image2']['tmp_name'] . " to " . $FName2);
    }
}
echo 'bonjour';
$query = "INSERT INTO image_txt(`image`)
VALUES('$NewFile')";

?>