<?php
    //FOR THE FUTURE
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
            if($article["id"] != $id[1])
            {
                $index++;
            }
            else
            {
                break;
            }
        }

        // TODO: #1 - Take the article with the id from the url and modify it with the new values
        echo "JSON: ".$article["id"]."[".$index."]"."ID: ".$id[1]."\n";
        echo "Titolo: ".$arrEx[$index]["title"]."\n";
        echo "Contenuto: ".$arrEx[$index]["text"]."\n";
        $arrEx[$index]["title"] = $_POST["title"];
        $arrEx[$index]["text"] = $_POST["content"];
        $arrEx = array_values($arrEx);
        $fileJson = json_encode($arrEx , JSON_PRETTY_PRINT);
        file_put_contents($path, $fileJson);
        echo "modified";
    }
?>