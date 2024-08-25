<?php
include_once('../../includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $thumb = $_POST['thumb'];
    $year = $_POST['year'];
    $status = $_POST['status'];

    $query = "UPDATE projects SET name=?, description=?, thumb=?, year=?, status=? WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssssi', $name, $description, $thumb, $year, $status, $id);

    if ($stmt->execute()) {
        echo "Projeto atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar o projeto: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();

    // Redireciona de volta para a página do painel
   header('Location: ../panel.php');
    exit();
}
?>