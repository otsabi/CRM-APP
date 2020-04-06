$(document).ready(function () {
    $('#deleteModel').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var prod_id = button.data('whatever');// Extract info from data-* attributes
        var prod_info = button.data('info');// Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body>.lead').html(''+prod_info);
        modal.find('.modal-body>form').attr('action','/admin/products/'+prod_id);
    });

    $('#deleteModel').on('hide.bs.modal', function (event) {
        var modal = $(this);
        modal.find('.modal-body>.lead').html('');
        modal.find('.modal-body>form').removeAttr('action');
    });

    $('#updateModel').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var prod_id = button.data('whatever');// Extract info from data-* attributes
        var prod_code = button.data('code');// Extract info from data-* attributes
        var prod_gamme = button.data('gamme');// Extract info from data-* attributes
        var prod_libelle = button.data('libelle');// Extract info from data-* attributes
        var prod_price = button.data('price');// Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body #up_code').val(prod_code);
        modal.find('.modal-body #up_libelle').val(prod_libelle);
        modal.find('.modal-body #up_price').val(prod_price);
        modal.find('.modal-body #up_gamme option[value="'+prod_gamme+'"]').prop('selected', true);
        modal.find('.modal-body>form').attr('action','/admin/products/'+prod_id);
    });

    $('#updateModel').on('hide.bs.modal', function (event) {
      var modal = $(this);
        modal.find('.modal-body #up_code').val('');
        modal.find('.modal-body #up_libelle').val('');
        modal.find('.modal-body #up_price').val('');
        modal.find('.modal-body #up_gamme option[value=""]').prop('selected', true);
        modal.find('.modal-body>form').removeAttr('action');
    });

    $("#produits").DataTable({
        "language": {
            "url": "../theme/vendors/datatables.net/French.json"
        },
        "columnDefs": [ {
            "targets": 4,
            "searchable": false,
            "orderable": false
        } ]
    });
});