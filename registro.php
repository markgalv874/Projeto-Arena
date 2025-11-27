<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Arena Beach</title>
    <link rel="stylesheet" href="registro.css"> 
</head>
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
        <h1 class="title">Registro</h1>

        <section class="form-section data-section">
            <h2 class="section-title">Preencha seus dados:</h2>
            
            <form id="loginForm" action="processa_registro.php" method="POST">
                
                <div class="input-group full-width">
                    <label for="nome-completo" class="visually-hidden">Nome completo:</label>
                    <input type="text" id="nome-completo" name="nome" placeholder="Nome completo:" required>
                </div>

                <div class="input-row">
                    <div class="input-group half-width">
                        <label for="cpf" class="visually-hidden">CPF:</label>
                        <input type="text" id="cpf" name="cpf" placeholder="CPF:" required maxlength="14">
                    </div>
                    <div class="input-group half-width">
                        <label for="telefone" class="visually-hidden">Telefone:</label>
                        <input type="tel" id="telefone" name="telefone" placeholder="Telefone:" required maxlength="15">
                    </div>
                </div>

                <div class="input-group full-width">
                    <label for="email" class="visually-hidden">E-mail:</label>
                    <input type="email" id="email" name="email" placeholder="E-mail:" required>
                </div>
                <div class="input-group full-width">
                    <label for="password" class="visually-hidden">Senha:</label>
                    <input type="password" id="password" name="senha" placeholder="Senha:" required>
                </div>

                <button type="submit" id="btn-proximo" class="submit-button" disabled>REGISTRAR</button>
            </form>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            const form = document.getElementById('loginForm');
            const inputs = form.querySelectorAll('input[required]');
            const btnProximo = document.getElementById('btn-proximo');
            
            const inputCPF = document.getElementById('cpf');
            const inputTelefone = document.getElementById('telefone');
            const inputNome = document.getElementById('nome-completo');

            // 1. BLOQUEAR NÚMEROS NO NOME
            if(inputNome) {
                inputNome.addEventListener('input', function(e) {
                    // Substitui qualquer número (0-9) por nada
                    e.target.value = e.target.value.replace(/[0-9]/g, "");
                    validarCampos();
                });
            }

            // 2. MÁSCARA CPF (XXX.XXX.XXX-XX)
            if(inputCPF) {
                inputCPF.addEventListener('input', function(e) {
                    let value = e.target.value;
                    value = value.replace(/\D/g, ""); // Remove letras
                    
                    if (value.length > 11) value = value.slice(0, 11);

                    value = value.replace(/(\d{3})(\d)/, "$1.$2");
                    value = value.replace(/(\d{3})(\d)/, "$1.$2");
                    value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");

                    e.target.value = value;
                    validarCampos(); 
                });
            }

            // 3. MÁSCARA TELEFONE ((XX) XXXXX-XXXX)
            if(inputTelefone) {
                inputTelefone.addEventListener('input', function(e) {
                    let value = e.target.value;
                    value = value.replace(/\D/g, ""); // Remove letras
                    
                    if (value.length > 11) value = value.slice(0, 11); 

                    value = value.replace(/^(\d{2})(\d)/g, "($1) $2");
                    value = value.replace(/(\d)(\d{4})$/, "$1-$2");

                    e.target.value = value;
                    validarCampos();
                });
            }

            // 4. VALIDAÇÃO DO BOTÃO
            function validarCampos() {
                let todosPreenchidos = true;

                inputs.forEach(input => {
                    if (input.value.trim() === '') todosPreenchidos = false;
                    
                    // Valida tamanho mínimo (CPF e Tel formatados tem pelo menos 14 chars)
                    if (input.id === 'cpf' && input.value.length < 14) todosPreenchidos = false;
                    if (input.id === 'telefone' && input.value.length < 14) todosPreenchidos = false;
                });
                
                btnProximo.disabled = !todosPreenchidos;
            }

            inputs.forEach(input => {
                input.addEventListener('input', validarCampos);
            });
        });
    </script>
</body>
</html>