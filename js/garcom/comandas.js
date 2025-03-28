document.addEventListener('DOMContentLoaded', function() {
    // Recupera o número da mesa da URL
    const urlParams = new URLSearchParams(window.location.search);
    const mesaNumero = urlParams.get('mesa') || localStorage.getItem('mesaSelecionada');
    
    if (!mesaNumero) {
        window.location.href = 'garcom.html';
        return;
    }

    // Elementos do DOM
    const numeroMesaSpan = document.getElementById('numero-mesa');
    const modalNumeroMesa = document.getElementById('modal-numero-mesa');
    const historicoList = document.getElementById('historico-list');
    const itensAtuais = document.getElementById('itens-atuais');
    const totalValor = document.getElementById('total-valor');
    const adicionarItemForm = document.getElementById('adicionar-item-form');
    const concluirBtn = document.getElementById('concluir-btn');
    const finalizarMesaBtn = document.getElementById('finalizar-mesa-btn');

    // Dados da comanda
    let comandaAtual = {
        mesa: mesaNumero,
        itens: [],
        historico: [],
        total: 0
    };

    // Cardápio
    const cardapio = {
        '1': { nome: 'Cheeseburger Clássico', preco: 29.90 },
        '2': { nome: 'Filé Mignon Grelhado', preco: 59.90 },
        '3': { nome: 'Lasanha à Bolonhesa', preco: 42.90 },
        '4': { nome: 'Nuggets de Frango', preco: 19.90 },
        '5': { nome: 'Mini Pizza de Queijo', preco: 22.90 },
        '6': { nome: 'Água Mineral', preco: 9.90 },
        '7': { nome: 'Chopp Artesanal', preco: 4.90 },
        '8': { nome: 'Batata Frita', preco: 12.90 },
        '9': { nome: 'Suco de Laranja Natural', preco: 14.40 }
    };

    // Inicialização
    function init() {
        numeroMesaSpan.textContent = mesaNumero;
        modalNumeroMesa.textContent = mesaNumero;
        
        // Carrega dados salvos
        const dadosSalvos = localStorage.getItem(`comanda_${mesaNumero}`);
        if (dadosSalvos) {
            comandaAtual = JSON.parse(dadosSalvos);
        }
        
        atualizarHistorico();
        atualizarItensAtuais();
    }

    // Atualiza o histórico de pedidos
    function atualizarHistorico() {
        historicoList.innerHTML = '';
        
        if (comandaAtual.historico.length === 0) {
            historicoList.innerHTML = '<p>Nenhum pedido anterior</p>';
            return;
        }

        comandaAtual.historico.forEach(pedido => {
            const pedidoDiv = document.createElement('div');
            pedidoDiv.className = 'pedido-historico';
            
            const data = new Date(pedido.timestamp);
            const dataFormatada = data.toLocaleString('pt-BR');
            
            let itensHTML = pedido.itens.map(item => `
                <div class="item-historico">
                    <span>${item.quantidade}x ${item.nome}</span>
                    <span>R$ ${item.subtotal.toFixed(2)}</span>
                </div>
            `).join('');
            
            pedidoDiv.innerHTML = `
                <h4>${dataFormatada} - ${pedido.status === 'enviado' ? 'Enviado' : 'Finalizado'}</h4>
                ${itensHTML}
                <div class="total-pedido">Total: R$ ${pedido.total.toFixed(2)}</div>
            `;
            
            historicoList.appendChild(pedidoDiv);
        });
    }

    // Atualiza os itens atuais
    function atualizarItensAtuais() {
        itensAtuais.innerHTML = '';
        comandaAtual.total = 0;
        
        if (comandaAtual.itens.length === 0) {
            itensAtuais.innerHTML = '<p>Nenhum item adicionado</p>';
            totalValor.textContent = '0,00';
            return;
        }

        comandaAtual.itens.forEach((item, index) => {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'item-atual';
            
            itemDiv.innerHTML = `
                <div class="info-item">
                    <span>${item.quantidade}x ${item.nome}</span>
                    <span>R$ ${item.subtotal.toFixed(2)}</span>
                </div>
                ${item.observacoes ? `<div class="observacoes">${item.observacoes}</div>` : ''}
                <button class="remover-item" data-index="${index}">
                    <i class="fi fi-rr-trash"></i>
                </button>
            `;
            
            itensAtuais.appendChild(itemDiv);
            comandaAtual.total += item.subtotal;
        });
        
        totalValor.textContent = comandaAtual.total.toFixed(2);
        salvarComanda();
        
        // Adiciona eventos aos botões de remover
        document.querySelectorAll('.remover-item').forEach(btn => {
            btn.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                comandaAtual.itens.splice(index, 1);
                atualizarItensAtuais();
            });
        });
    }

    // Salva a comanda no localStorage
    function salvarComanda() {
        localStorage.setItem(`comanda_${mesaNumero}`, JSON.stringify(comandaAtual));
    }

    // Evento para adicionar item
    adicionarItemForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const itemId = document.getElementById('item-select').value;
        const quantidade = parseInt(document.getElementById('quantidade').value);
        const observacoes = document.getElementById('observacoes').value;
        
        if (!itemId || isNaN(quantidade) || quantidade < 1) return;
        
        const item = cardapio[itemId];
        const novoItem = {
            id: itemId,
            nome: item.nome,
            precoUnitario: item.preco,
            quantidade: quantidade,
            subtotal: item.preco * quantidade,
            observacoes: observacoes,
            timestamp: new Date().toISOString()
        };
        
        comandaAtual.itens.push(novoItem);
        adicionarItemForm.reset();
        atualizarItensAtuais();
    });

    // Evento para enviar para cozinha
    concluirBtn.addEventListener('click', function() {
        if (comandaAtual.itens.length === 0) {
            alert('Adicione itens antes de enviar!');
            return;
        }
        
        const novoPedido = {
            timestamp: new Date().toISOString(),
            itens: [...comandaAtual.itens],
            total: comandaAtual.total,
            status: 'enviado'
        };
        
        comandaAtual.historico.push(novoPedido);
        comandaAtual.itens = [];
        comandaAtual.total = 0;
        
        salvarComanda();
        atualizarHistorico();
        atualizarItensAtuais();
        
        alert('Pedido enviado para cozinha!');
    });

    // Evento para fechar conta
    finalizarMesaBtn.addEventListener('click', function() {
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
    });

    // Evento para confirmar pagamento
    document.getElementById('confirmar-pagamento-btn').addEventListener('click', function() {
        const metodoPagamento = document.getElementById('metodo-pagamento').value;
        
        if (metodoPagamento === 'dinheiro') {
            const troco = parseFloat(document.getElementById('troco-valor').textContent);
            if (troco < 0) {
                alert('Valor recebido insuficiente!');
                return;
            }
        }
        
        // Marca como pago
        document.getElementById('mensagem-pago').style.display = 'block';
        document.getElementById('confirmar-pagamento-btn').style.display = 'none';
        document.getElementById('cancelar-fechamento-btn').style.display = 'none';
        
        // Limpa a comanda após 2 segundos
        setTimeout(() => {
            comandaAtual = {
                mesa: mesaNumero,
                itens: [],
                historico: comandaAtual.historico,
                total: 0
            };
            
            salvarComanda();
            document.getElementById('modal-fechamento').style.display = 'none';
            window.location.href = 'garcom.html';
        }, 2000);
    });

    // Evento para cancelar pagamento
    document.getElementById('cancelar-fechamento-btn').addEventListener('click', function() {
        document.getElementById('modal-fechamento').style.display = 'none';
    });

    // Inicializa a página
    init();
});