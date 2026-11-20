<?php
if (!isset($_SESSION)) {
    session_start();
}

include_once "../config.php";
require_once DBAPI;

$users = null;
$user = null;

/**
 * Função para formatar as datas
 */
if (!function_exists('formatadata')) {
    function formatadata($data, $formato)
    {
        $dt = new DateTime($data, new DateTimeZone("-0300"));
        return $dt->format($formato);
    }
}

/**
 * Listagem de Usuários
 */
if (!function_exists('index')) {
    function index()
    {
        if (empty($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
            $_SESSION['message'] = "Acesso restrito a administradores.";
            $_SESSION['type'] = "danger";
            header("Location: " . BASEURL . "index.php");
            exit;
        }

        global $users;
        if (!empty($_POST["users"])) {
            $users = filter("usuarios", "nome like '%" . $_POST["users"] . "%'");
        } else {
            $users = find_all("usuarios");
        }
    }
}

/**
 * Cadastro de Usuários
 */
if (!function_exists('add')) {
    function add()
    {
        if (empty($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
            $_SESSION['message'] = "Acesso restrito a administradores.";
            $_SESSION['type'] = "danger";
            header("Location: " . BASEURL . "index.php");
            exit;
        }

        if (!empty($_POST['user'])) {
            $user = $_POST['user'];

            if (!empty($_FILES['foto']['name'])) {
                $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

                if ($extensao == 'jpg' || $extensao == 'jpeg' || $extensao == 'png') {
                    $pastaUploads = __DIR__ . "/uploads/";
                    if (!is_dir($pastaUploads)) {
                        mkdir($pastaUploads, 0775, true);
                    }

                    $nomeFoto = time() . "_" . basename($_FILES['foto']['name']);
                    $destino = $pastaUploads . $nomeFoto;

                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                        $user['foto'] = $nomeFoto;
                    }
                } else {
                    $_SESSION['message'] = 'A foto deve estar no formato JPG, JPEG ou PNG.';
                    $_SESSION['type'] = 'danger';
                    return;
                }
            }

            if (!empty($user["password"])) {
                $password = criptografia($user["password"]);
                $user["password"] = $password;
            }

            save('usuarios', $user);
            header('location: index.php');
            exit;
        }
    }
}

/**
 * Atualização/Edição de Usuário
 */
if (!function_exists('edit')) {
    function edit()
    {
        if (empty($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
            $_SESSION['message'] = "Acesso restrito a administradores.";
            $_SESSION['type'] = "danger";
            header("Location: " . BASEURL . "index.php");
            exit;
        }

        if (isset($_GET['id'])) {
            $id = (int) $_GET['id'];

            if (isset($_POST['user'])) {
                $user = $_POST['user'];

                if (!empty($user["password"])) {
                    $password = criptografia($user["password"]);
                    $user["password"] = $password;
                }

                if (!empty($_FILES['foto']['name'])) {
                    $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

                    if ($extensao == 'jpg' || $extensao == 'jpeg' || $extensao == 'png') {
                        $pastaUploads = __DIR__ . "/uploads/";
                        if (!is_dir($pastaUploads)) {
                            mkdir($pastaUploads, 0775, true);
                        }

                        $nomeFoto = time() . "_" . basename($_FILES['foto']['name']);
                        $destino = $pastaUploads . $nomeFoto;

                        if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                            $user['foto'] = $nomeFoto;
                        }
                    } else {
                        $_SESSION['message'] = 'A foto deve estar no formato JPG, JPEG ou PNG.';
                        $_SESSION['type'] = 'danger';
                        return;
                    }
                }

                update('usuarios', $id, $user);
                header('location: index.php');
                exit;
            } else {
                global $user;
                $user = find('usuarios', $id);
            }
        } else {
            header('location: index.php');
            exit;
        }
    }
}

/**
 * Visualização de um Usuário
 */
if (!function_exists('view')) {
    function view($id = null)
    {
        if (empty($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
            $_SESSION['message'] = "Acesso restrito a administradores.";
            $_SESSION['type'] = "danger";
            header("Location: " . BASEURL . "index.php");
            exit;
        }

        global $user;
        $user = find("usuarios", $id);
    }
}

/**
 * Exclusão de um Usuário
 */
if (!function_exists('delete')) {
    function delete($id = null)
    {
        if (empty($_SESSION['user']) || $_SESSION['user'] !== 'admin') {
            $_SESSION['message'] = "Acesso restrito a administradores.";
            $_SESSION['type'] = "danger";
            header("Location: " . BASEURL . "index.php");
            exit;
        }

        global $user;
        $user = remove('usuarios', $id);

        header('location: index.php');
        exit;
    }
}
?>