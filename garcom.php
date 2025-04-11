<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Garçom | MesaPro</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/garcom.css">
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
<!--Mesas-->
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
                    <button class="card-btn primary" onclick="verComanda('1')" disabled>Ver Comanda</button>
                    <button class="card-btn alternate" onclick="fecharConta('1')" disabled>Fechar Conta</button>
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
                    <button class="card-btn primary" onclick="verComanda('2')">Ver Comanda</button>
                    <button class="card-btn alternate" onclick="fecharConta('2')">Fechar Conta</button>
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
                    <button class="card-btn primary" onclick="verComanda('3')">Ver Comanda</button>
                    <button class="card-btn alternate" onclick="fecharConta('3')">Fechar Conta</button>
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
                    <button class="card-btn primary" onclick="verComanda('4')" disabled>Ver Comanda</button>
                    <button class="card-btn alternate" onclick="fecharConta('4')" disabled>Fechar Conta</button>
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
                    <button class="card-btn primary" onclick="verComanda('5')" disabled>Ver Comanda</button>
                    <button class="card-btn alternate" onclick="fecharConta('5')" disabled>Fechar Conta</button>
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
                    <button class="card-btn primary" onclick="verComanda('6')" disabled>Ver Comanda</button>
                    <button class="card-btn alternate" onclick="fecharConta('6')" disabled>Fechar Conta</button>
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
                    <button class="card-btn primary" onclick="verComanda('7')">Ver Comanda</button>
                    <button class="card-btn alternate" onclick="fecharConta('7')">Fechar Conta</button>
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
<script src="js/garcom/garcom.js"></script>
</body>
</html>