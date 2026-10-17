<?php
include "functions.php";
view($_GET['id']);
include HEADER_TEMPLATE;
?>

<h2 class="mt-2">Usuario <?php echo $user['id']; ?></h2>
<hr>

<?php if (!empty($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['type']; ?>">
        <?= $_SESSION['message']; ?>
    </div>
<?php endif; ?>

<dl class="dl-horizontal">
    <dt>Nome:</dt>
    <dd><?php echo $user['nome']; ?></dd>

    <dt>Login:</dt>
    <dd><?php echo $user['user']; ?></dd>

    <dt>Senha:</dt>
    <dd><?php echo $user['password']; ?></dd>

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

<div id="actions" class="row">
    <div class="col-md-12">
        <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-secondary">
            <i class="fa-solid fa-pen-to-square"></i> Editar
        </a>
        <a href="index.php" class="btn btn-light">
            <i class="fa-solid fa-arrow-rotate-left"></i> Voltar
        </a>
    </div>
</div>

<?php include FOOTER_TEMPLATE; ?>