let addTable = document.getElementById("add-table");

let qtde_mesas = 8;

function adicionarMesa() {
    let novaMesa = document.createElement("div");
    novaMesa.className = "card";
    novaMesa.setAttribute("id", `mesa-${qtde_mesas}`);

    novaMesa.innerHTML = `
        <div class="card-body">
            <h2 class="card-title">
                Mesa ${qtde_mesas}
                <span class="ribbon available"></span>
            </h2>
            <p class="card-text">
                <i class="fi fi-rr-users"></i>
                <span class="card-itemtitle">Capacidade: </span><span id="capacity">4</span> pessoas
            </p>
        </div>
        <div class="card-buttons">
            <button class="card-btn primary" onclick="editarMesa('mesa-${qtde_mesas}')">Editar</button>
            <button class="card-btn alternate" onclick="excluirMesa('mesa-${qtde_mesas}')">Excluir</button>
        </div>`;

    // Insere a nova mesa antes do botão "Adicionar"
    document.getElementById("pagina-mesa").insertBefore(novaMesa, addTable);

    qtde_mesas += 1;
}

function editarMesa(mesaId) {
    // Obtém o elemento da mesa que foi clicada
    let mesa = document.getElementById(mesaId);

    // Obtém o número da mesa e a capacidade atual
    let numeroMesa = mesa.querySelector(".card-title").textContent.trim();
    let capacidadeAtual = mesa.querySelector(".card-text span:nth-child(3)").textContent.trim();

    // Preenche o modal com os dados da mesa selecionada
    document.getElementById("tableId").value = numeroMesa.replace("Mesa ", ""); // Apenas o número da mesa
    document.getElementById("tableCapacity").value = capacidadeAtual.replace(" pessoas", "");

    // Exibe o modal de edição
    document.getElementById("modalOverlayMesa").style.display = "flex";
}

// Adiciona evento ao formulário para salvar as alterações
document.getElementById("newForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita recarregar a página

    // Obtém os novos valores do formulário
    let idMesa = document.getElementById("tableId").value;
    let novaCapacidade = document.getElementById("tableCapacity").value;

    // Seleciona a mesa na tela e atualiza a capacidade
    let mesa = document.getElementById("mesa-" + idMesa);
    if (mesa) {
        let capacidadeTexto = mesa.querySelector(".card-text span:nth-child(3)");
        capacidadeTexto.textContent = novaCapacidade; // Atualiza na tela
    }

    // Fecha o modal
    fecharModal();
});

function excluirMesa(idMesa) {
    let mesa = document.getElementById(idMesa);
    if (mesa) {
        mesa.remove();
    }
}