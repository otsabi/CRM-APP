@extends('layout.main')

@section('content')


    <div class="row">
        <div class="col-sm-12">
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    Well done ! - {{session('status')}}
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
        <div class="col-sm-12">

            <div class="card">

                <div class="card-body">

                    <h4 class="card-title">
                        <span class="badge badge-secondary">{{$visites->total()}}</span> Visites trouvées
                    </h4>

                    <table class="table table-bordered table-sm">
                        <thead>
                        <tr>
                            <th scope="col">date visite</th>
                            <th scope="col">Pharmacie</th>
                            <th scope="col">Potentiel</th>
                            <th scope="col">Zone Pharma</th>
                            <th scope="col">Ville</th>
                            <th scope="col">Etat visite</th>
                            <th scope="col">Délégue</th>
                            <th scope="col">Voir</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($visites as $visite)
                            <tr>
                                <td>{{Carbon\Carbon::createFromFormat('Y-m-d',$visite->date_visite)->format('d/m/Y')}}</td>
                                <td>{{$visite->pharmacie->libelle}}</td>
                                <td>{{$visite->pharmacie->potentiel}}</td>
                                <td>{{$visite->pharmacie->zone_ph}}</td>
                                <td>{{$visite->pharmacie->ville->libelle}}</td>
                                <td>{{$visite->etat}}</td>
                                <td>{{$visite->created_by}}</td>
                                <td class="text-center text-secondary">
                                    <a href="{{route('admin.visiteph_show',['id'=>$visite->visitephar_id])}}" target="_blank">
                                        <i class="mdi mdi-information-outline"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <nav class="mt-5">
                        <ul class="pagination d-flex justify-content-center pagination-rounded">
                            {{ $visites->appends([
                                                   'dt_d'=>Request::input('dt_d'),
                                                   'dt_f'=>Request::input('dt_f'),
                                                   'etat'=>Request::input('etat'),
                                                   'user'=>Request::input('user'),
                                                   'sect'=>Request::input('sect'),
                                                    ])->links() }}
                        </ul>
                    </nav>

                    <a href="{{route('admin.visiteph')}}" class="btn btn-secondary mt-5">Retour</a>

                </div>

            </div>

        </div>
    </div>


@endsection