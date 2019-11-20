
$('#ModalTaskEdit').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget);
  var id = button.data('id');
  var task = button.data('task');
  var modal = $(this);
  modal.find('.modal-body input#id').val(id);
  modal.find('.modal-body input#task').val(task);
});


$('#updateTask').click(function() {
  var id = $('#id').val();
  var task = $('#task').val();
  $.ajax({
    type: 'POST',
    dataType: 'json',
    url: 'update/text',
    data: {
      id: id  ,
      task: task
    },
    success: function(data) {
      if (!data['success']){
        window.location.href = "/admin/login/";
      }
      window.location.reload();
    }
  });
});

$('.status').click(function (event) {
  let button = $(this);
  let id = button.data('id');
  let status = button.attr('aria-pressed');
  // let status = button.attr('aria-pressed','false');
  let result = status ? 1 : 0;
  $.ajax({
    type: 'POST',
    url: 'update/status',
    data: {
      id: id,
      status: result
    },
    success: function (data) {
      if (!data['success']){
        window.location.href = "/admin/login/";
      }
    }
  });
});

function sortTasks(field, dir) {

  let urlParams = new URLSearchParams(window.location.search);
  let addParam = '';

  if (urlParams.has('page')) {
    let pageProp = urlParams.get('page');
    addParam = '?page=' + pageProp + '&' + field + '=' + dir;
  } else {
    addParam = '?' + field + '=' + dir;
  }
  window.location.href = addParam;
}
