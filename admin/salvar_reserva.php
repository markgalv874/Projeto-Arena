<?php
session_start();
include 'conexao.php';

// Verifica se está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario_id = $_SESSION['usuario_id'];
    $arena = $_POST['arena'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $duracao = $_POST['duracao'];
    $pagamento = $_POST['pagamento'];
    
    // Calcula valor (Simples, baseado no seu JS)
    $preco = ($arena == 'society') ? 150 : 80;
    $valor_total = $preco * $duracao;

    $sql = "INSERT INTO reservas (usuario_id, arena, data_reserva, hora_inicio, duracao, valor_total, pagamento) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssids", $usuario_id, $arena, $data, $hora, $duracao, $valor_total, $pagamento);

    if ($stmt->execute()) {
        echo "<script>alert('Reserva Confirmada!'); window.location.href='index.php';</script>";
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>