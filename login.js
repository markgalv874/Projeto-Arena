document.addEventListener('DOMContentLoaded', function() {
    // 1. Selecionando os elementos do DOM
    const form = document.getElementById('loginForm');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const btnProximo = document.getElementById('btn-proximo');

    // 2. Função para validar formato de e-mail (Regex simples)
    function isEmailValid(email) {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    }

    // 3. Função principal de validação (Apenas visual, libera o botão)
    function validarFormulario() {
        const emailValue = emailInput.value.trim();
        const passwordValue = passwordInput.value.trim();

        // O botão só habilita se: Senha não for vazia E E-mail for válido
        if (passwordValue !== '' && isEmailValid(emailValue)) {
            btnProximo.disabled = false;
            btnProximo.style.cursor = 'pointer'; 
            btnProximo.style.opacity = '1';
        } else {
            btnProximo.disabled = true;
            btnProximo.style.cursor = 'not-allowed';
            btnProximo.style.opacity = '0.7';
        }
    }

    // 4. Ouvintes de evento
    emailInput.addEventListener('input', validarFormulario);
    passwordInput.addEventListener('input', validarFormulario);

    // *** REMOVIDO O BLOQUEIO DE SUBMIT ***
    // Agora, quando clicar, ele envia para processa_login.php
});