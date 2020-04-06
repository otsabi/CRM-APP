$(document).ready(function () {

    $('#specialite_modif_Model').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) ;// Button that triggered the modal
        var specialite_id = button.data('whatever'); // Extract info from data-* attributes
        var specialite_code = button.data('code');
        var specialite_libelle = button.data('libelle');
        var gamme_libelle = button.data('gamme'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body>form').attr('action','/admin/specialites/'+specialite_id);
        modal.find('.modal-title>span').text(specialite_code);
        modal.find('.modal-body>form #specialite_code').val(specialite_code);
        modal.find('.modal-body>form #specialite_libelle').val(specialite_libelle);
        modal.find('.modal-body>form #gamme_libelle').val(gamme_libelle);

    });


    $('#specialite_delet_Model').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) ;// Button that triggered the modal
        var specialite_id = button.data('whatever'); // Extract info from data-* attributes
        var specialite_code = button.data('code'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body>form').attr('action','/admin/specialites/'+specialite_id);
        modal.find('.modal-title>span').text(specialite_code);


    });

    $("#specialites").DataTable({
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
