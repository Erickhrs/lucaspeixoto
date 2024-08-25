<?php
include('../../includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'], $_POST['project_id'], $_POST['project_name'])) {
        $id = intval($_POST['id']);
        $project_id = intval($_POST['project_id']);
        $project_name = htmlspecialchars($_POST['project_name']);

        $query = "DELETE FROM contents WHERE ID = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            header('Location: ../gallery.php?id=' . $project_id . '&name=' . urlencode($project_name));
            exit();
        } else {
            echo '<p class="no-data">Erro ao excluir o conteúdo: ' . $mysqli->error . '</p>';
        }

        $stmt->close();
    } else {
        echo '<p class="no-data">ID do conteúdo ou informações do projeto não fornecidos.</p>';
    }
} else {
    echo '<p class="no-data">Método de requisição inválido.</p>';
}

$mysqli->close();
?>