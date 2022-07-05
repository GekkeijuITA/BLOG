<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbName = "my_blog";

    $conn = mysqli_connect($host, $user, $password, $dbName);
    if(!$conn)
    {
        die("Connection failed: " . mysqli_connect_error());
    }

    if(isset($_SESSION["user"]))
    {
        if($_SESSION["user"] == 0)
        {
            $ADMIN = TRUE;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <title>Lorenzo's Blog</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Lorenzo's Blog</a>
        </div>
    </nav>
    <div id="main">
        <div id="articles">
            articles
        </div>
        <div id="dashboard">
            dashboard
        </div>
        <div id="addArticle">
            addArticle
        </div>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>