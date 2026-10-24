<?php 
if (!isset($_SESSION)) {
    session_start();
}
include "../config.php";
include (HEADER_TEMPLATE);
?>

<div id="actions" class="mt-5 mb-5 container">
    <h2 class="mb-4">Login do Sistema</h2>

    <!-- Exibe mensagens de aviso/erro caso venham do valida.php -->
    <?php if (!empty($_SESSION['message'])) : ?>
        <div class="alert alert-<?php echo $_SESSION['type']; ?> alert-dismissible fade show" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php 
            unset($_SESSION['message']);
            unset($_SESSION['type']);
        ?>
    <?php endif; ?>

    <form action="valida.php" method="post">
        <div class="row">
            <!-- User input -->
            <div class="form-floating col-12 mb-3">
                <input type="text" class="form-control" id="log" name="login" placeholder="Usuário" required>
                <label for="log">Usuário</label>
            </div>
            
            <!-- Password input -->
            <div class="form-floating col-12 mb-3">
                <input type="password" class="form-control" id="pass" name="senha" placeholder="Senha" required>
                <label for="pass">Senha</label>
            </div>
            
            <!-- Submit button -->
            <div class="col-12 mb-3">
                <button type="submit" class="btn btn-secondary mb-2">
                    <i class="fa-solid fa-user-check"></i> Conectar
                </button>
                <a href="<?php echo BASEURL; ?>" class="btn btn-light">
                    <i class="fa-solid fa-rotate-left"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
</div>

<?php include (FOOTER_TEMPLATE); ?>