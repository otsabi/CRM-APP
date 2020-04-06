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
                        <dd class="col-sm-9 text-uppercase font-weight-bold">{{number_format($bc->montant,2,',',' ') . ' Dhs'}}</dd>

                        <dt class="col-sm-3 mb-4">Etat</dt>
                        <dd class="col-sm-9"> <span class="badge badge-primary text-capitalize">{{$bc->etat}}</span></dd>

                        @if($bc->etat === 'validé')
                            <dt class="col-sm-3 mb-4">Validé par</dt>
                            <dd class="col-sm-9 text-uppercase">{{$bc->validated_by}}</dd>
                        @endif

                        <dt class="col-sm-3 mb-4">Satisfaction</dt>
                        <dd class="col-sm-9 text-capitalize">{{$bc->satisfaction}}</dd>

                        <dt class="col-sm-3 mb-4">Engagement</dt>
                        <dd class="col-sm-9 text-capitalize">{{$bc->engagement}}</dd>




                    </dl>

                @if($bc->etat === 'en cours')
                    <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editBc">
                            Modifier
                        </button>
                    @endif

                </div>
                <div class="card-footer text-muted">
                    Demandé par {{$bc->created_by}} {{$bc->created_at->diffForHumans()}}
                </div>
            </div>
        </div>



    </div>

@endsection

@section('modals')



    <!-- Modal -->
    <div class="modal fade" id="editBc" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editBcLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBcLabel">Modifier BC</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.bc.update',['id'=>$bc->bc_id])}}" method="post" id="editBcForm">
                        @method('PUT')
                        @csrf
                        <div class="form-row">
                            <div class="col">
                                <label for="etat">Etat</label>
                                <select class="form-control" name="etat" id="etat">
                                    <option value=""></option>
                                    <option value="non validé">Non Validé</option>
                                    <option value="validé">Validé</option>
                                    <option value="réalisé">Réalisé</option>
                                </select>

                            </div>
                        </div>

                        <div class="form-row pt-3">
                            <div class="col">
                                <label for="engagement_bc">Engagement</label>
                                <select class="form-control" name="engagement_bc" id="engagement_bc">
                                    <option value=""></option>
                                    <option {{$bc->engagement === "faible"? "selected" :""}} value="faible">Faible</option>
                                    <option  {{$bc->engagement === "moyen"? "selected" :""}} value="moyen">Moyen</option>
                                    <option {{$bc->engagement === "elevé"? "selected" :""}} value="elevé">Elevé</option>
                                </select>

                            </div>

                            <div class="col">
                                <label for="satisfaction_bc">Satisfaction</label>
                                <select class="form-control" name="satisfaction_bc" id="satisfaction_bc">
                                    <option value=""></option>
                                    <option {{$bc->engagement === "faible"? "selected" :""}} value="faible">Faible</option>
                                    <option {{$bc->engagement === "moyenne"? "selected" :""}} value="moyenne">Moyenne</option>
                                    <option {{$bc->engagement === "élevée"? "selected" :""}} value="élevée">Elevée</option>
                                </select>

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" onclick="document.getElementById('editBcForm').submit()">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

@endsection