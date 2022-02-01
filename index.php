<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Nahrávání souborů</title>
</head>
<?php

if($_FILES){
    $targetDir="uploads/";
    $targetFile=$targetDir . basename($_FILES['uploadedName']['name']);
    $fileType = explode("/", $_FILES['uploadedName']['type'])[0];
    //$fileType=strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $uploadSuccess=true;

    if($_FILES['uploadedName']['error']!=0){
        echo"Chyba serveru pri uploadu";
        $uploadSuccess=false;
    }

    //kontrola existence
    elseif(file_exists($targetFile)){
        echo"soubor existuje";
        $uploadSuccess=false;
    }
    //kontrola velikosti
    elseif($_FILES['uploadedName']['size']>8000000){
        echo"Soubor je prilis velky";
        $uploadSuccess=false;
    }
    //kontrola typu
//    elseif ($fileType !== "jpg" && $fileType !== "png") {
//        echo "Špatná typ souboru";
//    }

    //presun souboru
    elseif(!$uploadSuccess){
        echo"Došlo k chybe uploadu";
    }else{
        if(move_uploaded_file($_FILES['uploadedName']['tmp_name'], $targetFile)){
            echo"Soubor'". basename($_FILES['uploadedName']['name']) . "'byl uložen";
        }else{
            echo"Došlo k chybe uploadu";
        }
    }
}

?>
<body class="container">
<form class="container-sm" method="post" action="" enctype="multipart/form-data">
    <div class="mb-3">
        <p class="form-label">Select image to upload:</p>
        <input class="form-control"  type="file" name="uploadedName" accept="video/*, image/*, audio/*"/>
        <input class="btn-primary" type="submit" value="Nahrát" name="submit"/>
    </div>
</form>

<div class="img-thumbnail">
<?php
if ($_FILES){
    switch ($fileType) {
        case "image":
            echo "<img class='align-items-center' width='320' src='./{$targetFile}'>";
            return;
        case "video":
            echo "<video width='320' height='240' controls> <source src='./{$targetFile}'> </video>";
            return;
        case "audio":
            echo "<audio  controls> <source src='./{$targetFile}'> </audio>";
            return;
    }
}
?>
</div>
</body>
