<?php
require_once "functions.php";
add();
include HEADER_TEMPLATE; ?>
<br>
<h2>Novo Cliente</h2>
<form class="needs-validation" novalidate action="add.php" method="post">
    <!-- area de campos do form -->
    <hr>
    <div class="row g-3 mb-3">
        <div class="col-md-7">
            <label for="name" class="form-label">Nome / Razão Social</label>
            <input type="text" class="form-control" id="name" name="customer[name]" required>
            <div class="invalid-feedback">Informe o nome ou a razão social.</div>
        </div>

        <div class="col-md-3">
            <label for="cpf_cnpj" class="form-label">CNPJ / CPF</label>
            <input type="number" class="form-control" id="cpf_cnpj" name="customer[cpf_cnpj]" minlength="11"
                maxlength="14" required>
            <div class="invalid-feedback">Informe um CPF (11 dígitos) ou CNPJ (14 dígitos).</div>
        </div>

        <div class="col-md-2">
            <label for="birthdate" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" id="birthdate" name="customer[birthdate]" required>
            <div class="invalid-feedback">Informe a data de nascimento.</div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-5">
            <label for="address" class="form-label">Endereço</label>
            <input type="text" class="form-control" id="address" name="customer[address]" required>
            <div class="invalid-feedback">Informe o endereço.</div>
        </div>

        <div class="col-md-3">
            <label for="hood" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="hood" name="customer[hood]" required>
            <div class="invalid-feedback">Informe o bairro.</div>
        </div>

        <div class="col-md-2">
            <label for="zip_code" class="form-label">CEP</label>
            <input type="number" class="form-control" id="zip_code" name="customer[zip_code]" minlength="8" maxlength="8"
                required>
            <div class="invalid-feedback">Informe um CEP com 8 dígitos.</div>
        </div>

        <div class="col-md-2">
            <label for="created" class="form-label">Data de Cadastro</label>
            <input type="date" class="form-control" id="created" name="customer[created]" required>
            <div class="invalid-feedback">Informe a data de cadastro.</div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-5">
            <label for="city" class="form-label">Município</label>
            <input type="text" class="form-control" id="city" name="customer[city]" required>
            <div class="invalid-feedback">Informe o município.</div>
        </div>

        <div class="col-md-2">
            <label for="phone" class="form-label">Telefone</label>
            <input type="tel" class="form-control" id="phone" name="customer[phone]" minlength="10" maxlength="11"
                required>
            <div class="invalid-feedback">Informe um telefone válido.</div>
        </div>

        <div class="col-md-2">
            <label for="mobile" class="form-label">Celular</label>
            <input type="tel" class="form-control" id="mobile" name="customer[mobile]" minlength="10" maxlength="11"
                required>
            <div class="invalid-feedback">Informe um celular válido.</div>
        </div>

        <div class="col-md-1">
            <label for="state" class="form-label">UF</label>
            <input type="text" class="form-control" id="state" name="customer[state]" minlength="2" maxlength="2"
                required>
            <div class="invalid-feedback">UF inválida.</div>
        </div>

        <div class="col-md-2">
            <label for="ie" class="form-label">Inscrição Estadual</label>
            <input type="text" class="form-control" id="ie" name="customer[ie]" required>
            <div class="invalid-feedback">Informe a inscrição estadual.</div>
        </div>
    </div>

    <div id="actions" class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-secondary"><i class="fa-solid fa-floppy-disk"></i>Salvar</button>
            <a href="index.php" class="btn btn-light"><i class="fa-regular fa-circle-xmark"></i>Cancelar</a>
        </div>
    </div>
</form>
<script>
    (() => {
    'use strict'
    document.querySelectorAll('.needs-validation').forEach((form) => {
      form.addEventListener('submit', (event) => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
  })()
</script>
<?php
include FOOTER_TEMPLATE;
?>