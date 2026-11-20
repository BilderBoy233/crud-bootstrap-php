<?php
if (!isset($_SESSION)) {
    session_start();
}

include("../config.php");
require_once(DBAPI);

if (empty($_SESSION['user']) && empty($_SESSION['id'])) {
    $_SESSION['message'] = "Você precisa estar logado para acessar o perfil.";
    $_SESSION['type'] = "warning";
    header("Location: " . BASEURL . "inc/login.php");
    exit;
}

$bd = open_database();
$usuarioDados = null;

try {
    $bd->select_db(DB_NAME);

    if (!empty($_SESSION['id'])) {
        $id = (int) $_SESSION['id'];
        $sql = "SELECT * FROM usuarios WHERE id = {$id} LIMIT 1;";
    } else {
        $userEscapado = $bd->real_escape_string($_SESSION['user']);
        $sql = "SELECT * FROM usuarios WHERE user = '{$userEscapado}' LIMIT 1;";
    }

    $query = $bd->query($sql);

    if ($query && $query->num_rows > 0) {
        $usuarioDados = $query->fetch_assoc();

        $_SESSION['id'] = $usuarioDados['id'];
        $_SESSION['nome'] = $usuarioDados['nome'];
        $_SESSION['user'] = $usuarioDados['user'];
        $_SESSION['foto'] = !empty($usuarioDados['foto']) ? $usuarioDados['foto'] : 'semimagem.jpg';
    } else {
        throw new Exception("Não foi possível carregar os dados do usuário logado.");
    }
} catch (Exception $e) {
    $_SESSION['message'] = $e->getMessage();
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "index.php");
    exit;
}

$fotoPerfil = !empty($usuarioDados['foto']) ? $usuarioDados['foto'] : 'sem-foto.jpg';
$caminhoFoto = BASEURL . "usuarios/uploads/" . rawurlencode($fotoPerfil);
$isAdmin = (isset($usuarioDados['user']) && $usuarioDados['user'] === 'admin');

include(HEADER_TEMPLATE);
?>

<div class="py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
        <div>
            <h2 class="mb-0"><i class="fa-solid fa-id-card"></i> Meu Perfil</h2>
            <small class="text-muted">Informações da conta atualmente conectada</small>
        </div>
        <div class="d-flex gap-2">
            <a href="<?php echo BASEURL; ?>inc/editar_perfil.php" class="btn btn-secondary">
                <i class="fa-solid fa-user-pen"></i> Editar Perfil
            </a>
            <a href="<?php echo BASEURL; ?>index.php" class="btn btn-light">
                <i class="fa-solid fa-rotate-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="row g-4 align-items-start">
        <!-- Coluna esquerda: Card da foto e resumo -->
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm text-center p-4">
                <div class="d-flex justify-content-center mb-3">
                    <img src="<?php echo $caminhoFoto; ?>"
                         alt="Foto de <?php echo htmlspecialchars($usuarioDados['nome']); ?>"
                         class="rounded-circle shadow-sm border"
                         style="width: 150px; height: 150px; object-fit: cover;">
                </div>

                <h4 class="mb-1"><?php echo htmlspecialchars($usuarioDados['nome']); ?></h4>
                <p class="text-muted mb-2">@<?php echo htmlspecialchars($usuarioDados['user']); ?></p>

                <div class="mb-3">
                    <?php if ($isAdmin) : ?>
                        <span class="badge bg-primary"><i class="fa-solid fa-user-shield"></i> Administrador</span>
                    <?php else : ?>
                        <span class="badge bg-secondary"><i class="fa-solid fa-user"></i> Usuário Padrão</span>
                    <?php endif; ?>
                </div>

                <hr>

                <div class="d-grid gap-2">
                    <a href="<?php echo BASEURL; ?>inc/editar_perfil.php" class="btn btn-outline-secondary btn-sm">
                        <i class="fa-solid fa-camera"></i> Alterar Foto ou Dados
                    </a>
                    <a href="<?php echo BASEURL; ?>inc/logout.php" class="btn btn-outline-danger btn-sm">
                        <i class="fa-solid fa-person-walking-arrow-right"></i> Desconectar
                    </a>
                </div>
            </div>
        </div>

        <!-- Coluna direita: Detalhes completos do cadastro -->
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa-solid fa-circle-info"></i> Detalhes da Conta</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 py-2 border-bottom">ID do Usuário</dt>
                        <dd class="col-sm-8 py-2 border-bottom">#<?php echo htmlspecialchars($usuarioDados['id']); ?></dd>

                        <dt class="col-sm-4 py-2 border-bottom">Nome Completo</dt>
                        <dd class="col-sm-8 py-2 border-bottom"><?php echo htmlspecialchars($usuarioDados['nome']); ?></dd>

                        <dt class="col-sm-4 py-2 border-bottom">Usuário (Login)</dt>
                        <dd class="col-sm-8 py-2 border-bottom"><?php echo htmlspecialchars($usuarioDados['user']); ?></dd>

                        <dt class="col-sm-4 py-2 border-bottom">Senha</dt>
                        <dd class="col-sm-8 py-2 border-bottom text-muted">
                            <i class="fa-solid fa-lock"></i> Protegida por hash (não exibida por segurança)
                        </dd>

                        <dt class="col-sm-4 py-2 border-bottom">Arquivo da Foto</dt>
                        <dd class="col-sm-8 py-2 border-bottom">
                            <code><?php echo htmlspecialchars($fotoPerfil); ?></code>
                        </dd>

                        <dt class="col-sm-4 py-2">Nível de Acesso</dt>
                        <dd class="col-sm-8 py-2">
                            <?php echo $isAdmin ? 'Acesso administrativo (gerencia usuários e cadastros)' : 'Acesso padrão do sistema'; ?>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(FOOTER_TEMPLATE); ?>