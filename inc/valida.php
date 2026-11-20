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

    $usuario = $bd->real_escape_string($_POST['login']);
    $senha_digitada = $_POST['senha'];

    // Se a função criptografia existir, aplica na senha digitada
    if (function_exists('criptografia')) {
        $senha = $bd->real_escape_string(criptografia($senha_digitada));
    } else {
        $senha = $bd->real_escape_string($senha_digitada);
    }

    $senha_pura_escapada = $bd->real_escape_string($senha_digitada);

    // Consulta SQL de validação incluindo a coluna 'foto'
    $sql = "SELECT id, nome, user, password, foto FROM usuarios WHERE (user = '" . $usuario . "') AND (password = '" . $senha . "') LIMIT 1;";
    $query = $bd->query($sql);

    if (!($query && $query->num_rows > 0)) {
        // Fallback caso a senha esteja em texto puro no banco
        $sql_fallback = "SELECT id, nome, user, password, foto FROM usuarios WHERE (user = '" . $usuario . "') AND (password = '" . $senha_pura_escapada . "') LIMIT 1;";
        $query = $bd->query($sql_fallback);
    }

    if ($query && $query->num_rows > 0) {
        $dados = $query->fetch_assoc();

        $_SESSION['id'] = $dados['id'];
        $_SESSION['nome'] = $dados['nome'];
        $_SESSION['user'] = $dados['user'];
        $_SESSION['foto'] = !empty($dados['foto']) ? $dados['foto'] : 'semimagem.jpg';
        $_SESSION['message'] = "Bem-vindo(a), " . $dados['nome'] . "!";
        $_SESSION['type'] = "info";

        header("Location: " . BASEURL . "index.php");
        exit;
    } else {
        throw new Exception("Usuário ou senha incorretos.");
    }
} catch (Exception $e) {
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "inc/login.php");
    exit;
}
?>