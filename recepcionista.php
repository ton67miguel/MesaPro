<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recepcionista | MesaPro</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
</head>
<body>
    <header>
        <div class="menubar">
            <div>
                <h1>Restaurante X</h1>
            </div>
            <div>
                <span>Usuário</span>
                <i class="fi fi-rr-circle-user"></i>
                <form action="logout.php" method="post">
                    <button type="submit">Logout</button>
                </form>
            </div>
        </div>
    </header>
    <main>
        <section id="pagina-mesa" class="card-container">
            <div id="mesa-1" class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        Mesa 1
                        <span class="ribbon available"></span>
                    </h2>
                    <p class="card-text">
                        <i class="fi fi-rr-users"></i>
                        <span class="card-itemtitle">Capacidade: </span>
                        <span class="capacity">4</span> pessoas
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" onclick="ocuparMesa('mesa-1')">Ocupar</button>
                    <button class="card-btn alternate" onclick="reservarMesa('mesa-1')">Reservar</button>
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
                        <span class="card-itemtitle">Capacidade: </span>
                        <span class="capacity">4</span> pessoas
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-utensils"></i>
                        <span class="card-itemtitle">Pedido: </span>
                        <span class="order-status">Aguardando preparo</span>
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-clock-three"></i>
                        <span class="card-itemtitle">Tempo de espera: </span>
                        <span class="waiting-time">20</span> minutos
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" onclick="ocuparMesa('mesa-2')" disabled>Ocupar</button>
                    <button class="card-btn alternate" onclick="liberarMesa('mesa-2')">Liberar</button>
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
                        <span class="card-itemtitle">Capacidade: </span>
                        <span class="capacity">4</span> pessoas
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-utensils"></i>
                        <span class="card-itemtitle">Pedido: </span>
                        <span class="order-status">Não registrado</span>
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" onclick="ocuparMesa('mesa-3')" disabled>Ocupar</button>
                    <button class="card-btn alternate" onclick="liberarMesa('mesa-3')">Liberar</button>
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
                        <span class="card-itemtitle">Capacidade: </span>
                        <span class="capacity">4</span> pessoas
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-reservation-table"></i>
                        <span class="card-itemtitle">Reservado: </span>
                        <span class="cliente-reserva">Lorena Rayssa</span>
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-circle-phone"></i>
                        <span class="card-itemtitle">Telefone: </span>
                        <span class="cliente-telefone">(75) 99697-8119</span>
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-calendar-clock"></i>
                        <span class="card-itemtitle">Horário: </span>
                        <span class="horario-reservado">19:30 2024-09-23</span>
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" onclick="ocuparMesa('mesa-4')">Ocupar</button>
                    <button class="card-btn alternate" onclick="editarReserva('mesa-4')">Editar</button>
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
                        <span class="card-itemtitle">Capacidade: </span>
                        <span class="capacity">4</span> pessoas
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-reservation-table"></i>
                        <span class="card-itemtitle">Reservado: </span>
                        <span class="cliente-reserva ">Igor Yago</span>
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-circle-phone"></i>
                        <span class="card-itemtitle">Telefone: </span>
                        <span class="cliente-telefone">(11) 98693-5511</span>
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-calendar-clock"></i>
                        <span class="card-itemtitle">Horário: </span>
                        <span class="horario-reservado ">19:30 2024-09-23</span>
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" onclick="ocuparMesa('mesa-5')">Ocupar</button>
                    <button class="card-btn alternate" onclick="editarReserva('mesa-5')">Editar</button>
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
                        <span class="card-itemtitle">Capacidade: </span>
                        <span class="capacity">4</span> pessoas
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" onclick="ocuparMesa('mesa-6')">Ocupar</button>
                    <button class="card-btn alternate" onclick="reservarMesa('mesa-6')">Reservar</button>
                </div>
            </div>

            <div id="mesa-7" class="card">
                <div class="card-body">
                    <h2 class="card-title">
                        Mesa 7
                        <span class="ribbon occupied"></span></h2>
                    <p class="card-text">
                        <i class="fi fi-rr-users"></i>
                        <span class="card-itemtitle">Capacidade: </span>
                        <span class="capacity">4</span> pessoas
                    </p>
                    <p class="card-text">
                        <i class="fi fi-rr-utensils"></i>
                        <span class="card-itemtitle">Pedido: </span>
                        <span class="order-status">Em preparo</span>
                    </p>
                </div>
                <div class="card-buttons">
                    <button class="card-btn primary" onclick="ocuparMesa('mesa-7')" disabled>Ocupar</button>
                    <button class="card-btn alternate" onclick="liberarMesa('mesa-7')">Liberar</button>
                </div>
            </div>


            <div class="modal-overlay" id="modalOverlayReserva">
                <div class="modal">
                    <div class="modal-header">
                        <h2><i class="fi fi-rr-reservation-table"></i> Reserva</h2>
                        <button class="close-button" onclick="fecharModal()"><i class="fi fi-rr-cross"></i></button>
                    </div>
                    <div class="modal-content">
                        <form id="newForm">
                            <div class="form-group">
                                <label for="customerName">Nome</label>
                                <input type="text" name="customerName" id="customerName" placeholder="Nome do cliente">
                            </div>
                            <div class="form-group">
                                <label for="customerPhone">Telefone</label>
                                <input type="text" name="customerPhone" id="customerPhone" placeholder="( ) _____-____">
                            </div>
                            <div class="form-group">
                                <label for="reservationTime">Horario</label>
                                <input type="time" name="reservationTime" id="reservationTime">
                            </div>
                            <div class="form-group">
                                <label for="reservationDate">Dia</label>
                                <input type="date" name="reservationDate" id="reservationDate">
                            </div>
                            <div class="modal-buttons">
                                <button class="card-btn primary" type="submit">Salvar</button>
                                <button class="card-btn alternate" type="reset">Limpar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <div class="footer-info">
            <p>&copy; 2025 Restaurante X. Todos os direitos reservados.</p>
            <p><a href="#">Contato</a> | <a href="#">Sobre</a></p>
        </div>
    </footer>
    <script src="js/recepcionista/script.js"></script>
</body>
</html>