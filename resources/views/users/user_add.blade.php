@extends('layout.main')

@push('styles')
<link rel="stylesheet" href="{{asset('theme/vendors/bootstrap-select/dist/css/bootstrap-select.min.css')}}">
@endpush

@section('content')

<div class="row">

        <div class="col-sm-12">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{session('status')}}
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

    <div class="col-12 grid-margin stretch-card">

        <div class="card">
            <div class="card-header">
                <i class="mdi mdi-account-circle"></i>&nbsp; Nouveau Utilisateur
            </div>
          <div class="card-body">

            <form class="forms-sample" action="{{route('admin.users.store')}}" method="POST">
                @csrf
                <div class="form-row pb-3">
                    <div class="col">
                        <label for="nom">Nom</label>
                        <input type="text" name="user_nom" class="form-control {{$errors->has('user_nom') ? 'is-invalid':''}}" id="user_nom" value="{{ old('user_nom') }}" placeholder="Nom" required>
                    </div>
                    <div class="col">
                        <label for="prenom">Prenom</label>
                        <input type="text" name="user_prenom" class="form-control {{$errors->has('user_prenom') ? 'is-invalid':''}}" id="user_prenom" value="{{ old('user_prenom') }}" placeholder="prenom" required>
                    </div>
                    <div class="col pl-5">
                            <label for="title">Title</label>
                            <div class="form-group row">
                                    <div class="col-sm-3">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input " name="user_title" id="user_Mr" value="Mr" {{ old('user_title') == 'Mr' ? 'checked' : '' }}  required >
                                             Mr
                                            <i class="input-helper"></i></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                      <div class="form-check">
                                        <label class="form-check-label">
                                          <input type="radio" class="form-check-input" name="user_title" id="user_Mme" value="Mme"  {{ old('user_title') == 'Mme' ? 'checked' : '' }} required>
                                          Mme
                                        <i class="input-helper"></i></label>
                                      </div>
                                    </div>
                                    <div class="col-sm-3">
                                            <div class="form-check">
                                              <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="user_title" id="user_Mlle" {{ old('user_title') == 'Mlle' ? 'checked' : '' }} value="Mlle" required>
                                                Mlle
                                              <i class="input-helper"></i></label>
                                            </div>
                                    </div>
                                </div>

                    </div>
                </div>

                <div class="form-row pb-5">
                    <div class="col">
                        <label for="email">Adresse E-mail</label>
                        <input type="email" name="user_email" class="form-control {{$errors->has('user_email') ? 'is-invalid':''}}" value="{{ old('user_email') }}" id="user_email" placeholder="Email" required >
                    </div>
                    <div class="col">
                            <label for="password">Mot de passe</label>
                            <input type="password" name="password" class="form-control {{$errors->has('password') ? 'is-invalid':''}}" id="password" placeholder="Password" required>
                    </div>
                    <div class="col">
                            <label for="password">Confirmer mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control {{$errors->has('password_confirmation') ? 'is-invalid':''}}" id="password_confirmation" placeholder="password confirmation" required>
                    </div>
                </div>

              <div class="form-row pb-5">
                  <div class="col">
                        <label for="villes">Ville</label>
                        <select class="form-control {{$errors->has('user_ville') ? 'is-invalid':''}}" name="user_ville" id="villes" required>
                                <option value=""></option>
                            @foreach ($villes as $ville)
                              <option value="{{$ville->ville_id}}" {{ $ville->ville_id == old('user_ville') ? 'selected' : '' }}> {{$ville->libelle}} </option>
                            @endforeach

                        </select>
                  </div>
                  <div class="col">
                        <label for="manager">Manager</label>
                        <select class="form-control {{$errors->has('user_manager') ? 'is-invalid':''}}" name="user_manager" id="managers">
                            <option value=""></option>
                            @foreach ($managers as $manager)
                                    <option value="{{$manager->user_id}}" {{ $manager->user_id == old('user_manager') ? 'selected' : '' }} >{{$manager->nom}} {{$manager->prenom}}</option>
                            @endforeach

                        </select>

                  </div>
                  <div class="col">

                        <label for="telephone">Téléphone</label>
                        <input type="tel" class="form-control {{$errors->has('user_tel') ? 'is-invalid':''}}" name="user_tel" id="user_tel" value="{{ old('user_tel') }}"  placeholder="Numéro de tél" >
                  </div>
              </div>
              <div class="form-row pb-5">
                  <div class="col">
                        <label for="role">Role</label>
                        <select class="form-control {{$errors->has('user_role') ? 'is-invalid':''}}" name="user_role" id="user_role" required>
                                <option value=""></option>
                                @foreach ($roles as $role)
                                        <option value="{{$role->role_id}}" {{ $role->role_id == old('user_role') ? 'selected' : '' }}>  {{$role->libelle}}  </option>
                                @endforeach
                        </select>
                  </div>
                  <div class="col">
                        <label for="gamme">Gamme</label>
                        <select class="form-control selectpicker {{$errors->has('user_gamme') ? 'is-invalid':''}}" name="user_gamme[]" id="user_gamme" class="" multiple>
                                @foreach ($gammes as $gamme)
                                    <option value="{{$gamme->gamme_id}}" {{ $gamme->gamme_id == old('user_gamme') ? 'selected' : '' }}> {{$gamme->libelle}} </option>
                                @endforeach
                        </select>
                  </div>
              </div>

              <div class="form-row pb-3">

                    <div class="col">
                            <a href="{{route('admin.users.index')}}" class="btn btn-light">Annuler</a>
                            <button type="submit" class="btn btn-primary mr-2 float-right">Valider</button>
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
<script src="{{asset('theme/vendors/bootstrap-select/dist/js/bootstrap-select.min.js')}}"> </script>
<script src="{{asset('theme/vendors/bootstrap-select/dist/js/i18n/defaults-fr_FR.min.js')}}"> </script>

<script>
    $(document).ready(function(){
        $('#user_tel').inputmask("9999-999999");  //static mask
    });
</script>

@endpush
