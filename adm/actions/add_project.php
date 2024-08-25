<?php
include('../../includes/connection.php'); // Inclui a conexão com o banco de dados

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $mysqli->real_escape_string($_POST['name']);
    $description = $mysqli->real_escape_string($_POST['description']);
    $thumb = $mysqli->real_escape_string($_POST['thumb']);
    $year = (int)$_POST['year'];

    $query = "INSERT INTO projects (name, description, thumb, year) VALUES ('$name', '$description', '$thumb', $year)";

    if ($mysqli->query($query) === TRUE) {
        header('Location: ../index.php'); // Redireciona de volta para a página principal
    } else {
        echo 'Erro: ' . $mysqli->error;
    }
}
?>