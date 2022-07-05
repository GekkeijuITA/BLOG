<?php
    $path = "../things/articles.json";
    $fileJson = file_get_contents($path);
    $arrEx = json_decode($fileJson, true);
    if(empty($arrEx)){
        echo "no articles";
    }
    else{
        $id = explode("-", $_POST["id"]);
        $index = 0;
        foreach($arrEx as $article){
            if($article["id"] == $id[1])
            {
                unset($arrEx[$index]);
                $arrEx = array_values($arrEx);
                $fileJson = json_encode($arrEx , JSON_PRETTY_PRINT);
                file_put_contents($path, $fileJson);
                echo "deleted";
            }
            else
            {
                $index++;
            }
        }

    }
?>