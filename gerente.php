<?php
//inicializa sessão
session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php"); // Redireciona para a página de login se não estiver logado
    exit;
}

if ($_SESSION["role"] !== 1) {
    // Se não for gerente, redireciona ou exibe uma mensagem de acesso negado
    // Exemplo de redirecionamento:
    header("location: denied.php");
    exit;
    // Ou você pode simplesmente exibir uma mensagem:
    // echo "Acesso negado.";
}

// Inclui o arquivo de configuração do banco de dados
require_once "config.php";

// Define a variável para armazenar o nome do usuario
$user = "";

// Prepara e executa a consulta para obter o nome do gerente
$sql = "SELECT fullname FROM users WHERE id = ?";
if ($stmt = mysqli_prepare($link, $sql)) {
    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, "i", $param_id);

    // Set parameters
    $param_id = $_SESSION["id"];

    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Store result
        mysqli_stmt_store_result($stmt);

        // Check if user exists
        if (mysqli_stmt_num_rows($stmt) == 1) {
            // Bind result variables
            mysqli_stmt_bind_result($stmt, $user);

            // Fetch result
            if (mysqli_stmt_fetch($stmt)) {
                // Agora a variável $user contém o nome do gerente
            }
        } else {
            // Usuário não encontrado (erro inesperado)
            // Você pode adicionar tratamento de erro aqui
            echo "Erro: Usuário não encontrado.";
            exit;
        }
    } else {
        echo "Oops! Algo deu errado. Por favor, tente novamente mais tarde.";
        exit;
    }

    // Close statement
    mysqli_stmt_close($stmt);
}

// Processamento para adicionar uma nova mesa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['adicionar_mesa'])) {
    $numero_mesa = mysqli_real_escape_string($link, $_POST['numero_mesa']);
    $capacidade = mysqli_real_escape_string($link, $_POST['capacidade']);

    // Validação básica
    if (!empty($numero_mesa) && is_numeric($capacidade) && $capacidade > 0) {
        $sql = "INSERT INTO tables (numero, capacidade, status, hora_reserva, reservado_por, tel_reseva) VALUES (?, ?, 0, '-','-','-')";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "si", $numero_mesa, $capacidade);
            if (mysqli_stmt_execute($stmt)) {
                header("Location: gerente.php");
            } else {
                echo "Erro ao adicionar mesa: " . mysqli_error($link);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Erro na preparação da query: " . mysqli_error($link);
        }
    } else {
        echo "Por favor, preencha o número da mesa e a capacidade corretamente.";
    }
}
// Consulta para obter todas as mesas do banco de dados
$sql_select = "SELECT id, numero, capacidade, hora_reserva, reservado_por, tel_reseva, status FROM tables ORDER BY numero";
$result = mysqli_query($link, $sql_select);
$mesas = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $mesas[] = $row;
    }
    mysqli_free_result($result);
} else {
    echo "Erro ao buscar mesas: " . mysqli_error($link);
}

// Close connection
mysqli_close($link);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerente - Inicío | MesaPro</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/gerente.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>

    <script>
        function excluirMesaPhp(mesaId, mesaNr) {
            if (confirm("Tem certeza que deseja excluir a mesa " + mesaNr + "?")) {
                const mesa_id = mesaId.replace('mesa-', ''); // Extrai o ID numérico

                fetch('excluir_mesa.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'mesa_id=' + mesa_id,
                })
                .then(response => response.text())
                .then(data => {
                    //alert(data); // Exibe a resposta do servidor
                    // Recarrega a página para atualizar a lista de mesas
                    window.location.reload();
                })
                .catch((error) => {
                    console.error('Erro:', error);
                });
            }
        }

        function abrirModalEditarMesa(id, numero, capacidade) {
            document.getElementById('tableId').value = id;
            document.getElementById('tableNumber').value = numero;
            document.getElementById('tableCapacity').value = capacidade;

            document.getElementById('modalOverlayMesa').style.display = 'flex';
        }

        function fecharModal() {
            document.getElementById('modalOverlayMesa').style.display = 'none';
        }

        function salvarEdicaoMesa(event) {
            event.preventDefault(); // evita o recarregamento da página

            const id = document.getElementById('tableId').value;
            const numero = document.getElementById('tableNumber').value;
            const capacidade = document.getElementById('tableCapacity').value;

            fetch('editar_mesa.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${id}&numero=${numero}&capacidade=${capacidade}`
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); // opcional: mostrar resposta do servidor
                fecharModal(); // fecha o modal
                window.location.reload(); // recarrega a página para mostrar a atualização
            })
            .catch(error => {
                console.error('Erro ao editar mesa:', error);
            });
        }
    </script>

