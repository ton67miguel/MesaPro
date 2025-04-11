<?php
//inicializa sessão
session_start();



if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Redireciona para a página apropriada com base no papel do usuário
    switch ($_SESSION["role"]) {
        case 1:
            header("location: gerente.php");
            break;
        case 2:
            header("location: recepcionista.php");
            break;
        case 3:
            header("location: garcom.php");
            break;
        default:
            header("location: index.php"); // Redireciona para a página de login por padrão
            break;
    }
    exit;
}

// Include config file
require_once "config.php";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password, role FROM users WHERE username = ?"; // Inclui a coluna "role" na consulta

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Store result
                mysqli_stmt_store_result($stmt);

                // Check if username exists, if yes then verify password
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $db_password, $role); // Inclui a variável $role
                    if (mysqli_stmt_fetch($stmt)) {
                        //Verifica a senha diretamente.
                        if ($password === $db_password) {
                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["role"] = $role; // Armazena o papel do usuário na sessão

                            // Redirect user to the appropriate page based on role
                            switch ($role) {
                                case 1:
                                    header("location: gerente.php");
                                    break;
                                case 2:
                                    header("location: recepcionista.php");
                                    break;
                                case 3:
                                    header("location: garcom.php");
                                    break;
                                default:
                                    header("location: index.php"); // Redireciona para a página de login por padrão
                                    break;
                            }
                            exit;
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | MesaPro</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <header>
        <div class="menubar">
            <div>
                <h1>Restaurante X</h1>
            </div>
        </div>
    </header>
    <main>
        <div class="container">
            <h2>Login</h2>
            <?php
            if (!empty($login_err)) {
                echo '<p style="color:red;">' . $login_err . '</p>';
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="loginForm">
                <label for="user">Usuário:</label>
                <input type="text" id="user" name="username" placeholder="Digite seu usuário" required>
                <label for="password">Senha:</label>
                <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
                <button type="submit">Entrar</button>
            </form>
            <div class="forgot-password">
                <a href="#">Esqueceu a senha?</a>
            </div>
        </div>
    </main>
    <footer>
        <div class="footer-info">
            <p>&copy; 2025 Restaurante X. Todos os direitos reservados.</p>
            <p><a href="#">Contato</a> | <a href="#">Sobre</a></p>
        </div>
    </footer>
</body>

</html>