<?php
// Recebe dados do corpo JSON (opcional, pode ser removido se não usar)
$data = json_decode(file_get_contents('php://input'), true);

// Define os parâmetros
$sl = $_GET['langOriginal']; // source language
$dl = $_GET['idiomaDestino']; // destination language
$text = $_GET['texto']; // frase original

// Codifica o texto para ser seguro na URL
$text_encoded = urlencode($text);

// Monta a URL final
$url = "https://ftapi.pythonanywhere.com/translate?sl=$sl&dl=$dl&text=$text_encoded";

// Faz a requisição GET simples (sem headers extras)
$response = file_get_contents($url);

// Retorna o JSON
header("Content-Type: application/json");
echo $response;
