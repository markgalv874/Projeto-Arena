<?php
session_start();
include 'conexao.php';

// Ativa exibição de erros para debug (caso precise)
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara a busca no banco para evitar SQL Injection
    $sql = "SELECT id, nome, senha, tipo FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    
    if($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Verifica se a senha bate com a criptografia
            if (password_verify($senha, $row['senha'])) {
                
                // CRIA A SESSÃO DO USUÁRIO
                $_SESSION['usuario_id'] = $row['id'];
                $_SESSION['usuario_nome'] = $row['nome'];
                $_SESSION['usuario_tipo'] = $row['tipo'];

                // Redireciona
                if($row['tipo'] == 'admin'){
                    header("Location: admin.php");
                } else {
                    header("Location: reserva.php");
                }
                exit; 
            } else {
                echo "<script>alert('Senha incorreta!'); window.location.href='login.php';</script>";
            }
        } else {
            echo "<script>alert('Usuário não encontrado!'); window.location.href='login.php';</script>";
        }
    } else {
        echo "Erro no banco de dados: " . $conn->error;
    }
} else {
    // Se tentar abrir o arquivo direto sem enviar formulário, volta pro login
    header("Location: login.php");
    exit;
}
?>