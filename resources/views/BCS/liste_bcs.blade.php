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
                        <i class="mdi mdi-account-badge-horizontal-outline"></i>&nbsp;Liste Business case
                </div>
            <div class="card-body">
                <div class="table-responsive">

                    <table id="list_bcs" class="table table-bordered">
                        <thead>
                                <tr>
                                    <th>Date Demande</th>
                                    <th>Date Réalisation</th>
                                    <th>Medecin</th>
                                    <th>Type investisement</th>
                                    <th>Destination</th>
                                    <th>Montant</th>
                                    <th>Etat</th>
                                    <th>Action</th>
                                </tr>
                        </thead>
                        <tbody>
                            @foreach($bcs as $bc)
                                    <tr class="">
                                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d',$bc->date_demande)->format('d/m/Y')}}</td>
                                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d',$bc->date_realisation)->format('d/m/Y')}}</td>
                                        <td class="text-uppercase">{{$bc->medecin->nom .' '.$bc->medecin->prenom}}</td>
                                        <td class="text-capitalize">{{$bc->type}}</td>
                                        <td class="text-capitalize">{{$bc->destination}}</td>
                                        <td class="font-weight-bold">{{number_format($bc->montant,2,',',' ') . ' Dhs'}}</td>
                                        <td class="text-capitalize">{{$bc->etat}}</td>
                                        <td><a class="btn btn-sm btn-secondary" href="{{route('bcs.show',['id'=>$bc->bc_id])}}"> <i class="mdi mdi-eye"></i> Voir</a></td>
                                    </tr>
                                @endforeach
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
        var table = $("#list_bcs").DataTable({
            "language": {
                "url": "{{asset('theme/vendors/datatables.net/French.json')}}"
            }
        });
    });
</script>
@endpush


