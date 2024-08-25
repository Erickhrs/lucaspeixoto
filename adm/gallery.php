<?php
include('../includes/connection.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeria de Conteúdos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="./styles/gallery.css">
    <style>
    /* Adicionar o estilo para modais */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6);
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        border-radius: 10px;
        width: 60%;
        max-width: 600px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        animation: slideIn 0.3s ease-out;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 24px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        color: #fff;
        background-color: #4CAF50;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        margin-right: 10px;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #45a049;
    }

    .btn-danger {
        background-color: #f44336;
    }

    .btn-danger:hover {
        background-color: #e53935;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-50px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    form {
        display: flex;
        flex-direction: column;
    }

    label {
        margin: 10px 0 5px;
        font-size: 16px;
    }

    input[type="text"] {
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>Galeria de Conteúdos</h1>
        <a href="panel.php" class="back-link"><i class="fas fa-arrow-left"></i> Voltar para a página inicial</a>
        <button class="btn" onclick="openAddModal()" style="    position: absolute;right: 10%;">Adicionar
            Conteudo</button>

        <?php
        if (isset($_GET['id'])) {
            $project_id = intval($_GET['id']);
            $project_name = htmlspecialchars($_GET['name']);

            if (isset($mysqli)) {
                $query = "SELECT ID, project, link, size FROM contents WHERE project = ?";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param("i", $project_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if (!$result) {
                    echo '<p class="no-data">Erro na execução da consulta: ' . $mysqli->error . '</p>';
                } else {
                    if ($result->num_rows > 0) {
                        echo '<table>';
                        echo '<tr><th>Projeto</th><th>Conteúdo</th><th>Size</th><th>Ações</th></tr>';
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$project_name}</td>";
                            echo "<td><img src='{$row['link']}' alt='Imagem do Conteúdo'></td>";
                            echo "<td>{$row['size']}</td>";
                            echo "<td>";
                            echo "<button class='btn' onclick='openEditModal({$row['ID']}, \"{$row['link']}\", \"{$row['size']}\")'>Editar</button>";
                            echo "<button class='btn btn-danger' onclick='openDeleteModal({$row['ID']})'>Excluir</button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo '</table>';
                    } else {
                        echo '<p class="no-data">Nenhum dado encontrado para este projeto.</p>';
                    }
                }
            } else {
                echo '<p class="no-data">Conexão com o banco de dados não estabelecida.</p>';
            }
        } else {
            echo '<p class="no-data">ID do projeto não fornecido.</p>';
        }
        ?>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddModal()">&times;</span>
            <h2>Adicionar Imagem</h2>
            <form id="addForm" method="post" action="./actions/add_content.php">
                <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                <input type="hidden" name="project_name" value="<?php echo htmlspecialchars($_GET['name']); ?>">
                <label for="addLink">Link:</label>
                <input type="text" name="link" id="addLink" required>
                <label for="addSize">Size:</label>
                <input type="text" name="size" id="addSize" required>
                <input type="submit" class="btn" value="Adicionar">
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Editar Imagem</h2>
            <form id="editForm" method="post" action="edit_content.php">
                <input type="hidden" name="id" id="editId">
                <label for="editLink">Link:</label>
                <input type="text" name="link" id="editLink" required>
                <label for="editSize">Size:</label>
                <input type="text" name="size" id="editSize" required>
                <input type="submit" class="btn" value="Salvar">
            </form>
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeDeleteModal()">&times;</span>
            <h2>Confirmar Exclusão</h2>
            <p>Tem certeza de que deseja excluir esta imagem?</p>
            <form id="deleteForm" method="post" action="./actions/delete_content.php">
                <input type="hidden" name="id" id="deleteId">
                <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                <input type="hidden" name="project_name" value="<?php echo htmlspecialchars($_GET['name']); ?>">
                <input type="submit" class="btn btn-danger" value="Excluir">
            </form>
            <button class="btn" onclick="closeDeleteModal()">Cancelar</button>
        </div>
    </div>

    <script>
    function openAddModal() {
        document.getElementById('addModal').style.display = 'block';
    }

    function closeAddModal() {
        document.getElementById('addModal').style.display = 'none';
    }

    function openEditModal(id, link, size) {
        document.getElementById('editId').value = id;
        document.getElementById('editLink').value = link;
        document.getElementById('editSize').value = size;
        document.getElementById('editModal').style.display = 'block';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    function openDeleteModal(id) {
        document.getElementById('deleteId').value = id;
        document.getElementById('deleteModal').style.display = 'block';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('addModal')) {
            closeAddModal();
        }
        if (event.target == document.getElementById('editModal')) {
            closeEditModal();
        }
        if (event.target == document.getElementById('deleteModal')) {
            closeDeleteModal();
        }
    }
    </script>
</body>

</html>