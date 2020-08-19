<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form method="POST" action="img.php" enctype="multipart/form-data" id="form">

        <tr height="30">
            <td>Upload Main Image :</td>
            <td></td>
            <td><input type="hidden" name="MAX_FILE_SIZE" value="2500000"> <input type="file" name="image">
            </td>
        </tr>

        <tr height="30">
            <td>Upload Image 2 :</td>
            <td></td>
            <td><input type="hidden" name="MAX_FILE_SIZE" value="2500000"> <input type="file" name="image2">
            </td>
        </tr>
        <div>
            <input type="submit" name="submit_form" class="form-submit" value="Enregistrer" />
        </div>

    </form>
</body>

</html>