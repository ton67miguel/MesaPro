function cadastrarFuncionario() {
    document.getElementById("modalOverlayFuncionario").style.display = "flex";
}

document.getElementById("EmployeeForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita o recarregamento da página

    // Captura os valores do formulário
    let nome = document.getElementById("employeeName").value;
    let cpf = document.getElementById("employeeCpf").value;
    let telefone = document.getElementById("employeeTel").value;
    let email = document.getElementById("employeeEmail").value;
    let senha = document.getElementById("employeePassword").value;
    let funcao = document.getElementById("employeePosition").value;

    // Verifica se os campos estão preenchidos
    if (!nome || !cpf || !telefone || !email || !senha || !funcao) {
        alert("Preencha todos os campos obrigatórios!");
        return;
    }

    let tabela = document.getElementById("employeeTable").getElementsByTagName('tbody')[0];

    // Se estiver editanto, atualiza a linha existente
    if (linhaEditando) {
        let cells = linhaEditando.getElementsByTagName("td");
        cells[0].textContent = nome;
        cells[1].textContent = cpf;
        cells[2].textContent = telefone;
        cells[3].textContent = email;
        cells[4].textContent = senha;
        cells[5].textContent = funcao;
        // Limpa a referência de edição
        linhaEditando = null;
    } else {
        // Se não estiver editando, insere uma nova linha na tabela
        let novaLinha = tabela.insertRow();
        novaLinha.innerHTML = `
            <td>${nome}</td>
            <td>${cpf}</td>
            <td>${telefone}</td>
            <td>${email}</td>
            <td>${senha}</td>
            <td>${funcao}</td>
            <td>
                <button class="btn-action" onclick="editarFuncionario(this)"><i class="fi fi-rr-pencil"></i></button>
                <button class="btn-action" onclick="removerFuncionario(this)"><i class="fi fi-rr-trash"></i></button>
            </td>
        `;
    }
    // Limpa os campos do formulário após salvar
    document.getElementById("EmployeeForm").reset();
    fecharModal();
});

// Função para editar um funcionario da tabela
function editarFuncionario(botao) {
    // Obtém a linha da tabela onde o botão foi clicado
    let linha = botao.parentNode.parentNode;
    let cells = linha.getElementsByTagName("td");

    // Preenche os campos do formulário com os valores da linha
    document.getElementById("employeeName").value = cells[0].textContent;;
    document.getElementById("employeeCpf").value = cells[1].textContent;;
    document.getElementById("employeeTel").value = cells[2].textContent;;
    document.getElementById("employeeEmail").value = cells[3].textContent;;
    document.getElementById("employeePassword").value = cells[4].textContent;;
    document.getElementById("employeePosition").value = cells[5].textContent;;

    // Armazena a linha que está sendo editada para que possa ser atualizada no submit
    linhaEditando = linha;

    // Altera o título do modal para "Editar Funcionário"
    document.getElementById("modo").innerText = "Editar Funcionário";

    // Abre o modal para edição
    document.getElementById("modalOverlayFuncionario").style.display = "flex";
}

// Função para remover um funcionario da tabela
function removerFuncionario(botao) {
    let linha = botao.parentNode.parentNode;
    linha.parentNode.removeChild(linha);
}

document.addEventListener("DOMContentLoaded", function () {
    // Obtém os campos de entrada e a tabela de funcionários
    let inputNome = document.getElementById("nome");
    let inputCpf = document.getElementById("cpf");
    let tabela = document.getElementById("employeeTable").getElementsByTagName("tbody")[0];

    // Adiciona eventos para filtrar enquanto o usuário digita
    inputNome.addEventListener("input", function () {
        filtrarTabela();
    });

    inputCpf.addEventListener("input", function () {
        filtrarTabela();
    });

    function filtrarTabela() {
        let filtroNome = inputNome.value.trim().toLowerCase();
        let filtroCpf = inputCpf.value.trim().toLowerCase();

        let linhas = tabela.getElementsByTagName("tr");

        for (let linha of linhas) {
            let nomeFuncionario = linha.cells[0].textContent.trim().toLowerCase();
            let cpfFuncionario = linha.cells[1].textContent.trim().toLowerCase();

            // Verifica se o Nome ou CPF contém o filtro digitado
            let correspondeNome = filtroNome === "" || nomeFuncionario.includes(filtroNome);
            let correspondeCpf = filtroCpf === "" || cpfFuncionario.includes(filtroCpf);

            // Mostra ou oculta a linha conforme a busca
            linha.style.display = (correspondeNome && correspondeCpf) ? "" : "none";
        }
    }
});