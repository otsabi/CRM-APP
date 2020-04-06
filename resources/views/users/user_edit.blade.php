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
                    <i class="mdi mdi-account-edit"></i>&nbsp; Modifier Utilisateur
                </div>
              <div class="card-body">
                <form class="forms-sample" action="{{route('admin.users.update',$user->user_id)}}" method="POST">
                        @method('PUT')
                        @csrf
                    <div class="form-row pb-3">
                        <div class="col">
                            <label for="user_nom">Nom</label>
                            <input type="text" name="user_nom" class="form-control" id="user_nom" placeholder="Nom" value="{{$user->nom}}" required>
                        </div>
                        <div class="col">
                            <label for="user_prenom">Prenom</label>
                            <input type="text" name="user_prenom" class="form-control" id="user_prenom" placeholder="Prenom" value="{{$user->prenom}}" required>
                        </div>
                        <div class="col">
                                <label for="title">Title</label>
                                <div class="form-group row">
                                        <div class="col-sm-4">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="user_title" id="user_Mr" value="Mr" {{$user->title == 'Mr' ? 'checked' : ''}}  required >
                                                 Mr
                                                <i class="input-helper"></i></label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                          <div class="form-check">
                                            <label class="form-check-label">
                                              <input type="radio" class="form-check-input" name="user_title" id="user_Mme" value="Mme" {{$user->title == 'Mme' ? 'checked' : ''}} required>
                                              Mme
                                            <i class="input-helper"></i></label>
                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                                <div class="form-check">
                                                  <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="user_title" id="user_Mlle" value="Mlle" {{$user->title == 'Mlle' ? 'checked' : ''}} required>
                                                    Mlle
                                                  <i class="input-helper"></i></label>
                                                </div>
                                        </div>
                                    </div>

                        </div>
                    </div>

                    <div class="form-row pb-5">
                        <div class="col">
                            <label for="user_email">Adresse e-mail</label>
                            <input type="email" name="user_email" class="form-control" id="user_email" placeholder="Email" value="{{$user->email}}" required>
                        </div>

                        <div class="col">
                            <label for="villes">Ville</label>
                            <select class="form-control" name="user_ville" id="villes"  required>
                                @foreach ($villes as $ville)
                                    <option value="{{$ville->ville_id}}" {{$ville->ville_id === $user->ville_id ? 'selected': '' }}> {{$ville->libelle}} </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col">

                            <label for="user_tel">Tel:</label>
                            <input type="tel" class="form-control" name="user_tel" id="user_tel"  placeholder="Numéro de tél" value="{{$user->tel}}" required>
                        </div>

                    </div>

                  <div class="form-row">

                      <div class="col">
                            <label for="user_manager">Manager</label>
                            <select class="form-control" name="user_manager" id="user_manager">
                                <option value=""></option>
                                @foreach ($managers as $manager)
                                   <option value="{{$manager->user_id}}" {{$manager->user_id == $user->manager_id ? 'selected': ''}}> {{$manager->nom}} {{$manager->prenom}}</option>
                                @endforeach

                            </select>

                      </div>

                      <div class="col">
                          <label for="user_role">Role</label>
                          <select class="form-control" name="user_role" id="user_role"  required>
                              @foreach ($roles as $role)
                                  <option value="{{$role->role_id}}" {{$role->role_id === $user->role_id ?'selected' : '' }} >  {{$role->libelle}}  </option>
                              @endforeach
                          </select>
                      </div>

                      <div class="col">
                          <label for="user_gamme">Gamme</label>
                          <select class="form-control selectpicker" name="user_gamme[]" id="user_gamme" multiple required>
                              @foreach ($gammes as $gamme)
                                  <option value="{{$gamme->gamme_id}}" {{ in_array($gamme->gamme_id, $user_gammes ) ? 'selected' : ''}} > {{$gamme->libelle}} </option>
                              @endforeach
                          </select>
                      </div>

                  </div>

                  <div class="form-row pt-3">
                        <div class="col">
                                <a class="btn btn-light" href="{{route('admin.users.index')}}">Annuler</a>
                                <button type="submit" class="btn btn-success mr-2 float-right">Valider</button>
                        </div>
                  </div>
                </form>

              </div>
            </div>
          </div>
</div>

<div class="row">

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <i class="mdi mdi-account-edit"></i>&nbsp; Modifier mot de passe
            </div>
            <div class="card-body">
                <form class="forms-sample" action="{{route('admin.change-password',$user->user_id)}}" method="POST">
                    @method('PUT')
                    @csrf

                    <div class="form-row">
                        <div class="col">
                            <label for="user_password">Mot de passe:</label>
                            <input type="password" name="password" class="form-control {{$errors->has('password') ? 'is-invalid':''}}" id="user_password" placeholder="Nouveau mot de passe">
                        </div>
                        <div class="col">
                            <label for="password_confirmation">Confirmer mot de passe:</label>
                            <input type="password" name="password_confirmation" class="form-control {{$errors->has('password_confirmation') ? 'is-invalid':''}}" id="password_confirmation" placeholder="Confirmer nouveau mot de passe">
                        </div>
                    </div>

                    <div class="form-row pt-3">
                        <div class="col">
                            <button type="submit" class="btn btn-primary mr-2 float-right">Changer</button>
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
