// Função para redirecionar para a página de comanda
function verComanda(numeroMesa) {
    // Armazena a mesa selecionada
    localStorage.setItem('mesaSelecionada', numeroMesa);
    
    // Redireciona para comandas.html com o parâmetro
    window.location.href = `comandas.html?mesa=${numeroMesa}`;
}

// Função para fechar conta (modal)
function fecharConta(numeroMesa) {
    // Implemente a lógica do modal de pagamento aqui
    console.log(`Fechando conta da mesa ${numeroMesa}`);
    alert(`Função fecharConta para mesa ${numeroMesa} será implementada aqui`);
}

// Funções de navegação
function paginaMesas() {
    // Se já está na página de mesas, não faz nada
    if (!window.location.href.includes('comandas.html')) {
        window.location.href = 'garcom.html';
    }
}

function paginaComanda() {
    // Redireciona para a última mesa visualizada ou mostra alerta
    const mesaSalva = localStorage.getItem('mesaSelecionada');
    if (mesaSalva) {
        window.location.href = `comandas.html?mesa=${mesaSalva}`;
    } else {
        alert('Selecione uma mesa primeiro');
    }
}

// Menu dropdown (se necessário)
document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.querySelector('.menu-button');
    const dropdown = document.querySelector('.menu-dropdown');
    
    menuButton.addEventListener('click', function() {
        dropdown.classList.toggle('active');
        menuButton.setAttribute('aria-expanded', 
                              dropdown.classList.contains('active'));
    });
});