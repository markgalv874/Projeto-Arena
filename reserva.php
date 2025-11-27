<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva e Pagamento - Arena Beach</title>
    <link rel="stylesheet" href="styleReserva.css">
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
        <h1 class="title">RESERVA</h1>

        <section class="form-section">
            <h2 class="section-title">1. Escolha sua Arena e Horário</h2>
            
            <form id="reservaForm" action="salvar_reserva.php" method="POST">
                
                <div class="input-group full-width">
                    <label class="label-custom">Selecione a Quadra/Campo:</label>
                    <select id="arena-select" class="input-custom" name="arena" required>
                        <option value="" data-preco="0">Selecione uma opção...</option>
                        <option value="areia1" data-preco="80">Arena Vôlei de Praia A  - R$ 80,00/h</option>
                        <option value="areia2" data-preco="80">Arena Vôlei de Praia B  - R$ 80,00/h</option>
                        <option value="areia3" data-preco="80">Arena Beach-tennis A  - R$ 80,00/h</option>
                        <option value="areia4" data-preco="80">Arena Beach-tennis B - R$ 80,00/h</option>
                        <option value="society" data-preco="150">Arena Society A - R$ 150,00/h</option>
                        <option value="society" data-preco="150">Arena Society B  - R$ 150,00/h</option>
                    </select>
                </div>

                <div class="input-row">
                    <div class="input-group half-width">
                        <label class="label-custom">Data:</label>
                        <input type="date" name="data" id="data-reserva" class="input-custom" required>
                    </div>
                    <div class="input-group half-width">
                        <label class="label-custom">Horário de Início:</label>
                        <select id="hora-inicio" name="hora" class="input-custom" required>
                            <option value="">Escolha um horário...</option>
                            <option value="08:00">08:00</option>
                            <option value="09:00">09:00</option>
                            <option value="10:00">10:00</option>
                            <option value="11:00">11:00</option>
                            <option value="12:00">12:00</option>
                            <option value="13:00">13:00</option>
                            <option value="14:00">14:00</option>
                            <option value="15:00">15:00</option>
                            <option value="16:00">16:00</option>
                            <option value="17:00">17:00</option>
                            <option value="18:00">18:00</option>
                            <option value="19:00">19:00</option>
                            <option value="20:00">20:00</option>
                            <option value="21:00">21:00</option>
                            <option value="22:00">22:00</option>
                            <option value="23:00">23:00</option>
                        </select>
                    </div>
                </div>

                <div class="input-group full-width">
                    <label class="label-custom">Quantas horas de jogo?</label>
                    <select id="duracao" name="duracao" class="input-custom">
                        <option value="1">1 Hora</option>
                        <option value="2">2 Horas</option>
                        <option value="3">3 Horas</option>
                        <option value="4">4 Horas</option>
                    </select>
                </div>

                <div class="price-display">
                    <span>Total a Pagar:</span>
                    <span id="valor-total">R$ 0,00</span>
                </div>

                <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ddd;">

                <h2 class="section-title">2. Forma de Pagamento</h2>
                
                <div class="payment-options">
                    <div class="payment-card" onclick="selecionarPagamento('pix', this)">
                        <div class="card-icon">💠</div> <h3>PIX</h3>
                        <p>Aprovação imediata</p>
                    </div>

                    <div class="payment-card" onclick="selecionarPagamento('credito', this)">
                        <div class="card-icon">💳</div>
                        <h3>Cartão de Crédito</h3>
                        <p>Até 3x sem juros</p>
                    </div>

                    <div class="payment-card" onclick="selecionarPagamento('boleto', this)">
                        <div class="card-icon">📄</div>
                        <h3>Boleto</h3>
                        <p>Até 3 dias úteis</p>
                    </div>
                </div>
                
                <input type="hidden" name="pagamento" id="metodo-pagamento" required>

                <button type="submit" class="submit-button">FINALIZAR RESERVA</button>
            </form>
        </section>
    </main>

    <script src="Reserva.js"></script>
</body>
</html>