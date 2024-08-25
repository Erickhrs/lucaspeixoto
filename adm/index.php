<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./styles/index.css">
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <h2>Bem vindo, Lucas Peixoto! :)</h2>
            <form action="./actions/login_validate.php" method="POST">
                <div class="input-group">
                    <input type="text" name="username" required>
                    <label>Username</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" required>
                    <label>Password</label>
                </div>
                <button type="submit" class="login-button">Login</button>
                <div class="bottom-text">
                    <a href="./forgot.php">Esqueceu a senha lindo?</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>