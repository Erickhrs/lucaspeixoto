<?php
session_start();
include('../../includes/connection.php');

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $id = $_POST['username'];
    $pasword = $_POST['password'];

    $sql = $mysqli->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
    $sql->bind_param('ss', $id, $pasword);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['ID']; 
        header('Location: ../panel.php');
    } else {
        header('Location: ../index.php');
    }
    exit;
} else {
    header('Location: ../index.php');
}
?>