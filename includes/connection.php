<?php
date_default_timezone_set('America/Sao_Paulo');
$user = 'root';
$psw = ''; 
$database = "lucasbd"; 
$host = 'localhost';

$mysqli = new mysqli($host, $user, $psw, $database);

if ($mysqli->error){
    die("Falha ao conectar ao banco de dados: " . $mysqli->error);
}