<?php
    session_start();
    $ADMIN = FALSE;
    if(isset($_SESSION["user"]))
    {
        if($_SESSION["user"] == 0)
        {
            $ADMIN = TRUE;
        }
    }
    $path = "../things/articles.json";
    $fileJson = file_get_contents($path);
    $arrEx = json_decode($fileJson, true);
    if(empty($arrEx)){
        echo "no articles";
    }
    else{
        foreach($arrEx as $article){
            echo "<div class='article'>";
            echo "<h2>".$article["title"]."</h2>";
            echo "<p class='text-muted'>".$article["datetime"]."</p>";
            echo "<p>".$article["text"]."</p>";
            if($ADMIN)
            {
                echo "<a href='#' id='ed-".$article["id"]."'>Edit</a>";
                echo "&nbsp";
                echo "<a href='#' id='del-".$article["id"]."'>Delete</a>";
            }
            echo "</div>";
        }
    }
?>