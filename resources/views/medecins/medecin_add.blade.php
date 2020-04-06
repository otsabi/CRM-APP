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
                    <i class="mdi mdi-account-multiple-plus"></i>&nbsp; Nouveau Médecin
                </div>

               <div class="card-body">
                   <form class="forms-sample" action="{{route('medecins.store')}}" method="POST">
                       @csrf
                        <div class="form-row pb-3">
                            <div class="col-sm-12 col-md-4 mb-3">
                                <label for="nom">Nom *</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-3">
                                <label for="prenom">Prenom *</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" required>
                            </div>
                            <div class="col-sm-12 col-md-4 mb-3">
                                <label for="spec">Specialité *</label>
                                <select id="spec" name="spec" class="form-control">
                                    <option value="" selected></option>
                                    @foreach($specialites as $specialite)
                                        <option value="{{$specialite->specialite_id}}">{{$specialite->code}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div>

                       <div class="form-row pb-3">
                           <div class="col-sm-12 col-md-6 mb-3">
                               <label for="etab">Etablissement *</label>
                               <select class="form-control" id="etab" name="etab" required>
                                   <option value=""></option>
                                   <option value="privé">Privé</option>
                                   <option value="hopital">Hôpital</option>
                                   <option value="chu">CHU</option>
                                   <option value="centre de santé">Centre de santé</option>
                                   <option value="Autre">Autre</option>
                               </select>
                           </div>
                           <div class="col-sm-12 col-md-6 mb-3">
                               <label for="potentiel">Potentiel *</label>
                               <select class="form-control" id="potentiel" name="potentiel" required>
                                   <option value=""></option>
                                   <option value="A">A</option>
                                   <option value="B">B</option>
                                   <option value="C">C</option>
                                   <option value="D">D</option>
                               </select>
                           </div>

                       </div>

                       <div class="form-row pb-3">
                           <div class="col-sm-12 col-md-4 mb-3">
                               <label for="ville">Ville *</label>
                               <select class="form-control" id="ville" name="ville" required>
                                    <option value=""></option>
                                    @foreach($villes as $ville)
                                         <option value="{{$ville->ville_id}}">{{$ville->libelle}}</option>
                                        @endforeach
                               </select>
                           </div>
                           <div class="col-sm-12 col-md-4 mb-3">
                               <label for="zone">Zone *</label>
                               <input type="text" class="form-control" name="zone" id="zone" required>
                           </div>
                           <div class="col-sm-12 col-md-4">
                               <label for="tel">Telephone</label>
                               <input type="text" class="form-control" name="tel" id="tel">
                           </div>

                       </div>

                       <div class="form-row pb-3">
                           <div class="col-sm-12 col-md-4 mb-3">
                               <label for="adress">Adresse *</label>
                               <textarea name="adress" id="adress" class="form-control" cols="20" rows="5" required></textarea>
                           </div>
                       </div>

                       <div class="form-row">
                           <div class="col">
                               <button class="btn btn-success float-right" type="submit">Créer médecin</button>
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
