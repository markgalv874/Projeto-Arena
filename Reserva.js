document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Elementos do Cálculo
    const arenaSelect = document.getElementById('arena-select');
    const duracaoSelect = document.getElementById('duracao');
    const valorTotalDisplay = document.getElementById('valor-total');
    const inputPagamento = document.getElementById('metodo-pagamento');
    const cardsPagamento = document.querySelectorAll('.payment-card');

    // 2. Função de Calcular Preço
    function atualizarPreco() {
        // Pega a opção selecionada
        const option = arenaSelect.options[arenaSelect.selectedIndex];
        
        // Pega o preço que está no atributo data-preco (ou 0 se não tiver)
        const precoPorHora = parseFloat(option.getAttribute('data-preco')) || 0;
        
        // Pega a duração
        const horas = parseInt(duracaoSelect.value);
        
        // Calcula
        const total = precoPorHora * horas;

        // Formata para Real (R$ 0,00)
        valorTotalDisplay.textContent = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }

    // 3. Ouve as mudanças nos selects para recalcular
    arenaSelect.addEventListener('change', atualizarPreco);
    duracaoSelect.addEventListener('change', atualizarPreco);

    // 4. Lógica de Seleção de Pagamento (Visual e Input Oculto)
    // Precisamos definir a função no escopo global (window) porque você usa onclick no HTML
    window.selecionarPagamento = function(tipo, elementoCard) {
        
        // Remove a classe 'selected' de todos
        cardsPagamento.forEach(card => card.classList.remove('selected'));

        // Adiciona no clicado
        elementoCard.classList.add('selected');

        // Atualiza o input escondido que vai pro PHP
        inputPagamento.value = tipo;
        
        console.log("Pagamento selecionado: " + tipo); // Para teste
    };

    // Chama o cálculo uma vez ao carregar para garantir
    atualizarPreco();
});