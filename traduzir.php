<?php
$data = json_decode(file_get_contents('php://input'), true);

$response = file_get_contents("https://libretranslate.de/translate", false, stream_context_create([
    "http" => [
        "method" => "POST",
        "header" => "Content-Type: application/json",
        "content" => json_encode([
            "q" => $data["q"],
            "source" => "auto",
            "target" => $data["target"],
            "format" => "text"
        ])
    ]
]));

header("Content-Type: application/json");
echo $response;
