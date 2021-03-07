<?php

    function getWeb(String $url):string
    {
        $opciones = array(
            'http'=>array(
                'method'=>"GET",
                'header'=>"Accept-language: es\r\n"
            )
        );
        $html = file_get_contents($url, false, stream_context_create($opciones)); 
        return $html ? $html : "";
    }

    header('Content-type: application/json');
    header('Access-Control-Allow-Origin: *');

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $param = json_decode(file_get_contents('php://input'), true);
        if ($param && isset($param["url"])) {
            try {
                echo @json_encode(["html" => getWeb($param["url"])]);
            } catch (\Throwable $th) {
                echo json_encode(["Error" => "Error getting the html"]); 
            }
        }else{
            echo json_encode(["Error" => "Url not sended"]); 
        }
    }else{
        echo json_encode(["Error" => "Method not supported"]); 

    }   
