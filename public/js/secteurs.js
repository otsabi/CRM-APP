$(document).ready(function () {
    $('#deleteModel').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var secteur_id = button.data('whatever');// Extract info from data-* attributes
        var secteur_info = button.data('info');// Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body>.lead').html(''+secteur_info);
        modal.find('.modal-body>form').attr('action','/admin/secteurs/'+secteur_id);
    });

    $('#deleteModel').on('hide.bs.modal', function (event) {
        var modal = $(this);
        modal.find('.modal-body>.lead').html('');
        modal.find('.modal-body>form').removeAttr('action');
    });

    $('#updateModel').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var secteur_id = button.data('whatever');// Extract info from data-* attributes
        var secteur = button.data('secteur');// Extract info from data-* attributes

        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body #up_libelle').val(secteur);
        modal.find('.modal-body>form').attr('action','/admin/secteurs/'+secteur_id);
    });

    $('#updateModel').on('hide.bs.modal', function (event) {
        var modal = $(this);
        modal.find('.modal-body #up_libelle').val('');
        modal.find('.modal-body>form').removeAttr('action');
    });

    $("#list_secteur").DataTable({
        "language": {
            "url": "../theme/vendors/datatables.net/French.json"
        },
        "columnDefs": [ {
            "targets": 2,
            "searchable": false,
            "orderable": false
        } ]
    });
});
