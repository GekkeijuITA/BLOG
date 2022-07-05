<?php
    session_start();
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbName = "my_blog";

    $conn = mysqli_connect($host, $user, $password, $dbName);
    if(!$conn)
    {
        die("Connection failed: " . mysqli_connect_error());
    }

    $email = $_POST["email"];
    $sql = "SELECT psw,id FROM userclient WHERE email = '$email'";
    $result = $conn -> query($sql);
    if($result -> num_rows > 0)
    {
        $row = $result -> fetch_assoc();
        $pswHash = $row["psw"];
        $id = $row["id"];
        $psw = $_POST["psw"];
        if(hash("sha256" , $psw) == $pswHash)
        {
            $_SESSION["user"] = $id; 
            echo $_SESSION["user"];
        }
        else
        {
            echo "Password is incorrect";
        }
    }
    else
    {
        echo "Email is incorrect";
    }
?>