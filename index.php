<?php
if (!isset($_SESSION)) {
    session_start();
}

include "config.php";
include DBAPI;
include HEADER_TEMPLATE;

try {
    $db = open_database();
    $erro = "";
} catch (Exception $e) {
    $erro = $e->getMessage();
}
?>

<h1>Dashboard</h1>
<hr>

<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-<?= htmlspecialchars($_SESSION['type'] ?? 'info') ?> alert-dismissible fade show" role="alert">
        <?php if ($erro != "") : ?>
            <p class="mb-1"><strong>ERRO:</strong> Não foi possível Conectar ao Banco de Dados!</p>
        <?php endif; ?>
        <?= htmlspecialchars($_SESSION['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php
        if (function_exists('clear_message')) {
            clear_message();
        } else {
            unset($_SESSION['message'], $_SESSION['type']);
        }
    ?>
<?php endif; ?>

<?php if ($erro == ""): ?>

    <div class="row">
        <?php if (isset($_SESSION['user'])) : ?>
            <div class="col-xs-6 col-sm-3 col-md-2">
                <a href="customers/add.php" class="btn btn-secondary">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <i class="fa fa-user-plus fa-5x"></i>
                        </div>
                        <div class="col-xs-12 text-center">
                            <p>Novo Cliente</p>
                        </div>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <div class="col-xs-6 col-sm-3 col-md-2">
            <a href="customers" class="btn btn-light">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-12 text-center">
                        <p>Clientes</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="row mt-2">
        <?php if (isset($_SESSION['user'])) : ?>
            <div class="col-xs-6 col-sm-3 col-md-2">
                <a href="motos/add.php" class="btn btn-secondary">
                    <div class="row">
                        <div class="col-xs-12 text-center"><i class="fa-solid fa-plus fa-5x"></i></div>
                        <div class="col-xs-12 text-center"><p>Nova Moto</p></div>
                    </div>
                </a>
            </div>
        <?php endif; ?>

        <div class="col-xs-6 col-sm-3 col-md-2">
            <a href="motos" class="btn btn-light">
                <div class="row">
                    <div class="col-xs-12 text-center"><i class="fa-solid fa-motorcycle fa-5x"></i></div>
                    <div class="col-xs-12 text-center"><p>Motos</p></div>
                </div>
            </a>
        </div>
    </div>

    <?php if (isset($_SESSION['user'])) : ?>
        <?php if ($_SESSION['user'] == "admin") : ?>
            <div class="row mt-2">
                <div class="col-xs-6 col-sm-3 col-md-2">
                    <a href="usuarios/add.php" class="btn btn-secondary">
                        <div class="row">
                            <div class="col-xs-12 text-center"><i class="fa-solid fa-user-tie fa-5x"></i></div>
                            <div class="col-xs-12 text-center"><p>Novo Usuário</p></div>
                        </div>
                    </a>
                </div>
                <div class="col-xs-6 col-sm-3 col-md-2">
                    <a href="usuarios" class="btn btn-light">
                        <div class="row">
                            <div class="col-xs-12 text-center"><i class="fa-solid fa-users-gear fa-5x"></i></div>
                            <div class="col-xs-12 text-center"><p>Usuários</p></div>
                        </div>
                    </a>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

<?php endif; ?>

<?php include FOOTER_TEMPLATE; ?>