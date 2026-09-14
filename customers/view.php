<?php
include "functions.php";
view($_GET['id']);
include HEADER_TEMPLATE;
?>


<div class="card-header mt-4">
    <h2 class="mt-2">Cliente <?php echo $customer['id']; ?></h2>
</div>
<div class="card">
    <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert alert-<?php echo $_SESSION['type']; ?>"><?= $_SESSION['message']; ?></div>
    <?php endif; ?>

    <div class="card-body">
        <dl class="row mb-3">
            <dt class="col-sm-4">Nome / Razão Social:</dt>
            <dd class="col-sm-8"><?php echo $customer['name']; ?></dd>

            <dt class="col-sm-4">CPF / CNPJ:</dt>
            <dd class="col-sm-8"><?php echo $customer['cpf_cnpj']; ?></dd>

            <dt class="col-sm-4">Data de Nascimento:</dt>
            <dd class="col-sm-8"><?php echo FormatData($customer['birthdate'], "d/m/y - H:i:s"); ?></dd>
        </dl>
        
        <dl class="row mb-3">
            <dt class="col-sm-4">Endereço:</dt>
            <dd class="col-sm-8"><?php echo $customer['address']; ?></dd>

            <dt class="col-sm-4">Bairro:</dt>
            <dd class="col-sm-8"><?php echo $customer['hood']; ?></dd>

            <dt class="col-sm-4">CEP:</dt>
            <dd class="col-sm-8"><?php echo FormatCep($customer['zip_code']); ?></dd>

            <dt class="col-sm-4">Data de Cadastro:</dt>
            <dd class="col-sm-8"><?php echo FormatData($customer['created'], "d/m/y - H:i:s"); ?></dd>

            <dt class="col-sm-4">Data da ultima atulização:</dt>
            <dd class="col-sm-8"><?php echo FormatData($customer['modified'], "d/m/y - H:i:s"); ?></dd>
        </dl>

        <dl class="row mb-0">
            <dt class="col-sm-4">Cidade:</dt>
            <dd class="col-sm-8"><?php echo $customer['city']; ?></dd>

            <dt class="col-sm-4">Telefone:</dt>
            <dd class="col-sm-8"><?php echo FormatTel($customer['phone']); ?></dd>

            <dt class="col-sm-4">Celular:</dt>
            <dd class="col-sm-8"><?php echo FormatTel($customer['mobile']); ?></dd>

            <dt class="col-sm-4">UF:</dt>
            <dd class="col-sm-8"><?php echo $customer['state']; ?></dd>

            <dt class="col-sm-4">Inscrição Estadual:</dt>
            <dd class="col-sm-8"><?php echo $customer['ie']; ?></dd>
        </dl>

    </div>
</div>
<div id="actions" class="row mt-4">
    <div class="col-md-12">
        <a href="edit.php?id=<?php echo $customer['id']; ?>" class="btn btn-secondary"><i
                class="fa-solid fa-pen-to-square"></i>Editar</a>
        <a href="index.php" class="btn btn-light"><i class="fa-solid fa-arrow-rotate-left"></i>Voltar</a>
    </div>
</div>

<?php
// include "modal.php";
include(FOOTER_TEMPLATE); ?>