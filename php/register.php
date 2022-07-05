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

    $email = $_POST["email"];
    $sql = "SELECT id FROM userclient WHERE email = '$email'";
    $result = $conn -> query($sql);
    if($result -> num_rows <= 0)
    {
        $psw = $_POST["psw"];
        $confirmPsw = $_POST["confirmPsw"];

        if($psw == $confirmPsw)
        {
            $psw = hash("sha256" , $psw);
            $sql = "INSERT INTO userclient (email, psw) VALUES ('$email', '$psw')";
            $conn -> query($sql);
            $sql = "SELECT id FROM userclient WHERE email = '$email'";
            $result = $conn -> query($sql);
            echo "Success";
            $_SESSION["user"] = ($result -> fetch_assoc())["id"];
        }
        else
        {
            echo "Passwords don't match";
        }
    }
    else
    {
        echo "Email already exists";
    }
?>