<?php
session_start();
include 'conexao.php';

// 1. SEGURANÇA
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header("Location: index.php"); 
    exit;
}

// 2. DELETAR (DELETE)
if (isset($_GET['delete_id'])) {
    $id_reserva = intval($_GET['delete_id']); // intval por segurança
    $conn->query("DELETE FROM reservas WHERE id = $id_reserva");
    echo "<script>alert('Reserva excluída!'); window.location.href='admin.php';</script>";
    exit;
}

// 3. PROCESSAR FORMULÁRIO (CRIAR OU ATUALIZAR)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $usuario_id = $_POST['usuario_id'];
    $arena = $_POST['arena'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $duracao = $_POST['duracao'];
    
    // Calcula preço (Regra: Society=150, Outros=80)
    $preco_base = (strpos($arena, 'Society') !== false) ? 150 : 80; 
    $valor_total = $preco_base * $duracao;
    
    // AÇÃO: EDITAR (UPDATE)
    if (isset($_POST['acao']) && $_POST['acao'] == 'editar') {
        $id_editar = $_POST['id_reserva'];
        
        $sql = "UPDATE reservas SET usuario_id=?, arena=?, data_reserva=?, hora_inicio=?, duracao=?, valor_total=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssidi", $usuario_id, $arena, $data, $hora, $duracao, $valor_total, $id_editar);
        
        if ($stmt->execute()) {
            echo "<script>alert('Reserva ATUALIZADA com sucesso!'); window.location.href='admin.php';</script>";
        } else {
            echo "<script>alert('Erro ao atualizar: " . $stmt->error . "');</script>";
        }
    
    // AÇÃO: CADASTRAR (CREATE)
    } else {
        $pagamento = 'Balcão'; 
        $sql = "INSERT INTO reservas (usuario_id, arena, data_reserva, hora_inicio, duracao, valor_total, pagamento) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isssids", $usuario_id, $arena, $data, $hora, $duracao, $valor_total, $pagamento);
        
        if ($stmt->execute()) {
            echo "<script>alert('Reserva CRIADA com sucesso!'); window.location.href='admin.php';</script>";
        } else {
            echo "<script>alert('Erro ao criar: " . $stmt->error . "');</script>";
        }
    }
}

// 4. BUSCAR DADOS PARA EDIÇÃO (READ UNICO)
$dados_edit = null;
if (isset($_GET['edit_id'])) {
    $id_edit = intval($_GET['edit_id']);
    $result_edit = $conn->query("SELECT * FROM reservas WHERE id = $id_edit");
    $dados_edit = $result_edit->fetch_assoc();
}

// 5. LISTAR TODAS (READ GERAL)
$sql_reservas = "SELECT r.*, u.nome as nome_cliente 
                 FROM reservas r 
                 JOIN usuarios u ON r.usuario_id = u.id 
                 ORDER BY r.data_reserva DESC, r.hora_inicio ASC";
$result_reservas = $conn->query($sql_reservas);

