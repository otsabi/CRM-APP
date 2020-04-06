@extends('layout.main')

@push('styles')
<link rel="stylesheet" href="{{asset('theme/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.css')}}">
@endpush

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

        <div class="col-sm-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-header">
                    <i class="mdi mdi-file-edit-outline"></i>&nbsp; Modifier Business case
                </div>

               <div class="card-body">
                    <form class="forms-sample" action="{{route('bcs.update',['bc'=> $bc->bc_id])}}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-row pb-5">
                            <div class="col">
                                    <label for="bc_medecin">Médecin</label>
                                    <input type="text" class="form-control" name="bc_medecin" disabled id="bc_medecin" value="{{$bc->medecin->nom . ' '.$bc->medecin->prenom . ' - '.$bc->medecin->specialite->code }}">
                            </div>

                            <div class="col">
                                    <label for="date_demande_bc">Date demande</label>
                                    <input type="date" disabled class="form-control" id="date_demande_bc" name="date_demande_bc" value="{{$bc->date_demande}}">
                            </div>

                            <div class="col">
                                    <label for="date_realisation_bc">Date réalisation</label>
                                    <input type="text" class="form-control" id="date_realisation_bc" name="date_realisation_bc" value="{{Carbon\Carbon::createFromFormat('Y-m-d',$bc->date_realisation)->format('d/m/Y')}}" required>
                                    <small id="date_realisation_bcHelpBlock" class="form-text text-muted">
                                        la date de réalisation doit être 3 jours après le jour de demande.
                                    </small>
                            </div>
                        </div>

                        <div class="form-row pb-3">
                                <div class="col">
                                        <label for="type_bc">Type d'investissement</label>
                                        <select class="form-control" name="type_bc" id="type_bc" required>
                                            <option value=""></option>
                                            <option {{$bc->type==='Billet' ? "selected" : ""}} value="Billet">Billet</option>
                                            <option {{$bc->type==='Hôtel' ? "selected" : ""}} value="Hôtel">Hôtel</option>
                                            <option {{$bc->type==='Congrès' ? "selected" : ""}} value="Congrès">Congrès</option>
                                            <option {{$bc->type==='Inscription' ? "selected" : ""}} value="Inscription">Inscription</option>
                                            <option {{$bc->type==='Journée' ? "selected" : ""}} value="Journées">Journée</option>
                                            <option {{$bc->type==='Formation' ? "selected" : ""}} value="Formation">Formation</option>
                                            <option {{$bc->type==='Matériel' ? "selected" : ""}} value="Matériel">Matériel</option>
                                            <option {{$bc->type==='Diner' ? "selected" : ""}} value="Diner">Diner</option>
                                            <option {{$bc->type==='Dejeuner' ? "selected" : ""}} value="Dejeuner">Dejeuner</option>
                                            <option {{$bc->type==='Petit-Dej' ? "selected" : ""}} value="Petit-Dej">Petit-Dej</option>
                                            <option {{$bc->type==='Autre' ? "selected" : ""}} value="Autre">Autre</option>
                                        </select>
                                </div>

                                    <div class="col">
                                        <label for="destination_bc">Destination</label>
                                        <input type="text" class="form-control" id="destination_bc" name="destination_bc" value="{{$bc->destination}}">
                                    </div>

                                    <div class="col">
                                        <label for="detail_bc">Détail d'investissement</label>
                                        <textarea  name="detail_bc" class="form-control" id="detail_bc"  cols="30" rows="3" required>{{$bc->detail}}</textarea>
                                   </div>

                            </div>

                            <div class="form-row pb-3">
                                    <div class="col">
                                            <label for="montant_bc">Montant</label>
                                            <input type="number" class="form-control" id="montant_bc" name="montant_bc" value="{{$bc->montant}}" required>
                                    </div>
                                    <div class="col">
                                            <label for="engagement_bc">Engagement</label>
                                            <select class="form-control" name="engagement_bc" id="engagement_bc">
                                                    <option value=""></option>
                                                    <option {{$bc->engagement === "faible"? "selected" :""}} value="faible">Faible</option>
                                                    <option {{$bc->engagement === "moyen"? "selected" :""}} value="moyen">Moyen</option>
                                                    <option {{$bc->engagement === "elevé"? "selected" :""}} value="elevé">Elevé</option>
                                                    </select>
                                    </div>

                            </div>


                            <div class="form-row mt-3">
                                    <div class="col">

                                                    <a href="{{route('bcs.index')}}" class="btn btn-light float-left">Annuler</a>
                                                    <button type="submit" class="btn btn-success float-right">Mettre à jour</button>
                                    </div>
                            </div>

                    </form>
               </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')

<script type="text/javascript" src="{{asset('theme/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script type="text/javascript" src="{{asset('theme/vendors/bootstrap-datepicker/locales/bootstrap-datepicker.fr.min.js')}}"></script>
<script>
    $(document).ready(function(){

        $('#date_realisation_bc').datepicker({
            'startDate' : '+3d',
            todayBtn: "linked",
            language: "fr"
        });
    });
</script>
@endpush
