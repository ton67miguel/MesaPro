let addTable = document.getElementById("add-table");
let mesa = document.getElementById("pagina-mesa");
let cardapio = document.getElementById("pagina-cardapio");let func = document.getElementById("pagina-funcionarios");
let qtde_mesas = 8;

function paginaMesa() {
    cardapio.style.display = "none";
    func.style.display = "none";
    mesa.style.display = "flex";
}

function paginaCardapio() {
    cardapio.style.display = "block";
    func.style.display = "none";
    mesa.style.display = "none";
}

function paginaFuncionario() {
    cardapio.style.display = "none";
    func.style.display = "block";
    mesa.style.display = "none";
}

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
                <span class="card-itemtitle">Capacidade: </span>4 pessoas
            </p>
        </div>
        <div class="card-buttons">
            <button class="card-btn primary">Editar</button>
            <button class="card-btn alternate" onclick="excluirMesa('mesa-${qtde_mesas}')">Excluir</button>
        </div>`;

    // Insere a nova mesa antes do botão "Adicionar"
    mesa.insertBefore(novaMesa, addTable);

    qtde_mesas += 1;
}

function excluirMesa(idMesa) {
    let mesa = document.getElementById(idMesa);
    if (mesa) {
        mesa.remove();
    }
}