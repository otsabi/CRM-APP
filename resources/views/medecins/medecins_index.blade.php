@extends('layout.main')

@push('styles')
<link rel="stylesheet" href="{{asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset('theme/vendors/datatables.net-bs4/responsive.dataTables.min.css')}}">
@endpush

@section('content')

    <div class="row">

        <div class="col-sm-12">
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    Well done ! -  {{session('status')}}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <h6>Oops ! </h6>
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

    </div>

    <div class="row">
        <div class="col-sm-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="mdi mdi-account-group"></i>&nbsp; Médecins
                    </h5>
                </div>
                <div class="card-body">

                    <div class="table-responsive">

                        <table id="list_medecins" class="table table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>prenom</th>
                                    <th>Specialité</th>
                                    <th>Etablissement</th>
                                    <th>Potentiel</th>
                                    <th>Zone</th>
                                    <th>Ville</th>
                                    <th>Valid</th>
                                    <th>Actions</th>
                                </tr>

                                <tr class="filter-row">
                                    <th></th>
                                    <th></th>
                                    <th>Specialité</th>
                                    <th>Etablissement</th>
                                    <th>Potentiel</th>
                                    <th>Zone</th>
                                    <th>Ville</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{asset('theme/vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
<script src="{{asset('theme/vendors/datatables.net-bs4/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('theme/vendors/datatables.net/dataTables.fixedHeader.min.js')}}"></script>
<script>
    $(document).ready(function () {
        var table = $("#list_medecins").DataTable({

            "language": {
                "url": "{{asset('theme/vendors/datatables.net/French.json')}}"
            },
            orderCellsTop: true,
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('medecins.index')}}",
            "iDisplayLength": 25,
            "columns": [
                {"data": "nom"},
                {"data": "prenom"},
                {"data": "specialite.code"},
                {"data": "etablissement"},
                {"data": "potentiel"},
                {"data": "zone_med"},
                {"data": "ville.libelle"},
                {
                    "data": "",
                     "name":"",
                    "render": function (data, type, row, meta) {
                        return row.valid == 0 ? 'En cours' : 'validé';
                    }

                },
                {
                    "data": "",
                    "name":"",
                    "render": function (data, type, row, meta) {
                        return '<a class="btn btn-sm btn-secondary" href="medecins/' + row.medecin_id + '"> <i class="mdi mdi-eye"></i> Voir</a>';
                    },
                    "searchable": false,
                    "sortable": false,
                }
            ],
            initComplete: function () {
                this.api().columns([2,3,4,5,6]).every( function () {
                    var column = this;
                    var select = $('<select><option value="">Choisir...</option></select>')
                        .appendTo( $("#list_medecins thead tr:eq(1) th").eq(column.index()).empty() )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        });
    });
</script>
@endpush
