<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro</title>
    <link rel="icon" type="image/x-icon" href="./assets/logo.ico">
    <link rel="stylesheet" href="./styles/erro.css">
    <link rel="stylesheet" href="./styles/global.css">
</head>

<body>
    <div class="error-container">
        <h1>Ocorreu um Erro</h1>
        <p>
            <?php
            session_start();
            if (isset($_SESSION['erro'])) {
                echo htmlspecialchars($_SESSION['erro']);
                unset($_SESSION['erro']); // Limpa a mensagem de erro após exibir
            } else {
                echo 'Identificamos um problema. Por favor, tente novamente.';
            }
            ?>
        </p>
        <a href="<?php echo $_SESSION['back'];?>" class="btn">Voltar</a>
    </div>
</body>

</html>