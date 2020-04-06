@extends('layout.main')

@push('styles')
<link rel="stylesheet" href="{{asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
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

    <div class="col-sm-12">
        <div class="card">
                <div class="card-header">
                        <i class="mdi mdi-account-badge-horizontal-outline"></i>&nbsp; Pharmacies
                </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table id="list_pharmacies" class="table table-bordered">
                        <thead>
                                <tr>
                                    <th>Nom Pharmacie</th>
                                    <th>Ville</th>
                                    <th>Tel</th>
                                    <th>Zone</th>
                                    <th>Potentiel</th>
                                    <th>Valide</th>

                                    <th>Actions</th>

                                </tr>
                                <tr class="filter-row">
                                        <th></th>
                                        <th>Ville</th>
                                        <th></th>
                                        <th>Zone</th>
                                        <th>Potentiel</th>
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
<script src="{{asset('theme/vendors/datatables.net/dataTables.fixedHeader.min.js')}}"></script>
<script>
    $(document).ready(function () {
        var table = $("#list_pharmacies").DataTable({
            "language": {
                "url": "{{asset('theme/vendors/datatables.net/French.json')}}"
            },
            orderCellsTop: true,
            "processing": true,
            "serverSide": true,
            "iDisplayLength": 25,
            "ajax": "{{route('pharmacies.index')}}",
            "columns": [
                {"data": "libelle"},
                {"data": "ville.libelle"},
                {"data": "tel"},
                {"data": "zone_ph"},
                {"data": "potentiel"},
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
                        return '<a class="btn btn-sm btn-secondary" href="pharmacies/' + row.pharmacie_id + '"> <i class="mdi mdi-eye"></i> Voir</a>';
                    },
                    "searchable": false,
                    "sortable": false,
                }
            ],
            initComplete: function () {
                this.api().columns([1,3,4]).every( function () {
                    var column = this;
                    var select = $('<select><option value="">Choisir</option></select>')
                        .appendTo( $("#list_pharmacies thead tr:eq(1) th").eq(column.index()).empty() )
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
