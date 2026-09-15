/**
 * Passa os dados do cliente para o Modal, e atualiza o link para exclusão
 */
$('#delete-modal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var id = button.data('id');
  var type = button.data('type'); // cliente ou moto
  
  var modal = $(this);
  modal.find('.modal-title').text('Excluir ' + type.charAt(0).toUpperCase() + type.slice(1) + ' #' + id);
  modal.find('.modal-body').text('Deseja mesmo excluir o ' + type + ' (' + id + ')?');
  modal.find('#confirm').attr('href', '/crud-bootstrap-php/' + type + '/delete.php?id=' + id);
});
