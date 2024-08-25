<?php
include('../../includes/connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['project_id'], $_POST['link'], $_POST['size'], $_POST['project_name'])) {
        $project_id = intval($_POST['project_id']);
        $link = filter_var($_POST['link'], FILTER_SANITIZE_URL);
        $size = filter_var($_POST['size'], FILTER_SANITIZE_STRING);
        $project_name = htmlspecialchars($_POST['project_name']);

        $query = "INSERT INTO contents (project, link, size) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("iss", $project_id, $link, $size);

        if ($stmt->execute()) {
            header('Location: ../gallery.php?id=' . $project_id . '&name=' . urlencode($project_name));
            exit();
        } else {
            echo '<p class="no-data">Erro ao adicionar o conteúdo: ' . $mysqli->error . '</p>';
        }

        $stmt->close();
    } else {
        echo '<p class="no-data">Dados inválidos fornecidos.</p>';
    }
} else {
    echo '<p class="no-data">Método de requisição inválido.</p>';
}

$mysqli->close();
?>