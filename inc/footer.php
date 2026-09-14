<hr>
</main> <!-- /container -->

<footer class="container">
	<?php $dt = new DateTime("now", new DateTimeZone("America/Sao_Paulo")); ?>
	<p><strong>&copy;2026 à <?= $dt->format("Y"); ?> - Italo e Rafaell</strong></p>
</footer>

<script src="<?php echo BASEURL; ?>js/jquery-4.0.0.js"></script>
<script src="<?php echo BASEURL; ?>js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASEURL; ?>js/all.min.js"></script>
<script src="<?php echo BASEURL; ?>js/main.js"></script>
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
</body>

</html>