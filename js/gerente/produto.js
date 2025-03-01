function cadastrarProduto() {
    document.getElementById("modalOverlayCardapio").style.display = "flex";
}

// Variável para armazenar a linha que está sendo editada, se houver.
let linhaEditando = null;

document.getElementById("ProdutForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Impede o recarregamento da página

    // Captura os valores do formulário
    let id = document.getElementById("productId").value;
    let nome = document.getElementById("productName").value;
    let tipo = document.getElementById("productType").value;
    let categoria = document.getElementById("productCategory").value;
    let preco = document.getElementById("productPrice").value;

    // Verifica se os campos estão preenchidos
    if (!id || !nome || !tipo || !categoria || !preco) {
        alert("Preencha todos os campos obrigatórios!");
        return;
    }

    let tabela = document.getElementById("productTable").getElementsByTagName('tbody')[0];

    // Se estiver editando, atualiza a linha existente
    if (linhaEditando) {
        let cells = linhaEditando.getElementsByTagName("td");
        cells[0].textContent = id;
        cells[1].textContent = nome;
        cells[2].textContent = tipo;
        cells[3].textContent = categoria;
        cells[4].textContent = parseFloat(preco).toFixed(2);
        // Limpa a referência de edição
        linhaEditando = null;
    } else {
        // Se não estiver editando, insere uma nova linha na tabela
        let novaLinha = tabela.insertRow();
        novaLinha.innerHTML = `
            <td>${id}</td>
            <td>${nome}</td>
            <td>${tipo}</td>
            <td>${categoria}</td>
            <td>${parseFloat(preco).toFixed(2)}</td>
            <td>
                <button class="btn-action" onclick="editarProduto(this)"><i class="fi fi-rr-pencil"></i></button>
                <button class="btn-action" onclick="removerProduto(this)"><i class="fi fi-rr-trash"></i></button>
            </td>
        `;
    }

    // Limpa os campos do formulário
    document.getElementById("ProdutForm").reset();
    fecharModal();
});

// Função para editar um produto
function editarProduto(botao) {
    // Obtém a linha da tabela onde o botão foi clicado
    let linha = botao.parentNode.parentNode;
    let cells = linha.getElementsByTagName("td");

    // Preenche os campos do formulário com os valores da linha
    document.getElementById("productId").value = cells[0].textContent;
    document.getElementById("productName").value = cells[1].textContent;
    document.getElementById("productType").value = cells[2].textContent;
    document.getElementById("productCategory").value = cells[3].textContent;
    document.getElementById("productPrice").value = parseFloat(cells[4].textContent);

    // Armazena a linha que está sendo editada para que possa ser atualizada no submit
    linhaEditando = linha;

    // Abre o modal para edição
    document.getElementById("modalOverlayCardapio").style.display = "flex";
}

// Função para remover um produto da tabela
function removerProduto(botao) {
    let linha = botao.parentNode.parentNode;
    linha.parentNode.removeChild(linha);
}

document.addEventListener("DOMContentLoaded", function () {
    // Obtém os campos de entrada e a tabela de produtos
    let inputId = document.getElementById("id");
    let inputNome = document.getElementById("produto");
    let tabela = document.getElementById("productTable").getElementsByTagName("tbody")[0];

    // Adiciona eventos para filtrar enquanto o usuário digita
    inputId.addEventListener("input", function () {
        filtrarTabela();
    });

    inputNome.addEventListener("input", function () {
        filtrarTabela();
    });

    function filtrarTabela() {
        let filtroId = inputId.value.trim().toLowerCase();
        let filtroNome = inputNome.value.trim().toLowerCase();

        let linhas = tabela.getElementsByTagName("tr");

        for (let linha of linhas) {
            let idProduto = linha.cells[0].textContent.trim().toLowerCase();
            let nomeProduto = linha.cells[1].textContent.trim().toLowerCase();

            // Verifica se o ID ou Nome do produto contém o filtro digitado
            let correspondeId = filtroId === "" || idProduto.includes(filtroId);
            let correspondeNome = filtroNome === "" || nomeProduto.includes(filtroNome);

            // Mostra ou oculta a linha conforme a busca
            linha.style.display = (correspondeId && correspondeNome) ? "" : "none";
        }
    }
});