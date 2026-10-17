<?php
include "../config.php";
include DBAPI;

$users = null;
$user = null;

/**
 *  Função para formatar as datas
 */
function formatadata($data, $formato)
{
    $dt = new DateTime($data, new DateTimeZone("-0300"));
    return $dt->format($formato);
}

/**
 *  Listagem de Clientes
 */
function index()
{
    global $users;
    if (!empty($_POST["users"])){
        $users = filter("usuarios", "nome like '%" . $_POST["users"] . "%'");
    }else{
        $users = find_all("usuarios");
    }
    $users = find_all("usuarios");
}

/**
 *  Cadastro de Clientes
 */
function add()
{
    if (!empty($_POST['user'])) {
        $user = $_POST['user'];

        if (!empty($_FILES['foto']['name'])) {
            $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

            if ($extensao == 'jpg' || $extensao == 'jpeg' || $extensao == 'png') {
                $nomeFoto = time() . "_" . $_FILES['foto']['name'];
                $destino = __DIR__ . "/uploads/" . $nomeFoto;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                    $user['foto'] = $nomeFoto;
                }
            } else {
                $_SESSION['message'] = 'A foto deve estar no formato JPG, JPEG ou PNG.';
                $_SESSION['type'] = 'danger';
                return;
            }
        }

        if (!empty ($user["password"])) {
            $password = criptografia($user["password"]);
            $user["password"] = $password;
        }

        save('users', $user);
        header('location: index.php');
    }
}

/**
 *  Atualizacao/Edicao de Cliente
 */
function edit()
{
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        if (isset($_POST['user'])) {
            $user = $_POST['user'];

            if (!empty ($user["password"])) {
                $password = criptografia($user["password"]);
                $user["password"] = $password;
            }

            if (!empty($_FILES['foto']['name'])) {
                $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

                if ($extensao == 'jpg' || $extensao == 'jpeg' || $extensao == 'png') {
                    $nomeFoto = time() . "_" . $_FILES['foto']['name'];
                    $destino = __DIR__ . "/uploads/" . $nomeFoto;

                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                        $user['foto'] = $nomeFoto;
                    }
                } else {
                    $_SESSION['message'] = 'A foto deve estar no formato JPG, JPEG ou PNG.';
                    $_SESSION['type'] = 'danger';
                    return;
                }
            }

            update('users', $id, $user);
            header('location: index.php');
        } else {
            global $user;
            $user = find('usuarios', $id);
        }
    } else {
        header('location: index.php');
    }
}

/**
 *  Visualização de um Cliente
 */
function view($id = null)
{
    global $user;
    $user = find("usuarios", $id);
}

/**
 *  Exclusão de um Cliente
 */
function delete($id = null)
{
    global $user;
    $user = remove('usuarios', $id);

    header('location: index.php');
}
?>
