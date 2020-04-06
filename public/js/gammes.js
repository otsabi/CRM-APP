$(document).ready(function () {

    $('#gamme_modif_Model').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) ;// Button that triggered the modal
        var gamme_id = button.data('whatever'); // Extract info from data-* attributes
        var gamme_libelle = button.data('user'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body>form').attr('action','/admin/gammes/'+gamme_id);
        modal.find('.modal-title>span').text(gamme_libelle);
        modal.find('.modal-body>form #gamme_libelle').val(gamme_libelle);

    });


    $('#gamme_delet_Model').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) ;// Button that triggered the modal
        var gamme_id = button.data('whatever'); // Extract info from data-* attributes
        var gamme_libelle = button.data('user'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body>form').attr('action','/admin/gammes/'+gamme_id);
        modal.find('.modal-title>span').text(gamme_libelle);


    });

    $("#gammes").DataTable({
        "language": {
            "url": "../theme/vendors/datatables.net/French.json"
        },
        "columnDefs": [ {
            "targets": 1,
            "searchable": false,
            "orderable": false
        } ]
    });




});
