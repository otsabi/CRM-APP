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
                    <i class="mdi mdi-account-box"></i>&nbsp;Fiche Pharmacie
                </div>

                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-3 col-md-5 mb-3">Libelle</dt>
                        <dd class="col-sm-9 col-md-7  text-uppercase">{{$pharmacie->libelle}}</dd>

                        <dt class="col-sm-3 col-md-5 my-3 mb-3">Ville</dt>
                        <dd class="col-sm-9 col-md-7 my-md-3 text-uppercase">{{$pharmacie->ville->libelle}}</dd>

                        <dt class="col-sm-3 col-md-5 my-3 mb-3">Zone</dt>
                        <dd class="col-sm-9 col-md-7  my-md-3 text-uppercase">{{$pharmacie->zone_ph}}</dd>

                        <dt class="col-sm-3 col-md-5 my-3 mb-3">Potentiel</dt>
                        <dd class="col-sm-9 col-md-7  my-md-3 text-uppercase">{{$pharmacie->potentiel}}</dd>

                        <dt class="col-sm-3 col-md-5 my-3 mb-3">Télephone</dt>
                        <dd class="col-sm-9 col-md-7  my-md-3">{{$pharmacie->tel}}</dd>

                        <dt class="col-sm-3 col-md-5 my-3 mb-3">Adresse</dt>
                        <dd class="col-sm-9 col-md-7  my-md-3">{{$pharmacie->adresse}}</dd>

                        <dt class="col-sm-3 col-md-5 my-3">Validation</dt>
                        <dd class="col-sm-9 col-md-7  my-md-3">
                            @if($pharmacie->valid)
                                <span class="badge badge-success">validé</span>
                            @else
                                <span class="badge badge-secondary">En cours</span>
                            @endif
                        </dd>

                    </dl>

                    @if($pharmacie->visites->count() <= 0 && !$pharmacie->valid)
                        <form class="d-inline" action="{{route('pharmacies.destroy',['pharmacie'=>$pharmacie->pharmacie_id])}}" method="post">
                            @method('delete')
                            @csrf
                            <button class="btn btn-danger">Supprimer</button>
                        </form>
                    @endif

                    @if(!$pharmacie->valid)
                        <a class="btn btn-primary float-right" href="{{route('pharmacies.edit',['pharmacie'=>$pharmacie->pharmacie_id])}}">Modifier</a>
                    @endif

                </div>
                <div class="card-footer text-muted">
                    Créer {{$pharmacie->created_at != null ? $pharmacie->created_at->diffForHumans() : '' }}  par {{$pharmacie->created_by}}
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
