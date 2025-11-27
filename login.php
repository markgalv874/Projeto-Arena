<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Arena Beach</title>
    <link rel="stylesheet" href="registro.css"> </head>
<body>
    <header class="header">
        <div class="logo">
            <img src="imagens/logonovapng.png" alt="Logo Arena Beach">
        </div>
        <nav class="nav">
            <ul>
                <li><a href="index.php">INÍCIO</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h1 class="title">Login</h1>
        <section class="form-section data-section">
            <h2 class="section-title">Preencha seus dados:</h2>
            
            <form id="loginForm" action="processa_login.php" method="POST">
                <div class="input-group full-width">
                    <label for="email" class="visually-hidden">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="E-mail:" required>
                </div>
                <div class="input-group full-width">
                    <label for="password" class="visually-hidden">Senha:</label>
                    <input type="password" id="password" name="senha" placeholder="Senha:" required>
                </div>

                <button type="submit" id="btn-proximo" class="submit-button" disabled>ENTRAR</button>
            </form>
        </section>
    </main>
    
    <script src="login.js"></script>
</body>
</html>