@extends('layout.main')

@push('styles')
    <link rel="stylesheet" href="{{asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <style>

        td.details-control {
            background: url('{{asset('theme/images/plus.png')}}') no-repeat center center;
            cursor: pointer;
        }
        tr.shown td.details-control {
            background: url('{{asset('theme/images/remove.png')}}') no-repeat center center;
        }

    </style>
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
                    <i class="mdi mdi-account-group"></i>&nbsp; Rapport Med
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="example" class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Date de visite</th>
                                <th>Nom_Prenom</th>
                                <th>Plan/Réalisé</th>
                                <th>Potentiel</th>
                                <th>Etablissement</th>
                                <th>DELEGUE</th>
                            </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>


    </div>



@endsection



@push('scripts')
    <!--<script type="text/javascript" src="{{asset('theme/vendors/datatables.net/jquery.dataTables.js')}}"></script>-->
    <!--<script src="{{asset('theme/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>-->
    <!--<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>-->
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <!--<script src="{{asset('theme/js/data-table.js')}}"></script>-->

    <script>

        function format ( d ) {
            // `d` is the original data object for the row
            return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
                '<tr>'+
                '<td>P1 Présenté:</td>'+
                '<td>'+d.P1_présenté+'</td>'+
               
                '<td>P1 Feedback:</td>'+
                '<td>'+d.P1_Feedback+'</td>'+
              
                '<td>P1 Ech:</td>'+
                '<td>'+d.P1_Ech+'</td>'+
                '</tr>'+
                '<tr>'+
                '<td>P2 Présenté:</td>'+
                '<td>'+d.P2_présenté+'</td>'+
               
                '<td>P2 Feedback:</td>'+
                '<td>'+d.P2_Feedback+'</td>'+
                
                '<td>P2 Ech:</td>'+
                '<td>'+d.P2_Ech+'</td>'+
                '</tr>'+
                '<tr>'+
                '<td>P3 Présenté:</td>'+
                '<td>'+d.P3_présenté+'</td>'+
               
                '<td>P3 Feedback:</td>'+
                '<td>'+d.P3_Feedback+'</td>'+
               
                '<td>P3 Ech:</td>'+
                '<td>'+d.P3_Ech+'</td>'+
                '</tr>'+
                '<tr>'+
                '<td>P4 Présenté:</td>'+
                '<td>'+d.P4_présenté+'</td>'+
               
                '<td>P4 Feedback:</td>'+
                '<td>'+d.P4_Feedback+'</td>'+
                
                '<td>P4 Ech:</td>'+
                '<td>'+d.P4_Ech+'</td>'+
                '</tr>'+
                '<tr>'+
                '<td>P5 Présenté:</td>'+
                '<td>'+d.P5_présenté+'</td>'+
              
                '<td>P5 Feedback:</td>'+
                '<td>'+d.P5_Feedback+'</td>'+
              
                '<td>P5 Ech:</td>'+
                '<td>'+d.P5_Ech+'</td>'+
                '</tr>'+
                '</table>';
        }
        
        $(document).ready(function() {
            var table = $('#example').DataTable({
                //dataRapportMed
                 "ajax": {
                  "url": "dataRapportMed",
                    "dataSrc": ""
                },
                "columns": [
                    {
                        "className":      'details-control',
                        "orderable":      false,
                        "data":           null,
                        "defaultContent": ''
                    },
                    {"data": "Date_de_visite" },
                    {"data": "Nom_Prenom" },
                    {"data": "Plan/Réalisé" },
                    {"data": "Potentiel" },
                    {"data": "Etablissement" },
                    {"data": "DELEGUE" }

                ]
              
                
            } );

            // Add event listener for opening and closing details
            $('#example tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row( tr );

                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );
        } );
    </script>
@endpush
