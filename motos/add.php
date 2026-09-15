<?php
require_once "functions.php";
add();
include HEADER_TEMPLATE; ?>
<br>
<h2>Nova Moto</h2>
<form class="needs-validation" novalidate action="add.php" method="post" enctype="multipart/form-data">
    <!-- area de campos do form -->
    <hr>
    <div class="row g-3 mb-3">
        <div class="col-md-7">
            <label for="modelo" class="form-label">Modelo da Motocicleta</label>
            <input type="text" class="form-control" id="modelo" name="moto[modelo]" required>
            <div class="invalid-feedback">Informe o modelo.</div>
        </div>

        <div class="col-md-3">
            <label for="marca" class="form-label">Marca</label>
            <input type="text" class="form-control" id="marca" name="moto[marca]" required>
            <div class="invalid-feedback">Informe uma Marca.</div>
        </div>

        <div class="col-md-3">
            <label for="motor" class="form-label">Motor</label>
            <input type="text" class="form-control" id="motor" name="moto[motor]" required>
            <div class="invalid-feedback">Informe o Motor.</div>
        </div>

        <div class="col-md-2">
            <label for="datacad" class="form-label">Data de Cadastro</label>
            <input type="date" class="form-control" id="datacad" name="moto[datacad]" required>
            <div class="invalid-feedback">Informe a data de cadastro.</div>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-5">
            <label for="foto" class="form-label">Foto (Apenas formato .jpg, .jpeg e .png)</label>
            <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
            <div class="invalid-feedback">Envie a foto da motinha (Apenas formato .jpg, .jpeg e .png).</div>
        </div>

        <div class="col-md-3">
            <label for="placa" class="form-label">Placa</label>
            <input type="text" class="form-control" id="placa" name="moto[placa]" required>
            <div class="invalid-feedback">Informe a placa.</div>
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