// Busca usuários para o select
$result_usuarios = $conn->query("SELECT id, nome, email FROM usuarios ORDER BY nome ASC");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Admin - CRUD Completo</title>
    <style>
        /* === ESTILOS (Mantendo o padrão Azul e Laranja) === */
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333; margin: 0; }
        header { background-color: #000033; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        
        /* Tabela */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #000033; color: white; }
        
        /* Botões */
        .btn { padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 12px; color: white; display: inline-block; margin: 2px;}
        .btn-edit { background-color: #ffc107; color: black; } /* Amarelo */
        .btn-delete { background-color: #dc3545; } /* Vermelho */
        .btn-sair { background-color: #FE4701; padding: 8px 15px; font-weight: bold; text-decoration: none; color: white; border-radius: 4px;}

        /* Formulário */
        .form-box { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 5px; margin-top: 20px; }
        .form-title { color: #FE4701; border-bottom: 2px solid #ddd; padding-bottom: 10px; margin-top: 0; }
        
        input, select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box; }
        
        .btn-submit { background-color: #28a745; color: white; padding: 12px; border: none; width: 100%; cursor: pointer; font-size: 16px; }
        .btn-submit:hover { background-color: #218838; }
        
        .btn-cancel { background-color: #6c757d; color: white; text-align: center; display: block; padding: 10px; margin-top: 10px; text-decoration: none; border-radius: 4px; }
        
        .row { display: flex; gap: 15px; }
        .col { flex: 1; }
    </style>
</head>
<body>

    <header>
        <h1>Painel Administrativo</h1>
        <a href="logout.php" class="btn-sair">Sair</a>
    </header>

    <div class="container">
        
        <h2>Reservas Agendadas</h2>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Arena</th>
                    <th>Data</th>
                    <th>Horário</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result_reservas->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['nome_cliente']); ?></td>
                    <td><?php echo htmlspecialchars($row['arena']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['data_reserva'])); ?></td>
                    <td><?php echo $row['hora_inicio']; ?> (<?php echo $row['duracao']; ?>h)</td>
                    <td>R$ <?php echo number_format($row['valor_total'], 2, ',', '.'); ?></td>
                    <td>
                        <a href="admin.php?edit_id=<?php echo $row['id']; ?>#formulario" class="btn btn-edit">Editar</a>
                        <a href="admin.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-delete" onclick="return confirm('Tem certeza?');">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="form-box" id="formulario">
            <h3 class="form-title"><?php echo $dados_edit ? 'Editar Reserva #' . $dados_edit['id'] : 'Adicionar Nova Reserva'; ?></h3>
            
            <form action="admin.php" method="POST">
                
                <?php if ($dados_edit): ?>
                    <input type="hidden" name="acao" value="editar">
                    <input type="hidden" name="id_reserva" value="<?php echo $dados_edit['id']; ?>">
                <?php else: ?>
                    <input type="hidden" name="acao" value="cadastrar">
                <?php endif; ?>

                <label>Cliente:</label>
                <select name="usuario_id" required>
                    <option value="">Selecione...</option>
                    <?php 
                    // Reinicia o loop de usuários
                    $result_usuarios->data_seek(0); 
                    while($user = $result_usuarios->fetch_assoc()): 
                        // Verifica se deve selecionar este usuário (no caso de edição)
                        $selected = ($dados_edit && $dados_edit['usuario_id'] == $user['id']) ? 'selected' : '';
                    ?>
                        <option value="<?php echo $user['id']; ?>" <?php echo $selected; ?>>
                            <?php echo $user['nome']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label>Arena:</label>
                <select name="arena" required>
                    <?php 
                        $arenas = ["Arena Vôlei A", "Arena Vôlei B", "Arena Beach A", "Arena Beach B", "Arena Society A", "Arena Society B"];
                        foreach ($arenas as $a) {
                            $sel = ($dados_edit && $dados_edit['arena'] == $a) ? 'selected' : '';
                            echo "<option value='$a' $sel>$a</option>";
                        }
                    ?>
                </select>

                <div class="row">
                    <div class="col">
                        <label>Data:</label>
                        <input type="date" name="data" required value="<?php echo $dados_edit ? $dados_edit['data_reserva'] : ''; ?>">
                    </div>
                    <div class="col">
                        <label>Horário:</label>
                        <select name="hora" required>
                            <?php 
                                for ($h = 8; $h <= 22; $h++) {
                                    $hora_fmt = sprintf("%02d:00", $h);
                                    $sel = ($dados_edit && substr($dados_edit['hora_inicio'], 0, 5) == $hora_fmt) ? 'selected' : '';
                                    echo "<option value='$hora_fmt' $sel>$hora_fmt</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col">
                        <label>Duração:</label>
                        <select name="duracao" required>
                            <option value="1" <?php echo ($dados_edit && $dados_edit['duracao'] == 1) ? 'selected' : ''; ?>>1 Hora</option>
                            <option value="2" <?php echo ($dados_edit && $dados_edit['duracao'] == 2) ? 'selected' : ''; ?>>2 Horas</option>
                            <option value="3" <?php echo ($dados_edit && $dados_edit['duracao'] == 3) ? 'selected' : ''; ?>>3 Horas</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <?php echo $dados_edit ? 'Atualizar Reserva' : 'Adicionar Reserva'; ?>
                </button>
                
                <?php if ($dados_edit): ?>
                    <a href="admin.php" class="btn-cancel">Cancelar Edição</a>
                <?php endif; ?>

            </form>
        </div>

    </div>
</body>
</html>