</head>
<body>
    <header>
        <div class="menubar">
            <div>
                <h1>Restaurante X</h1>
            </div>
            <nav>
                <a id="mesa" href="#" onclick="paginaMesa()">Mesas</a>
                <a id="cardapio" href="#" onclick="paginaCardapio()">Cardápio</a>
                <a id="funcionarios" href="#" onclick="paginaFuncionario()">Funcionários</a>
            </nav>
            <div>
                <span>Bem-vindo, <?php echo $user; ?>!</span>
                <i class="fi fi-rr-circle-user"></i>
                <form action="logout.php" method="post">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </header>
    <main>

    
        <!-- MESAS -->
    <section id="pagina-mesa" class="card-container">


    <?php if (empty($mesas)): ?>
        <p>Nenhuma mesa cadastrada.</p>
    <?php else: ?>
        <?php foreach ($mesas as $mesa): ?>
            <div id="mesa-<?php echo $mesa['id']; ?>" class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        Mesa <?php echo htmlspecialchars($mesa['numero']); ?>
                        <span class="ribbon <?php echo htmlspecialchars($mesa['status']); ?>">
                            <?php echo ucfirst(htmlspecialchars($mesa['status'])); ?>
                        </span>
                    </h2>
                    <p class="card-text">
                        <i class="fi fi-rr-users"></i>
                        <span class="card-itemtitle">Capacidade: </span><?php echo htmlspecialchars($mesa['capacidade']); ?> pessoas
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" onclick="abrirModalEditarMesa(<?php echo $mesa['id']; ?>, <?php echo $mesa['numero']; ?>, <?php echo $mesa['capacidade']; ?>)">Editar</button>
                    <button class="card-btn alternate" onclick="excluirMesaPhp('mesa-<?php echo $mesa['id']; ?>', '<?php echo htmlspecialchars($mesa['numero']); ?>')">Excluir</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
        <!--
            <div id="mesa-1" class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        Mesa 1
                        <span class="ribbon available"></span>
                    </h2>
                    <p class="card-text">
                        <i class="fi fi-rr-users"></i>
                        <span class="card-itemtitle">Capacidade: </span>4 pessoas
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary">Editar</button>
                    <button class="card-btn alternate" onclick="excluirMesa('mesa-1')">Excluir</button>
                </div>
            </div>

            <div id="mesa-2" class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        Mesa 2
                        <span class="ribbon occupied"></span>
                    </h2>
                    <p class="card-text">
                        <i class="fi fi-rr-users"></i>
                        <span class="card-itemtitle">Capacidade: </span>4 pessoas
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" disabled>Editar</button>
                    <button class="card-btn alternate" disabled onclick="excluirMesa('mesa-2')">Excluir</button>
                </div>
            </div>

            <div id="mesa-3" class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        Mesa 3
                        <span class="ribbon occupied"></span>
                    </h2>
                    <p class="card-text">
                        <i class="fi fi-rr-users"></i>
                        <span class="card-itemtitle">Capacidade: </span>4 pessoas
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" disabled>Editar</button>
                    <button class="card-btn alternate" disabled onclick="excluirMesa('mesa-3')">Excluir</button>
                </div>
            </div>

            <div id="mesa-4" class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        Mesa 4
                        <span class="ribbon reserved"></span>
                    </h2>
                    <p class="card-text">
                        <i class="fi fi-rr-users"></i>
                        <span class="card-itemtitle">Capacidade: </span>4 pessoas
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-reservation-table"></i>
                        <span class="card-itemtitle">Reservado: </span>
                        <span class="cliente-reserva ">Marcus Aurelius</span>
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-calendar-clock"></i>
                        <span class="card-itemtitle">Horário: </span>
                        <span class="horario-reservado ">19:30 23/09/2024</span>
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" disabled>Editar</button>
                    <button class="card-btn alternate" disabled onclick="excluirMesa('mesa-4')">Excluir</button>
                </div>
            </div>

            <div id="mesa-5" class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        Mesa 5
                        <span class="ribbon reserved"></span>
                    </h2>
                    <p class="card-text">
                        <i class="fi fi-rr-users"></i>
                        <span class="card-itemtitle">Capacidade: </span>4 pessoas
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-reservation-table"></i>
                        <span class="card-itemtitle">Reservado: </span>
                        <span class="cliente-reserva ">Marcus Aurelius</span>
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-calendar-clock"></i>
                        <span class="card-itemtitle">Horário: </span>
                        <span class="horario-reservado ">19:30 23/09/2024</span>
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" disabled>Editar</button>
                    <button class="card-btn alternate" disabled onclick="excluirMesa('mesa-5')">Excluir</button>
                </div>
            </div>

            <div id="mesa-6" class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        Mesa 6
                        <span class="ribbon available"></span>
                    </h2>
                    <p class="card-text">
                        <i class="fi fi-rr-users"></i>
                        <span class="card-itemtitle">Capacidade: </span>4 pessoas
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary">Editar</button>
                    <button class="card-btn alternate" onclick="excluirMesa('mesa-6')">Excluir</button>
                </div>
            </div>

            <div id="mesa-07" class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        Mesa 7
                        <span class="ribbon occupied"></span></h2>
                    <p class="card-text">
                        <i class="fi fi-rr-users"></i>
                        <span class="card-itemtitle">Capacidade: </span>4 pessoas
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" disabled>Editar</button>
                    <button class="card-btn alternate" disabled>Excluir</button>
                </div>
            </div>
    </div> -->
    <!--
            <div id="add-table" class="card">
                <div class="card-button-add">
                <button class="card-btn primary" onclick="adicionarMesa()">Adicionar</button>
            </div> -->

            <div id="add-table" class="card">
                <div class="card-button-add">
                    <div class="container-mesas">
                        <div class="add-mesa-form">
                            <h2>Adicionar Nova Mesa</h2>
                            <form method="post">
                                <div style="width:100%;display:flex; flex-direction:right; justify-content:space-between; margin:10px 0;">
                                    <label for="numero_mesa">Número da Mesa:</label>
                                    <input style="float:right; vertical-align:baseline"" class="input-cad-mesa" type="number" id="numero_mesa" name="numero_mesa" required>
                                </div>
                                
                                <div style="width:100%;display:flex; flex-direction:right; justify-content:space-between; margin:10px 0">
                                    <label for="capacidade">Capacidade:</label>
                                    <input style="float:right;" class="input-cad-mesa" type="number" id="capacidade" name="capacidade" min="1" required>
                                </div>
                                
                                <button class="card-btn primary" type="submit" name="adicionar_mesa">Adicionar Mesa</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-overlay" id="modalOverlayMesa">
                <div class="modal">
                    <div class="modal-header">
                        <h2><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" color="#000" fill="none">
                            <ellipse cx="12" cy="6.5" rx="10" ry="3" stroke="currentColor" stroke-width="3" />
                            <path d="M12 20.5C12.8284 20.5 13.5898 20.2551 14.1904 19.8455C14.4774 19.6498 14.5909 19.242 14.4189 18.9153C14.0734 18.2595 13.3308 17.5 12 17.5C10.6692 17.5 9.92656 18.2595 9.58115 18.9153C9.40905 19.242 9.52257 19.6498 9.8096 19.8455C10.4102 20.2551 11.1716 20.5 12 20.5Z" stroke="currentColor" stroke-width="3" stroke-linejoin="round" />
                            <path d="M12 17.5V9.5" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg> Editando Mesa</h2>
                        <button class="close-button" onclick="fecharModal()"><i class="fi fi-rr-cross"></i></button>
                    </div>
                    <div class="modal-content">
                        <form id="newForm" onsubmit="salvarEdicaoMesa(event)">
                            <input type="hidden" name="tableId" id="tableId"> <!-- esse campo armazena o ID -->
                            <div class="form-group">
                                <label for="tableNumber">Número da Mesa</label>
                                <input type="number" name="tableNumber" id="tableNumber">
                            </div>
                            <div class="form-group">
                                <label for="tableCapacity">Capacidade</label>
                                <input type="number" name="tableCapacity" id="tableCapacity" min="0">
                            </div>
                            <button type="submit" class="card-btn primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
            
        </section>

        <!-- CARDAPIO -->
         <section id="pagina-cardapio" class="container-cardapio">
            <div class="content-card">
                <div class="card-header">
                    <h1><i class="fi fi-rr-newspaper-open"></i> Cardápio</h1>
                    <button class="btn-new  primary"><i class="fi fi-rr-plus-small"></i> Novo Produto</button>
                </div>

                <div class="search-container">
                    <div class="search-group">
                        <label for="id">ID</label>
                        <input type="number" name="id" id="id" placeholder="Buscar por ID">
                    </div>
                    <div class="search-group">
                        <label for="produto">Produto</label>
                        <input type="text" name="produto" id="produto" placeholder="Buscar por nome">
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Produto</th>
                            <th>Tipo</th>
                            <th>Categoria</th>
                            <th>Preço (R$)</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>001</td>
                            <td>Cheeseburger Clássico</td>
                            <td>Menu Principal</td>
                            <td>Burgers</td>
                            <td>29,90</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>002</td>
                            <td>Filé Mignon Grelhado</td>
                            <td>Menu Principal</td>
                            <td>Steaks</td>
                            <td>59,90</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>003</td>
                            <td>Lasanha à Bolonhesa</td>
                            <td>Menu Principal</td>
                            <td>Massas</td>
                            <td>42,90</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>004</td>
                            <td>Nuggets de Frango</td>
                            <td>Menu Infantil</td>
                            <td>Frango</td>
                            <td>19,90</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>005</td>
                            <td>Mini Pizza de Queijo</td>
                            <td>Menu Infantil</td>
                            <td>Vegetarianos</td>
                            <td>22,90</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>006</td>
                            <td>Suco de Laranja Natural</td>
                            <td>Bebidas Não Alcoólicas</td>
                            <td>Sucos</td>
                            <td>9,90</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>007</td>
                            <td>Água Mineral</td>
                            <td>Bebidas Não Alcoólicas</td>
                            <td>Água</td>
                            <td>4,90</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>008</td>
                            <td>Chopp Artesanal</td>
                            <td>Bebidas Alcoólicas</td>
                            <td>Chopps</td>
                            <td>12,90</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>009</td>
                            <td>Batata Frita</td>
                            <td>Menu Principal</td>
                            <td>Aperitivos</td>
                            <td>14,90</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
         </section>

         <!-- FUNCIONARIOS -->
         <section id="pagina-funcionarios" class="container-funcionarios">
            <div class="content-card">
                <div class="card-header">
                    <h1><i class="fi fi-rr-users-alt"></i> Funcionários</h1>
                    <button class="btn-new  primary"><i class="fi fi-rr-plus-small"></i> Novo Funcionário</button>
                </div>

                <div class="search-container">
                    <div class="search-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" id="nome" placeholder="Buscar por nome">
                    </div>
                    <div class="search-group">
                        <label for="cpf">CPF</label>
                        <input type="text" name="cpf" id="cpf" placeholder="Buscar por CPF">
                    </div>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>CPF</th>
                            <th>Telefone</th>
                            <th>Função</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Stella Fátima Valentina</td>
                            <td>094.256.847-82</td>
                            <td>(21) 98946-0601</td>
                            <td>Garçom</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Malu Mirella Julia Souza</td>
                            <td>598.125.632-02</td>
                            <td>(85) 99317-3315</td>
                            <td>Recepcionista</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Diego Murilo da Cunha</td>
                            <td>740.329.524-26</td>
                            <td>(71) 98304-5915</td>
                            <td>Cozinheiro</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>Iago Joaquim</td>
                            <td>950.064.545-98</td>
                            <td>(69) 99562-0031</td>
                            <td>Gerente</td>
                            <td>
                                <button class="btn-action"><i class="fi fi-rr-pencil"></i></button>
                                <button class="btn-action"><i class="fi fi-rr-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
         </section>
    </main>
    <footer>
        <div class="footer-info">
            <p>&copy; 2025 Restaurante X. Todos os direitos reservados.</p>
            <p><a href="#">Contato</a> | <a href="#">Sobre</a></p>
        </div>
    </footer>
    <script src="js/gerente.js"></script>
</body>
</html>