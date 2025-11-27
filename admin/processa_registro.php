<?php
include 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    // Criptografa a senha para segurança
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // 1. Verifica se o e-mail já existe
    $checkEmail = $conn->query("SELECT id FROM usuarios WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        echo "<script>
            alert('Este e-mail já está cadastrado!');
            window.location.href='registro.php';
        </script>";
        exit;
    }

    // 2. Prepara o cadastro
    $sql = "INSERT INTO usuarios (nome, cpf, telefone, email, senha) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssss", $nome, $cpf, $telefone, $email, $senha);
        
        // 3. Executa e Redireciona Automaticamente
        if ($stmt->execute()) {
            echo "<script>
                alert('Cadastro realizado com sucesso!');
                window.location.href = 'login.php'; // Redirecionamento automático aqui
            </script>";
        } else {
            echo "<script>
                alert('Erro ao cadastrar: " . addslashes($stmt->error) . "');
                window.location.href='registro.php';
            </script>";
        }
    } else {
        echo "<script>alert('Erro no banco de dados.'); window.location.href='registro.php';</script>";
    }
}
?>