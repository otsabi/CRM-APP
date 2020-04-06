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

        <div class="col-sm-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-header">
                    <i class="mdi mdi-account-edit"></i> Modifier Médecin
                </div>

                <div class="card-body">
                    <form class="forms-sample" action="{{route('medecins.update',['medecin'=> $medecin->medecin_id])}}" method="POST">
                        @csrf
                        @method('put')
                        <div class="form-row pb-3">
                            <div class="col-sm-12 col-md-4 mb-3">
                                <label for="nom">Nom *</label>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{$medecin->nom}}" required>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-3">
                                <label for="prenom">Prenom *</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" value="{{$medecin->prenom}}" required>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-3">
                                <label for="spec">Specialité *</label>
                                <select id="spec" name="spec" class="form-control">
                                    <option value="" selected></option>
                                    @foreach($specialites as $specialite)
                                        <option {{$medecin->specialite_id === $specialite->specialite_id ? 'selected' : ''}} value="{{$specialite->specialite_id}}">{{$specialite->code}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-row pb-3">
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="etab">Etablissement *</label>
                                <select class="form-control" id="etab" name="etab" required>
                                    <option value=""></option>
                                    <option {{$medecin->etablissement === 'privé' ? 'selected' : ''}} value="privé">Privé</option>
                                    <option {{$medecin->etablissement === 'hopital' ? 'selected' : ''}} value="hopital">Hôpital</option>
                                    <option {{$medecin->etablissement === 'chu' ? 'selected' : ''}} value="chu">CHU</option>
                                    <option {{$medecin->etablissement === 'centre de santé' ? 'selected' : ''}} value="centre de santé">Centre de santé</option>
                                    <option {{$medecin->etablissement === 'autre' ? 'selected' : ''}} value="autre">Autre</option>
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-6 mb-3">
                                <label for="potentiel">Potentiel *</label>
                                <select class="form-control" id="potentiel" name="potentiel" required>
                                    <option value=""></option>
                                    <option {{$medecin->potentiel === 'A' ? 'selected' : ''}} value="A">A</option>
                                    <option {{$medecin->potentiel === 'B' ? 'selected' : ''}} value="B">B</option>
                                    <option {{$medecin->potentiel === 'C' ? 'selected' : ''}} value="C">C</option>
                                    <option {{$medecin->potentiel === 'D' ? 'selected' : ''}} value="D">D</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-row pb-3">
                            <div class="col-sm-12 col-md-4 mb-3">
                                <label for="ville">Ville *</label>
                                <select class="form-control" id="ville" name="ville" required>
                                    <option value=""></option>
                                    @foreach($villes as $ville)
                                        <option {{$medecin->ville_id === $ville->ville_id ? 'selected' : ''}} value="{{$ville->ville_id}}">{{$ville->libelle}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-3">
                                <label for="zone">Zone *</label>
                                <input type="text" class="form-control" name="zone" id="zone" value="{{$medecin->zone_med}}" required>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-3">
                                <label for="tel">Telephone</label>
                                <input type="text" class="form-control" name="tel" id="tel" value="{{$medecin->tel}}" >
                            </div>

                        </div>

                        <div class="form-row pb-3">
                            <div class="col-sm-12 col-md-4 mb-3">
                                <label for="adress">Adresse *</label>
                                <textarea name="adress" id="adress" class="form-control" cols="20" rows="5" required>{{$medecin->adresse}}
                                </textarea>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col">
                                <button class="btn btn-success float-right" type="submit">Mettre à jour</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
<script src="{{asset('theme/vendors/inputmask/dist/jquery.inputmask.js')}}"> </script>

<script>
    $(document).ready(function(){
        $('#tel').inputmask("9999-999999");  //static mask
    });
</script>
@endpush
