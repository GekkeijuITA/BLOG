<?php
    $path = "../things/articles.json";
    $fileJson = file_get_contents($path);
    $arrEx = json_decode($fileJson, true);

    $lastId = $arrEx[count($arrEx) - 1]["id"];
    $arr = array(
        "id" => $lastId + 1,
        "title" => $_POST["title"],
        "text" => $_POST["content"],
        "datetime" => date("d-m-Y H:i:s")/*,
        "modified" => ""*/
    );

    $arrEx[] = $arr;
    file_put_contents($path, json_encode($arrEx , JSON_PRETTY_PRINT));
?>