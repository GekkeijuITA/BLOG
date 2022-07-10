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

    $ADMIN = FALSE;

    if(isset($_SESSION["user"]))
    {
        if($_SESSION["user"] == 1)
        {
            $ADMIN = TRUE;
        }

        echo $_SESSION["user"];
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
    <nav class="navbar navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Lorenzo's Blog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Account</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <?php
                        if(isset($_SESSION["user"]))
                        {
                            echo '
                                <a href="#" id="logout">Logout</a>
                            ';
                        }
                        else
                        {
                            echo '
                                <form id="loginForm">
                                    <input class="form-control me-2" type="text" name="email" id="loginEmail" placeholder="Email" required>
                                    <input class="form-control me-2" type="password" name="password" id="loginPsw" placeholder="Password" required>
                                    <input class="btn btn-outline-success" id="loginButton" type="submit" value="Login" required>
                                </form>
                                <form id="registerForm">
                                    <input class="form-control me-2" type="text" id="registerEmail" placeholder="Email" required>
                                    <input class="form-control me-2" type="password" id="registerPsw" placeholder="Password" required>
                                    <input class="form-control me-2" type="password" id="confirmPsw" placeholder="Confirm Password" required>
                                    <input class="btn btn-outline-success" id="registerButton" type="submit" value="Register">
                                </form>
                                <a href="#" id="register">Dont have an account?</a>
                                <a href="#" id="login">Have already an account?</a>
                            ';
                        }
                    ?>
                </div>
            </div>
        </div>
    </nav>
    <div id="main" class="ms-2 me-2">
        <div id="articles"></div>
        <?php
            if($ADMIN)
            {
                echo '
                    <div id="addArticle">
                        <input type="text" name="newArticleTitle" placeholder="Title" id="title" required>
                        <input type="textarea" name="newArticleContent" placeholder="Content" id="content" required>
                        <input type="submit" value="Pubblica" id="addArticleButton">
                    </div>                
                ';
            }
        ?>
    </div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
    $(document).ready(function()
    {
        $("#articles").load("php/seeArticles.php");

        $("#addArticleButton").click(function()
        {
            var title = $("#title").val();
            var content = $("#content").val();
            request = $.ajax({
                url: "php/writeArticle.php",
                type: "POST",
                data: {
                    title: title,
                    content: content
                }
            });

            request.done(function (response, textStatus, jqXHR){
                request2 = $.ajax({
                    url: "php/seeArticles.php",
                    type: "GET"
                });

                request2.done(function (response, textStatus, jqXHR){
                    $("#articles").html(response);
                });

                request2.fail(function (jqXHR, textStatus, errorThrown){
                    console.error(
                        "The following error occurred: "+
                        textStatus, errorThrown
                    );
                });

                $("#title").val("");
                $("#content").val("");
            });

            request.fail(function (jqXHR, textStatus, errorThrown){
                console.error(
                    "The following error occurred: "+
                    textStatus, errorThrown
                );
            });
        });

        $("#register").click(function()
        {
            $("#loginForm").hide();
            $("#registerForm").show();
            $("#login").show();
            $(this).hide();
        });

        $("#login").click(function()
        {
            $("#loginForm").show();
            $("#registerForm").hide();
            $("#register").show();
            $(this).hide();
        });

        $("#loginButton").click(function()
        {
            var email = $("#loginEmail").val();
            var psw = $("#loginPsw").val();
            request = $.ajax({
                url: "php/login.php",
                type: "POST",
                data: $("#loginForm").serialize()
            });

            request.done(function (response, textStatus, jqXHR){
                $(".offcanvas").removeClass("show");
                $(".offcanvas-backdrop").removeClass("show");
                console.log(response);
                location.reload();
            });

            request.fail(function (jqXHR, textStatus, errorThrown){
                console.error(
                    "The following error occurred: "+
                    textStatus, errorThrown
                );
            });
        });

        $("#registerButton").click(function()
        {
            var email = $("#registerEmail").val();
            var psw = $("#registerPsw").val();
            var confirmPsw = $("#confirmPsw").val();
            request = $.ajax({
                url: "php/register.php",
                type: "POST",
                data: {
                    email: email,
                    psw: psw,
                    confirmPsw: confirmPsw
                }
            });

            request.done(function (response, textStatus, jqXHR){
                console.log(response);
                $(".offcanvas").removeClass("show");
                $(".offcanvas-backdrop").removeClass("show");
                location.reload();
            });

            request.fail(function (jqXHR, textStatus, errorThrown){
                console.error(
                    "The following error occurred: "+
                    textStatus, errorThrown
                );
            });            
        })

        $(document).on("click" , ".delete" , function()
        {
            var id = $(this).attr("id");
            console.log(id);
            request = $.ajax({
                url: "php/deleteArticle.php",
                type: "POST",
                data: {
                    id: id
                }
            });

            request.done(function (response, textStatus, jqXHR){
                request2 = $.ajax({
                    url: "php/seeArticles.php",
                    type: "GET"
                });

                request2.done(function (response, textStatus, jqXHR){
                    $("#articles").html(response);
                });

                request2.fail(function (jqXHR, textStatus, errorThrown){
                    console.error(
                        "The following error occurred: "+
                        textStatus, errorThrown
                    );
                });
            });

            request.fail(function (jqXHR, textStatus, errorThrown){
                console.error(
                    "The following error occurred: "+
                    textStatus, errorThrown
                );
            });
        })

        $(document).on("click" , ".edit" , function()
        {
            parent = $(this).parent();
            parent.children("#title").html("<input type='text' id='modTitle' value='" + parent.children("#title").text() + "'>");
            parent.children("#content").html("<textarea id='modContent'>" + parent.children("#content").text() + "</textarea>");
            var id = $(this).attr("id");
            $(document).on("keyup" , function(e)
            {
                if(e.keyCode == 13)
                {
                    console.log(id);
                    request = $.ajax({
                        url: "php/modifyArticle.php",
                        type: "POST",
                        data: {
                            id: id,
                            title: $("#modTitle").val(),
                            content: $("#modContent").val()
                        }
                    });

                    request.done(function (response, textStatus, jqXHR){
                        console.log(response);
                        request2 = $.ajax({
                            url: "php/seeArticles.php",
                            type: "GET"
                        });

                        request2.done(function (response, textStatus, jqXHR){
                            $("#articles").html(response);
                        });

                        request2.fail(function (jqXHR, textStatus, errorThrown){
                            console.error(
                                "The following error occurred: "+
                                textStatus, errorThrown
                            );
                        });
                    });

                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.error(
                            "The following error occurred: "+
                            textStatus, errorThrown
                        );
                    });
                }                
            });

            $(document).on("click" , function(e)
            {
                if($(e.target).is(parent) || $(e.target).is(".delete"))
                {
                    console.log(id);
                    request = $.ajax({
                        url: "php/modifyArticle.php",
                        type: "POST",
                        data: {
                            id: id,
                            title: $("#modTitle").val(),
                            content: $("#modContent").val()
                        }
                    });

                    request.done(function (response, textStatus, jqXHR){
                        console.log(response);
                        request2 = $.ajax({
                            url: "php/seeArticles.php",
                            type: "GET"
                        });

                        request2.done(function (response, textStatus, jqXHR){
                            $("#articles").html(response);
                        });

                        request2.fail(function (jqXHR, textStatus, errorThrown){
                            console.error(
                                "The following error occurred: "+
                                textStatus, errorThrown
                            );
                        });
                    });

                    request.fail(function (jqXHR, textStatus, errorThrown){
                        console.error(
                            "The following error occurred: "+
                            textStatus, errorThrown
                        );
                    });
                }
            })          
        })
    });
</script>
</html>