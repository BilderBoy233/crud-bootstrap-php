<?php
if (!isset($_SESSION)) {
    session_start();
}

include("../config.php");
require_once(DBAPI);

// Carrega criptografia caso exista em usuarios/functions.php
if (!function_exists('criptografia') && file_exists("../usuarios/functions.php")) {
    include_once("../usuarios/functions.php");
}

if (empty($_SESSION['user']) && empty($_SESSION['id'])) {
    $_SESSION['message'] = "Você precisa estar logado para editar seu perfil.";
    $_SESSION['type'] = "warning";
    header("Location: " . BASEURL . "inc/login.php");
    exit;
}

$bd = open_database();
$bd->select_db(DB_NAME);

// Identifica exclusivamente o usuário logado
if (!empty($_SESSION['id'])) {
    $id = (int) $_SESSION['id'];
    $res = $bd->query("SELECT * FROM usuarios WHERE id = {$id} LIMIT 1;");
} else {
    $userEsc = $bd->real_escape_string($_SESSION['user']);
    $res = $bd->query("SELECT * FROM usuarios WHERE user = '{$userEsc}' LIMIT 1;");
}

if (!$res || $res->num_rows === 0) {
    $_SESSION['message'] = "Usuário não encontrado.";
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "index.php");
    exit;
}

$usuario = $res->fetch_assoc();
$id = (int) $usuario['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['usuario'])) {
    try {
        $nomeNovo = trim($_POST['usuario']['nome'] ?? '');
        $userNovo = trim($_POST['usuario']['user'] ?? '');
        $senhaNova = $_POST['usuario']['password'] ?? '';

        if ($nomeNovo === '' || $userNovo === '') {
            throw new Exception("Nome e Usuário (Login) são obrigatórios.");
        }

        // Impede que um usuário comum se renomeie para 'admin'
        if ($usuario['user'] !== 'admin' && strtolower($userNovo) === 'admin') {
            throw new Exception("Nome de usuário reservado.");
        }

        $dadosAtualizar = [
            'nome' => $nomeNovo,
            'user' => $userNovo
        ];

        if ($senhaNova !== '') {
            $dadosAtualizar['password'] = function_exists('criptografia')
                ? criptografia($senhaNova)
                : $senhaNova;
        }

        // Upload de nova foto se enviada
        if (!empty($_FILES['foto']['name'])) {
            $pastaDestino = "../usuarios/fotos/";
            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0775, true);
            }

            $nomeOriginal = basename($_FILES['foto']['name']);
            $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png', 'gif'];

            if (!in_array($extensao, $permitidos, true)) {
                throw new Exception("Apenas imagens JPG, JPEG, PNG e GIF são permitidas.");
            }
            if ($_FILES['foto']['size'] > 5000000) {
                throw new Exception("O arquivo é muito grande (máx. 5MB).");
            }

            $nomeArquivo = time() . "_" . preg_replace("/[^a-zA-Z0-9._-]/", "_", $nomeOriginal);
            $caminhoDestino = $pastaDestino . $nomeArquivo;

            if (!move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoDestino)) {
                throw new Exception("Não foi possível salvar a nova foto.");
            }

            $dadosAtualizar['foto'] = $nomeArquivo;
        }

        // Monta o UPDATE direto no banco para o ID do usuário logado
        $setPartes = [];
        foreach ($dadosAtualizar as $coluna => $valor) {
            $valEsc = $bd->real_escape_string($valor);
            $setPartes[] = "`{$coluna}` = '{$valEsc}'";
        }
        $sqlUpdate = "UPDATE usuarios SET " . implode(", ", $setPartes) . " WHERE id = {$id} LIMIT 1;";

        if (!$bd->query($sqlUpdate)) {
            throw new Exception("Erro ao atualizar o perfil no banco de dados.");
        }

        // Atualiza sessão
        $_SESSION['id'] = $id;
        $_SESSION['nome'] = $nomeNovo;
        $_SESSION['user'] = $userNovo;
        if (isset($dadosAtualizar['foto'])) {
            $_SESSION['foto'] = $dadosAtualizar['foto'];
        }

        $_SESSION['message'] = "Perfil atualizado com sucesso!";
        $_SESSION['type'] = "success";
        header("Location: " . BASEURL . "inc/perfil.php");
        exit;
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['type'] = "danger";
        $usuario['nome'] = $_POST['usuario']['nome'] ?? $usuario['nome'];
        $usuario['user'] = $_POST['usuario']['user'] ?? $usuario['user'];
    }
}

$fotoAtual = !empty($usuario['foto']) ? $usuario['foto'] : 'semimagem.jpg';

include(HEADER_TEMPLATE);
?>

<div class="py-4">
    <header class="mb-4">
        <h2><i class="fa-solid fa-user-pen"></i> Editar Meu Perfil</h2>
    </header>

    <?php if (!empty($_SESSION['message'])) : ?>
        <div class="alert alert-<?php echo htmlspecialchars($_SESSION['type'] ?? 'info'); ?> alert-dismissible fade show" role="alert">
            <?php echo htmlspecialchars($_SESSION['message']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['type']); ?>
    <?php endif; ?>

    <form action="<?php echo BASEURL; ?>inc/editar_perfil.php" method="post" enctype="multipart/form-data">
        <hr>
        <div class="row">
            <div class="form-group col-md-8 mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="usuario[nome]" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4 mb-3">
                <label for="campo2" class="form-label">Usuário (Login)</label>
                <input type="text" class="form-control" id="campo2" name="usuario[user]" value="<?php echo htmlspecialchars($usuario['user']); ?>" required>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4 mb-3">
                <label for="campo3" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                <input type="password" class="form-control" id="campo3" name="usuario[password]" value="">
            </div>
        </div>

        <div class="row align-items-center">
            <div class="form-group col-md-4 mb-3">
                <label for="foto" class="form-label">Foto</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
            </div>
            <div class="form-group col-md-2 mb-3">
                <label class="form-label d-block">Pré-visualização:</label>
                <img class="img-thumbnail shadow-sm"
                     id="imgPreview"
                     src="<?php echo BASEURL; ?>usuarios/uploads/<?php echo rawurlencode($fotoAtual); ?>"
                     alt="Foto do usuário"
                     style="width: 90px; height: 90px; object-fit: cover;">
            </div>
        </div>

        <div id="actions" class="row mt-3">
            <div class="col-md-12 d-flex gap-2">
                <button type="submit" class="btn btn-secondary">
                    <i class="fa-solid fa-sd-card"></i> Salvar
                </button>
                <a href="<?php echo BASEURL; ?>inc/perfil.php" class="btn btn-light">
                    <i class="fa-solid fa-rotate-left"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const inputFoto = document.getElementById("foto");
        const imgPreview = document.getElementById("imgPreview");
        if (inputFoto && imgPreview) {
            inputFoto.addEventListener("change", function () {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        imgPreview.src = event.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
</script>

<?php include(FOOTER_TEMPLATE); ?>