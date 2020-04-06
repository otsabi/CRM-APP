@extends('layout.main')


@section('content')
<div class="row">

        <div class="col-sm-12">
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    Well done! -  {{session('status')}}
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

        <div class="col-sm-12 col-md-6 grid-margin stretch-card">

            <div class="card">
                <div class="card-header">
                    <i class="mdi mdi-account-box"></i>&nbsp;Fiche Médecin
                </div>

                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-4 mb-3 col-md-5">Nom Prenom</dt>
                        <dd class="col-sm-8 mb-md-3 text-uppercase col-md-6">{{$medecin->nom}} {{$medecin->prenom}}</dd>

                        <dt class="col-sm-4 my-3 col-md-5">Spécialite</dt>
                        <dd class="col-sm-8 my-md-3 text-uppercase col-md-6"> {{$medecin->specialite->code}} </dd>

                        <dt class="col-sm-4 my-3 col-md-5">Etablissement</dt>
                        <dd class="col-sm-8 my-md-3 text-uppercase col-md-5">{{$medecin->etablissement}}</dd>

                        <dt class="col-sm-4 my-3 col-md-5">Potentiel</dt>
                        <dd class="col-sm-8 my-md-3 text-uppercase col-md-5">{{$medecin->potentiel}}</dd>

                        <dt class="col-sm-4 my-3 col-md-5">Zone</dt>
                        <dd class="col-sm-8 my-md-3 text-uppercase col-md-5">{{$medecin->zone_med}}</dd>

                        <dt class="col-sm-4 my-3 col-md-5">Ville</dt>
                        <dd class="col-sm-8 my-md-3 text-uppercase col-md-5">{{$medecin->ville->libelle}}</dd>

                        <dt class="col-sm-4 my-3 col-md-5">Télephone</dt>
                        <dd class="col-sm-8 my-md-3 col-md-5">{{$medecin->tel}}</dd>

                        <dt class="col-sm-4 my-3 col-md-5">Adresse</dt>
                        <dd class="col-sm-8 my-md-3 col-md-5">{{$medecin->adresse}}</dd>

                        <dt class="col-sm-4 my-3 col-md-5">Validation</dt>
                        <dd class="col-sm-8 col-md-4 my-md-3">
                            @if($medecin->valid)
                                <span class="badge badge-success">validé</span>
                            @else
                                <span class="badge badge-secondary">En cours</span>
                            @endif
                        </dd>

                    </dl>

                    @if($medecin->visites->count() <= 0 && !$medecin->valid)
                        <form class="d-inline" action="{{route('medecins.destroy',['medecin'=>$medecin->medecin_id])}}" method="post">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger">Supprimer</button>
                        </form>
                    @endif

                    @if(!$medecin->valid)
                        <a class="btn btn-primary float-right" href="{{route('medecins.edit',['medecin'=>$medecin->medecin_id])}}">Modifier</a>
                    @endif

                </div>
                <div class="card-footer text-muted">
                    Créer {{$medecin->created_at != null ? $medecin->created_at->diffForHumans() : ''}}  par {{$medecin->created_by}}
                </div>
            </div>
        </div>

    <div class="col-sm-12 col-md-6 grid-margin stretch-card">

        <div class="card">
            <div class="card-header">
                <i class="mdi mdi-clipboard-list-outline"></i>&nbsp;Dernières Modifications
            </div>

            <div class="card-body p-0">
                <div id="accordion">
                    @foreach($historiques as $historique)
                        <div class="card">
                            <div class="card-header" id="headingOne">
                                <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse{{$historique->id}}" aria-expanded="true" aria-controls="collapse{{$historique->id}}">
                                    <i class="mdi mdi-autorenew"></i> {{ 'Effectuée le : '. $historique->updated_at->format('d/m/Y') .' par ' . $historique->created_by }}
                                </button>
                                </h5>
                            </div>

                            <div id="collapse{{$historique->id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                <div class="card-body">
                                    <ul>
                                    @foreach (json_decode($historique->changes) as $key => $change)
                                        <li class="">{{'The ' .$change->column . ' has been modified from  : ' . $change->old_value . ' to '. $change->new_value}}</li>
                                    @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>
    </div>

</div>

@endsection
