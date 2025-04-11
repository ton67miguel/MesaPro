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
                <a id="cardapio" href="#" onclick="window.location.href='garcom.html'">Mesas</a>
            </nav>
            <div>
                <span>Garçom</span>
                <i class="fi fi-rr-circle-user"></i>
            </div>
        </div>
    </header>

    <div class="background-pattern">
        <div class="comanda-container">
            <div class="comanda-header">
                <h2 id="titulo-mesa">Mesa</h2>
                <button class="btn" onclick="window.location.href='garcom.html'">⬅ Voltar para mesas</button>
            </div>
            <p><strong>🣍️ Capacidade:</strong> <span id="capacidade"></span> pessoas</p>
            <p><strong>🍽 Pedido:</strong> <span id="status-pedido"></span></p>
            <p><strong>⏳ Tempo de espera:</strong> <span id="tempo-espera">--</span> minutos</p>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Produto</th>
                        <th>Preço (R$)</th>
                        <th>Quantidade</th>
                        <th>Informações</th>
                    </tr>
                </thead>
                <tbody id="lista-pedidos">
                </tbody>
            </table>

            <div class="total">Total: R$ 0,00</div>

            <div class="btn-group">
                <button id="openModalBtn" class="btn">+ Registrar pedido</button>
                <button id="openFinalizarModal" class="btn">Finalizar pedido</button>
            </div>
        </div>
    </div>

    <!-- Modal Registrar Pedido -->
    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close-btn" onclick="fecharModal()">&times;</span>
            <form id="formRegistrar">
                <label for="produto">Selecionar Item</label>
                <select id="produto" required>
                    <option value="">Selecione</option>
                    <option value="001|Cheeseburger Clássico|19.90">Cheeseburger Clássico</option>
                    <option value="008|Chopp Artesanal|12.90">Chopp Artesanal</option>
                    <option value="009|Batata Frita|14.90">Batata Frita</option>
                </select>

                <label for="quantidade">Quantidade</label>
                <select id="quantidade">
                    <option>1</option><option>2</option><option>3</option><option>4</option><option>5</option>
                </select>

                <label for="observacao">Observação</label>
                <textarea id="observacao" rows="3" placeholder="Ex: sem cebola, sem mostarda..."></textarea>
                <button type="submit" class="btn-adicionar">Adicionar</button>
            </form>
        </div>
    </div>

    <!-- Modal Finalizar Pedido -->
    <div id="modalFinalizar" class="modal modal-finalizar">
        <div class="modal-content">
            <span class="close-btn" onclick="fecharModalFinalizar()">&times;</span>
            <h3>Finalizar Pedido</h3>
            <div id="resumoPedido"></div>

            <label for="pagamento">Forma de Pagamento</label>
            <select id="pagamento">
                <option>Dinheiro</option>
                <option>Cartão Débito</option>
                <option>Cartão Crédito</option>
                <option>Pix</option>
            </select>

            <div class="btn-group">
                <button class="btn" onclick="fecharModalFinalizar()">Cancelar</button>
                <button class="btn" onclick="finalizarPedido()">Fechar conta</button>
            </div>
        </div>
    </div>
    <script src="js/garcom/comandas.js"></script>
    <script src="js/garcom/garcom.js"></script>
</body>
</html>
