<?php
require_once('../includes/connection.php');
require_once('./includes/protect.php');
require_once('./includes/functions.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="./styles/panel.css">

    <title>Lucas Peixoto - ADM</title>
</head>

<body class="dark">


    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-dashboard'></i>
            <span class="text">AdmPanel</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
                    <i class='bx bx-briefcase-alt-2'></i>
                    <span class="text">Projetos</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="#">
                    <i class='bx bxs-cog'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
            <li>
                <a href="#" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->



    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="profile">
                <img src="./assets/picture.jpg">
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
                <a href="#" class="btn-download">
                    <i class='bx bxs-cloud-download'></i>
                    <span class="text">Download PDF</span>
                </a>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bx-briefcase-alt'></i>
                    <span class="text">
                        <h3><?php echo total($mysqli, 'projects', '');?></h3>
                        <p>Projetos</p>
                    </span>
                </li>
                <li>
                    <i class='bx bx-photo-album'></i>
                    <span class="text">
                        <h3><?php echo total($mysqli, 'contents', '');?></h3>
                        <p>Conteúdos</p>
                    </span>
                </li>
            </ul>


            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Lista de Projetos</h3>
                        <i class='bx bx-plus'></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Thumb</th>
                                <th>Projeto</th>
                                <th>Descrição</th>
                                <th>Ano</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include_once('./actions/get_projects.php')
                            ?>
                    </table>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    <!-- MODAL -->
    <!-- MODAL -->
    <!-- MODAL PARA EDIÇÃO -->
    <div id="edit-project-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Editar Projeto</h2>
            <form id="edit-project-form" action="./actions/edit_project.php" method="POST">
                <input type="hidden" id="edit-id" name="id">
                <div class="form-group">
                    <label for="edit-name">Nome do Projeto:</label>
                    <input type="text" id="edit-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="edit-description">Descrição:</label>
                    <textarea id="edit-description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-thumb">Thumb URL:</label>
                    <input type="text" id="edit-thumb" name="thumb" required>
                </div>
                <div class="form-group">
                    <label for="edit-year">Ano:</label>
                    <input type="number" id="edit-year" name="year" required>
                </div>
                <div class="form-group">
                    <label for="edit-status">Status:</label>
                    <input type="text" id="edit-status" name="status" required>
                </div>
                <button type="submit" class="btn-submit">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <div id="add-project-modal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <h2>Adicionar Novo Projeto</h2>
            <form id="add-project-form" action="./actions/add_project.php" method="POST">
                <div class="form-group">
                    <label for="name">Nome do Projeto:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="description">Descrição:</label>
                    <textarea id="description" name="description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="thumb">Thumb URL:</label>
                    <input type="text" id="thumb" name="thumb" required>
                </div>

                <div class="form-group">
                    <label for="year">Ano:</label>
                    <input type="number" id="year" name="year" required>
                </div>

                <button type="submit" class="btn-submit">Adicionar Projeto</button>
            </form>
        </div>
    </div>


    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const editModal = document.getElementById('edit-project-modal');
        const closeModalBtn = document.querySelector('#edit-project-modal .close-btn');

        // Certifique-se de que o modal esteja oculto ao carregar a página
        editModal.style.display = 'none';

        // Abre o modal com os dados do projeto selecionado
        document.querySelectorAll('.bx-edit').forEach((editBtn) => {
            editBtn.addEventListener('click', (event) => {
                const row = event.target.closest('tr');
                const id = row.getAttribute('data-id');
                const cells = row.querySelectorAll('td');

                // Preenche o formulário com os dados do projeto
                document.getElementById('edit-id').value = id;
                document.getElementById('edit-name').value = cells[1].textContent;
                document.getElementById('edit-description').value = cells[2].textContent;
                document.getElementById('edit-thumb').value = cells[0].querySelector('img').src;
                document.getElementById('edit-year').value = cells[3].textContent;
                document.getElementById('edit-status').value = cells[4].textContent;

                // Exibe o modal
                editModal.style.display = 'flex';
            });
        });

        // Fecha o modal quando o usuário clica no botão de fechar
        closeModalBtn.addEventListener('click', () => {
            editModal.style.display = 'none';
        });

        // Fecha o modal quando o usuário clica fora da área do modal
        window.addEventListener('click', (event) => {
            if (event.target === editModal) {
                editModal.style.display = 'none';
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('add-project-modal');
        const openModalBtn = document.querySelector('.bx-plus');
        const closeModalBtn = document.querySelector('.close-btn');

        // Certifique-se de que o modal esteja oculto ao carregar a página
        modal.style.display = 'none';

        // Abre o modal quando o botão é clicado
        openModalBtn.addEventListener('click', () => {
            modal.style.display = 'flex';
        });

        // Fecha o modal quando o usuário clica no botão de fechar
        closeModalBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Fecha o modal quando o usuário clica fora da área do modal
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
    </script>
    <script src="./scripts/panel.js"></script>
</body>

</html>