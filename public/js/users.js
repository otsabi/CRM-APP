$(document).ready(function () {

    $('#deleteModel').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) ;// Button that triggered the modal
        var user_id = button.data('whatever'); // Extract info from data-* attributes
        var nomprenom = button.data('user'); // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this);
        modal.find('.modal-body>form').attr('action','/admin/users/'+user_id);
        modal.find('.modal-title>span').text(nomprenom);

    })

    // Setup - add a text input to each footer cell
    $('#users thead tr').clone(true).appendTo( '#users thead' );

    $('#users thead tr:eq(1) th').each( function (i) {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );

                $( 'input', this ).on( 'keyup change', function () {
                    if ( table.column(i).search() !== this.value ) {
                        table
                            .column(i)
                            .search( this.value )
                            .draw();
                    }

                } );

    } );

    var table = $(document).ready(function () {
        $("#list_users").DataTable({
            "language": {
                "url": "../theme/vendors/datatables.net/French.json"
            },
            "processing": true,
            "serverSide": true,
            "ajax": "/admin/users",
            "columns": [
                {
                    "data": "manager",
                    "render": function ( data, type, row) {
                        return data.manager === null ? '' : data.nom;
                    },
                    visible:false
                },
                {
                    "data": "manager",
                    "render": function ( data, type, row) {
                        return data.manager === null ? '' : data.prenom;
                    },
                    visible:false
                },
                { "data": "nom" },
                { "data": "prenom" },
                { "data": "email" },
                { "data": "tel" },
                { "data": "role.libelle" },
                { "data": "ville.libelle" },
                {
                     "data": "manager",
                     "searchable" :false,
                     "render": function ( data, type, row) {
                        return data.manager === null ? '' : data.nom + ' ' + data.prenom;
                    }
                },
                {
                     "data": "gamme",
                     "render": function ( data, type, row) {
                        return data === null ? '' : data.libelle;
                      }
                },
                {
                    "data":null,
                    "render": function ( data, type, row) {
                        return "<a href='"+ data.user_id +"'>modifier</a>";
                    }
                },
            ],
        });
    });

});



