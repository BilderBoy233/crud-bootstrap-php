<?php
//esse é o view.php
require_once('functions.php');
if (!isset($_SESSION)) session_start();
if (isset($_SESSION['user'])){ // Verifica se tem um usuário logado
    if ($_SESSION['user'] != "admin") { // Verifica se o usuário é admin
        $_SESSION['message'] = "Você precisa ser administrador para acessar esse recurso!";
        $_SESSION['type'] = "danger";
        header("Location: " . BASEURL . "index.php");
    }
} else {
    $_SESSION['message'] = "Você precisa estar logado e ser administrador para acessar esse recurso!";
    $_SESSION['type'] = "danger";
    header("Location: " . BASEURL . "index.php");
}
view($_GET['id']);
include(HEADER_TEMPLATE);
?>

<?php if (!empty($_SESSION['message'])) : ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible" role="alert" id="actions">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php else : ?>
    <header>
        <h2>Cliente <?php echo $user['id']; ?></h2>
    </header>
    <hr>

    <dl class="dl-horizontal">
        <dt>Nome:</dt>
        <dd><?php echo $user['nome']; ?></dd>

        <dt>Login:</dt>
        <dd><?php echo $user['user']; ?></dd>

        <dt>Senha:</dt>
        <dd><?php echo $user['password']; ?></dd>

        <dt>Foto:</dt>
        <dd class="col-sm-9">
                <?php if (!empty($user['foto']) && file_exists("uploads/" . $user['foto'])): ?>
                    <img src="uploads/<?php echo $user['foto']; ?>"
                        alt="Foto do usuário"
                        style="width: 400px; height: 300px; object-fit: cover;">
                <?php else: ?>
                    <img src="fotos/sem-foto.jpg"
                        alt="Sem foto"
                        style="width: 400px; height: 300px; object-fit: cover;">
                <?php endif; ?>
            </dd>
    </dl>
<?php endif; ?>

<div id="actions" class="row">
    <div class="col-md-12">
        <?php if (empty($_SESSION['message'])) : ?>
            <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-secondary"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
        <?php endif; ?>
        <a href="index.php" class="btn btn-light"><i class="fa-solid fa-rotate-left"></i> Voltar</a>
    </div>
</div>
<?php clear_message(); ?>

<?php include(FOOTER_TEMPLATE); ?>