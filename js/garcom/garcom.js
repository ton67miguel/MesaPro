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
   if (comandaAtual.itens.length > 0 && !confirm('Há itens não enviados para cozinha. Deseja fechar mesmo assim?')) {
            return;
        }
        
        // Preenche o modal
        document.getElementById('resumo-pedidos').innerHTML = '';
        
        // Calcula o total geral
        let totalGeral = comandaAtual.itens.reduce((sum, item) => sum + item.subtotal, 0);
        totalGeral += comandaAtual.historico.reduce((sum, pedido) => sum + pedido.total, 0);
        
        document.getElementById('total-modal').textContent = `Total: R$ ${totalGeral.toFixed(2)}`;
        
        // Adiciona itens atuais ao resumo (se houver)
        if (comandaAtual.itens.length > 0) {
            const divItens = document.createElement('div');
            divItens.innerHTML = '<h3>Itens não enviados:</h3>';
            
            comandaAtual.itens.forEach(item => {
                divItens.innerHTML += `
                    <div class="item-resumo">
                        <span>${item.quantidade}x ${item.nome}</span>
                        <span>R$ ${item.subtotal.toFixed(2)}</span>
                    </div>
                `;
            });
            
            document.getElementById('resumo-pedidos').appendChild(divItens);
        }
        
        // Adiciona histórico ao resumo
        if (comandaAtual.historico.length > 0) {
            const divHistorico = document.createElement('div');
            divHistorico.innerHTML = '<h3>Pedidos anteriores:</h3>';
            
            comandaAtual.historico.forEach(pedido => {
                const data = new Date(pedido.timestamp);
                divHistorico.innerHTML += `
                    <div class="pedido-resumo">
                        <h4>${data.toLocaleString('pt-BR')}</h4>
                        ${pedido.itens.map(item => `
                            <div class="item-resumo">
                                <span>${item.quantidade}x ${item.nome}</span>
                                <span>R$ ${item.subtotal.toFixed(2)}</span>
                            </div>
                        `).join('')}
                        <div class="total-pedido">Subtotal: R$ ${pedido.total.toFixed(2)}</div>
                    </div>
                `;
            });
            
            document.getElementById('resumo-pedidos').appendChild(divHistorico);
        }
        
        // Configura o modal de pagamento
        document.getElementById('metodo-pagamento').addEventListener('change', function() {
            const metodo = this.value;
            const trocoContainer = document.getElementById('troco-container');
            const valorContainer = document.getElementById('valor-recebido-container');
            
            if (metodo === 'dinheiro') {
                trocoContainer.style.display = 'block';
                valorContainer.style.display = 'block';
                document.getElementById('valor-recebido').value = '';
                document.getElementById('troco-valor').textContent = '0,00';
            } else {
                trocoContainer.style.display = 'none';
                valorContainer.style.display = 'none';
            }
        });
        
        document.getElementById('valor-recebido').addEventListener('input', function() {
            const total = parseFloat(document.getElementById('total-modal').textContent.replace(/[^\d.]/g, ''));
            const recebido = parseFloat(this.value) || 0;
            const troco = recebido - total;
            document.getElementById('troco-valor').textContent = troco.toFixed(2);
        });
        
        // Mostra o modal
        document.getElementById('modal-fechamento').style.display = 'flex';
    
    
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
//document.addEventListener('DOMContentLoaded', function() {
//    const menuButton = document.querySelector('.menu-button');
//    const dropdown = document.querySelector('.menu-dropdown');
//    
//    menuButton.addEventListener('click', function() {
//        dropdown.classList.toggle('active');
//        menuButton.setAttribute('aria-expanded', 
//                              dropdown.classList.contains('active'));
//    });
//});
document.addEventListener("DOMContentLoaded", () => {
    fetch("buscar_mesas.php")
        .then(response => response.json())
        .then(mesas => {
            const container = document.getElementById("pagina-mesa");
            container.innerHTML = "";

            mesas.forEach(mesa => {
                const card = document.createElement("div");
                card.className = "card";
                card.id = `mesa-${mesa.numero}`;

                // Define a classe da fita de status
                let ribbonClass = "";
                switch (mesa.status) {
                    case "Disponível":
                        ribbonClass = "available";
                        break;
                    case "Reservada":
                        ribbonClass = "reserved";
                        break;
                    case "Ocupada":
                        ribbonClass = "occupied";
                        break;
                }

                // Botão "Ver Comanda" só habilita se estiver Ocupada
                const botaoVer = mesa.status === "Ocupada"
                    ? `<button class="card-btn primary" onclick="verComanda('${mesa.numero}')">Ver Comanda</button>`
                    : `<button class="card-btn primary" disabled>Ver Comanda</button>`;

                card.innerHTML = `
                    <div class="card-body">
                        <h2 class="card-title">
                            Mesa ${mesa.numero}
                            <span class="ribbon ${ribbonClass}"></span>
                        </h2>
                        <p class="card-text">
                            <i class="fi fi-rr-users"></i>
                            <span class="card-itemtitle">Capacidade: </span>
                            <span class="capacity">${mesa.capacidade}</span> pessoas
                        </p>
                        <p class="card-text">
                            <i class="fi fi-rr-utensils"></i>
                            <span class="card-itemtitle">Status: </span>
                            <span>${mesa.status}</span>
                        </p>
                    </div>
                    <div class="card-buttons">
                        ${botaoVer}
                        <button class="card-btn alternate" onclick="fecharConta('${mesa.numero}')">Fechar Conta</button>
                    </div>
                `;

                container.appendChild(card);
            });
        })
        .catch(error => {
            console.error("Erro ao buscar mesas:", error);
        });
});
