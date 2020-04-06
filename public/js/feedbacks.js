$(document).ready(function () {

    $('#feedback_modif_Model').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) ;// Button that triggered the modal
        var feedback_id = button.data('whatever'); // Extract info from data-* attributes
        var feedback_libelle = button.data('user'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body>form').attr('action','/admin/feedbacks/'+feedback_id);
        modal.find('.modal-title>span').text(feedback_libelle);
        modal.find('.modal-body>form #feedback_libelle').val(feedback_libelle);

    });


    $('#feedback_delet_Model').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) ;// Button that triggered the modal
        var feedback_id = button.data('whatever'); // Extract info from data-* attributes
        var feedback_libelle = button.data('user'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body>form').attr('action','/admin/feedbacks/'+feedback_id);
        modal.find('.modal-title>span').text(feedback_libelle);


    });

    $("#feedbacks").DataTable({
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
