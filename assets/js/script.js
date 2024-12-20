document.getElementById('loginForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Impede o envio automático do formulário

    // Obtém os valores dos campos
    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value;

    // Limpa mensagens anteriores
    const errorList = document.getElementById('errorList');
    errorList.innerHTML = '';
    const alertContainer = document.getElementById('alertContainer');
    alertContainer.classList.add('d-none');

    // Validações
    const errors = [];
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Verifica o campo de email
    if (!username) {
        errors.push('O campo email deve ser preenchido.');
    } else if (!emailRegex.test(username)) {
        errors.push('O campo usuário deve ser um email válido.');
    }

    // Verifica o campo de senha (obrigatório)
    if (!password) {
        errors.push('Preencha o campo senha.');
    }

    // Exibe os erros ou envia o formulário
    if (errors.length > 0) {
        errors.forEach((error) => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });
        alertContainer.classList.remove('d-none');
    } else {
        // Se não houver erros, envia o formulário
        this.submit();
    }
});
