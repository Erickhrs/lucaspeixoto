<?php
include('../includes/connection.php');
if (isset($mysqli)) {
    // Consulta SQL para buscar os dados
    $query = "SELECT ID, name, description, thumb, year, status FROM projects";
    $result = $mysqli->query($query);

    // Verifica se houve erro na execução da consulta
    if (!$result) {
        echo '<tr><td colspan="7">Erro na execução da consulta: ' . $mysqli->error . '</td></tr>';
    } else {
        // Exibe os dados da tabela
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                echo "<tr data-id='{$row['ID']}'>";
                echo "<td><img src='{$row['thumb']}' alt='Thumb' style='max-width: 100px;'></td>";
                echo "<td>{$row['name']}</td>";
                echo "<td class='description'>{$row['description']}</td>";
                echo "<td>{$row['year']}</td>";
                echo "<td>{$row['status']}</td>";  
                echo "<td style='cursor:pointer'><i class='bx bx-show' ></i></td>";
                echo "<td style='cursor:pointer'><i class='bx bx-edit'></i></td>";
                echo "<td style='cursor:pointer;'><a href='./gallery.php?id={$row['ID']}&name=" . urlencode($row['name']) . "' style='   color: white!important;
    font-style: normal!important;
    text-decoration: none!important;'><i class='bx bx-photo-album'></i></a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nada no banco de dados... vai trabalhar, Lucas, vagabundo!</td></tr>";
        }
    }
} else {
    echo '<p>Conexão com o banco de dados não estabelecida.</p>';
}
?>