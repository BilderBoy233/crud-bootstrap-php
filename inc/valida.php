<?php
if (!isset($_SESSION)) {
    session_start();
}

include ("../config.php");
require_once(DBAPI);

// Se não houver envio via POST ou se os campos estiverem vazios
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['login']) || empty($_POST['senha'])) {
    $_SESSION['message'] = "Preencha o usuário e a senha para entrar.";
    $_SESSION['type'] = "warning";
    header("Location: " . BASEURL . "inc/login.php");
    exit;
}

$bd = open_database();

try {
    $bd->select_db(DB_NAME);

    $usuario = $_POST['login'];
    $senha_digitada = $_POST['senha'];

    // Se a função criptografia existir no database.php, aplica na senha digitada
    if (function_exists('criptografia')) {
        $senha = criptografia($senha_digitada);
    } else {
        $senha = $senha_digitada;
    }

    // Consulta SQL de validação
    // NOTA: Certifique-se de que no banco os nomes das colunas são 'user' e 'password'
    $sql = "SELECT id, nome, user, password FROM usuarios WHERE (user = '" . $usuario . "') AND (password = '" . $senha . "') LIMIT 1;";
    
    $query = $bd->query($sql);

    if ($query && $query->num_rows > 0) {
        $dados = $query->fetch_assoc();

        $_SESSION['id'] = $dados['id'];
        $_SESSION['nome'] = $dados['nome'];
        $_SESSION['user'] = $dados['user'];
        $_SESSION['message'] = "Bem-vindo(a), " . $dados['nome'] . "!";
        $_SESSION['type'] = "info";

        // Login feito com sucesso: Redireciona para o index principal
        header("Location: " . BASEURL . "index.php");
        exit;
    } else {
        // Se a busca com a senha criptografada falhar, testa sem a criptografia (caso esteja em texto puro no banco)
        $sql_fallback = "SELECT id, nome, user, password FROM usuarios WHERE (user = '" . $usuario . "') AND (password = '" . $senha_digitada . "') LIMIT 1;";
        $query_fallback = $bd->query($sql_fallback);

        if ($query_fallback && $query_fallback->num_rows > 0) {
            $dados = $query_fallback->fetch_assoc();

            $_SESSION['id'] = $dados['id'];
            $_SESSION['nome'] = $dados['nome'];
            $_SESSION['user'] = $dados['user'];
            $_SESSION['message'] = "Bem-vindo(a), " . $dados['nome'] . "!";
            $_SESSION['type'] = "info";

            header("Location: " . BASEURL . "index.php");
            exit;
        } else {
            throw new Exception("Usuário ou senha incorretos.");
        }
    }
} catch (Exception $e) {
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['type'] = "danger";
    // Em caso de erro, retorna para a tela de login
    header("Location: " . BASEURL . "inc/login.php");
    exit;
}
?>