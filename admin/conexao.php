<?php
$host = 'localhost';
$usuario = 'root';
$senha = ''; // No XAMPP a senha padrão é vazia
$banco = 'arena_beach';

$conn = new mysqli($host, $usuario, $senha, $banco);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>