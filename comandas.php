<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comanda | Restaurante X</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/comandas.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
</head>
<body>
    <header>
        <div class="menubar">
            <div class="menu-container">
                <button class="menu-button" aria-haspopup="true" aria-expanded="false"><i class="fi fi-rr-menu-burger"></i></button>
                <div class="menu-dropdown" aria-label="Menu dropdown">
                    <a id="cardapio" href="#" onclick="paginaMesas()">Mesas</a>
                 </div>
            </div>
            <div>
                <h1>Restaurante X</h1>
            </div>
            <nav>
                <a id="cardapio" href="#" onclick="paginaMesas()">Mesas</a>
            </nav>
            <div>
                <span>Garçom</span>
                <i class="fi fi-rr-circle-user"></i>
                
                <form action="logout.php" method="post">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <main>
        <section id="pagina-cardapio" class="container-cardapio">
            <div class="content-card">
            <button class="btn-voltar" onclick="window.location.href='garcom.php'">
                <i class="fi fi-rr-arrow-left"></i> Voltar para Mesas
            </button>
            
            <h2>Comanda da Mesa <span id="numero-mesa"></span></h2>
            
            <div id="historico-pedidos">
                <h3>Histórico de Pedidos</h3>
                <div id="historico-list"></div>
            </div>
            
            <div id="itens-comanda">
                <h3>Itens Atuais</h3>
                <div id="itens-atuais"></div>
            </div>
            
            <div id="total-comanda">
                <strong>Total: R$ <span id="total-valor">0,00</span></strong>
            </div>
            
            <form id="adicionar-item-form">
                <h3>Adicionar Item</h3>
                <select id="item-select" required>
                    <option value="" disabled selected>Selecione um item</option>
                    <option value="1">Cheeseburger Clássico	    29.90</option>
                    <option value="2">Filé Mignon Grelhado	    59.90</option>
                    <option value="3">Lasanha à Bolonhesa       42.90</option>
                    <option value="4">Nuggets de Frango		    19.90</option>
                    <option value="5">Mini Pizza de Queijo	    22.90</option>
                    <option value="6">Suco de Laranja Natural	9.90</option>
                    <option value="7">Água Mineral	Bebidas     4.90</option>
                    <option value="8">Chopp Artesanal		    12.90</option>
                    <option value="9">Batata Frita	        	14.90</option>
                </select>
                <input type="number" id="quantidade" min="1" value="1" required>
                <textarea id="observacoes" placeholder="Observações (opcional)"></textarea>
                <button type="submit">Adicionar Item</button>
            </form>
            
            <div class="botoes-comanda">
                <button id="concluir-btn">Enviar para Cozinha</button>
                <button id="finalizar-mesa-btn" class="finalizar">Fechar Conta</button>
            </div>
        </div>
        </section>

        <!-- Modal de Fechamento -->
        <div id="modal-fechamento">
            <div class="modal-conteudo">
                <h2>Fechamento da Mesa <span id="modal-numero-mesa"></span></h2>
                <div id="resumo-pedidos"></div>
                <div id="total-modal">Total: R$ 0,00</div>
                
                <div class="forma-pagamento">
                    <label for="metodo-pagamento">Forma de Pagamento:</label>
                    <select id="metodo-pagamento">
                        <option value="dinheiro">Dinheiro</option>
                        <option value="cartao">Cartão</option>
                        <option value="pix">PIX</option>
                    </select>
                </div>
                
                <div id="valor-recebido-container" style="display: none;">
                    <label for="valor-recebido">Valor Recebido:</label>
                    <input type="number" id="valor-recebido" step="0.01" min="0">
                </div>
                
                <div id="troco-container" style="display: none;">
                    Troco: R$ <span id="troco-valor">0,00</span>
                </div>
                
                <div id="mensagem-pago" style="display: none;">
                    Mesa liberada com sucesso!
                </div>
                
                <div class="botoes-modal">
                    <button id="cancelar-fechamento-btn">Cancelar</button>
                    <button id="confirmar-pagamento-btn">Confirmar</button>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-info">
            <p>&copy; 2025 Restaurante X. Todos os direitos reservados.</p>
            <p><a href="#">Contato</a> | <a href="#">Sobre</a></p>
        </div>
    </footer>

    <script src="js/garcom/comandas.js"></script>
    <script src="js/garcom/garcom.js"></script>
</body>
</html>