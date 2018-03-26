(function($){
  $("#delete-link").on("click", function(e) {
    e.preventDefault();
    if (confirm("Está seguro de eliminar esta cuenta?")) {
      $(this).closest('form').submit();
    }
  });
}(jQuery));
