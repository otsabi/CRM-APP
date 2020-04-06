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

    <div class="col-sm-12 col-md-12 grid-margin stretch-card">

        <div class="card">
            <div class="card-header">
                <i class="mdi mdi-newspaper-variant-outline"></i>&nbsp;Fiche Business case
            </div>

            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3 mb-4">Médecin</dt>
                    <dd class="col-sm-9 text-uppercase">{{$bc->medecin->nom}} {{$bc->medecin->prenom}} - {{$bc->medecin->specialite->code}} - {{$bc->medecin->ville->libelle}}</dd>

                    <dt class="col-sm-3 mb-4">Date Demande</dt>
                    <dd class="col-sm-9 text-uppercase"> {{Carbon\Carbon::createFromFormat('Y-m-d',$bc->date_demande)->format('d/m/Y')}} </dd>

                    <dt class="col-sm-3 mb-4">Date Réalisation</dt>
                    <dd class="col-sm-9 text-uppercase">{{Carbon\Carbon::createFromFormat('Y-m-d',$bc->date_realisation)->format('d/m/Y')}} </dd>

                    <dt class="col-sm-3 mb-4">Type d'investissement</dt>
                    <dd class="col-sm-9 text-uppercase">{{$bc->type}}</dd>

                    <dt class="col-sm-3 mb-4">Destination</dt>
                    <dd class="col-sm-9 text-uppercase">{{$bc->destination}}</dd>

                    <dt class="col-sm-3 mb-4">Détail</dt>
                    <dd class="col-sm-9 text-uppercase">{{$bc->detail}}</dd>

                    <dt class="col-sm-3 mb-4">Montant</dt>
                    <dd class="col-sm-9 text-uppercase font-weight-bold" >{{number_format($bc->montant,2,',',' ') . ' Dhs'}}</dd>

                    <dt class="col-sm-3 mb-4">Etat</dt>
                    <dd class="col-sm-9"> <span class="badge badge-primary text-capitalize">{{$bc->etat}}</span></dd>

                    <dt class="col-sm-3 mb-4">Satisfaction</dt>
                    <dd class="col-sm-9">{{$bc->satisfaction}}</dd>

                    <dt class="col-sm-3 mb-4">Engagement</dt>
                    <dd class="col-sm-9 text-capitalize">{{$bc->engagement}}</dd>




                </dl>

                @if($bc->etat === 'en cours' )
                    <form class="d-inline" action="{{route('bcs.destroy',['bc'=>$bc->bc_id])}}" method="post">
                        @method('delete')
                        @csrf
                        <button class="btn btn-danger">Supprimer</button>
                    </form>
                @endif

                @if($bc->etat === 'en cours')
                    <a class="btn btn-primary float-right" href="{{route('bcs.edit',['bc'=>$bc->bc_id])}}">Modifier</a>
                @endif

            </div>
            <div class="card-footer text-muted">
                Demandé par {{$bc->created_by}} {{$bc->created_at->diffForHumans()}}
            </div>
        </div>
    </div>



</div>




@endsection
