document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Seleciona os elementos da tela
    const form = document.getElementById('loginForm');
    const inputs = form.querySelectorAll('input[required]');
    const btnProximo = document.getElementById('btn-proximo');
    
    const inputCPF = document.getElementById('cpf');
    const inputTelefone = document.getElementById('telefone');
    const inputNome = document.getElementById('nome-completo');

    // === AQUI ESTÁ O BLOQUEIO DE NÚMEROS NO NOME ===
    if(inputNome) {
        inputNome.addEventListener('input', function(e) {
            // Troca qualquer número (0-9) por vazio
            e.target.value = e.target.value.replace(/[0-9]/g, "");
            validarCampos();
        });
    }

    // 2. Máscara de CPF (XXX.XXX.XXX-XX)
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

    // 3. Máscara de Telefone ( (XX) XXXXX-XXXX )
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

    // 4. Validação para liberar o botão
    function validarCampos() {
        let todosPreenchidos = true;

        inputs.forEach(input => {
            if (input.value.trim() === '') todosPreenchidos = false;
            
            // Valida se CPF e Telefone estão completos
            if (input.id === 'cpf' && input.value.length < 14) todosPreenchidos = false;
            if (input.id === 'telefone' && input.value.length < 14) todosPreenchidos = false;
        });
        
        btnProximo.disabled = !todosPreenchidos;
    }

    inputs.forEach(input => {
        input.addEventListener('input', validarCampos);
    });

});