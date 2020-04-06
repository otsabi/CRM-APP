@extends('layout.main')
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
                        <i class="mdi mdi-account-badge-horizontal-outline"></i>&nbsp; Nouveau pharmacie
                </div>
          <div class="card-body">
            <form class="forms-sample" action="{{route('pharmacies.update',$pharmacie->pharmacie_id)}}" method="POST">
                    @method('PUT')

            @csrf
                <div class="form-row pb-3">

                    <div class="col-sm-12 col-md-4 mb-3">
                        <label for="nom">Pharmacie</label>
                        <input type="text" name="pharmacie_nom" class="form-control {{$errors->has('pharmacie_nom') ? 'is-invalid':''}}" id="pharmacie_nom" placeholder="Pharmacie" value="{{$pharmacie->libelle}}" required>
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                            <label for="villes">Ville</label>
                            <select class="form-control {{$errors->has('pharmacie_ville') ? 'is-invalid':''}}" name="pharmacie_ville" id="pharmacie_ville" required>
                                    <option value=""></option>
                                @foreach ($villes as $ville)
                                  <option value="{{$ville->ville_id}}" {{$ville->ville_id === $pharmacie->ville_id ? 'selected': '' }}> {{$ville->libelle}} </option>
                                @endforeach

                            </select>
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                                <label for="telephone">Tel:</label>
                                <input type="tel" class="form-control" name="pharmacie_tel" id="pharmacie_tel"  placeholder="Numéro de tél" value="{{$pharmacie->tel}}" >
                    </div>
                </div>

                <div class="form-row pb-3">
                    <div class="col-sm-12 col-md-4 mb-3">
                        <label for="address">Address</label>
                        <input type="address" name="pharmacie_adress" class="form-control {{$errors->has('pharmacie_adress') ? 'is-invalid':''}}" id="pharmacie_adress" placeholder="Pharmacie adresse" value="{{$pharmacie->adresse}}" required >
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                            <label for="pharmacie_zone">Pharmacie zone</label>
                            <input type="pharmacie_zone" name="pharmacie_zone" class="form-control {{$errors->has('pharmacie_zone') ? 'is-invalid':''}}" id="pharmacie_zone" placeholder="Pharmacie zone" value="{{$pharmacie->zone_ph}}" required>
                    </div>
                    <div class="col-sm-12 col-md-4 mb-3">
                            <label for="potentiel">Potentiel :</label>
                            <select class="form-control {{$errors->has('pharmacie_potentiel') ? 'is-invalid':''}}" id="pharmacie_potentiel" name="pharmacie_potentiel">
                                <option value=""></option>
                                <option value="A" {{$pharmacie->potentiel === "A" ? "selected" : ""}}>A</option>
                                <option value="B" {{$pharmacie->potentiel === "B" ? "selected" : ""}}>B</option>
                                <option value="C" {{$pharmacie->potentiel === "C" ? "selected" : ""}}>C</option>
                                <option value="D" {{$pharmacie->potentiel === "D" ? "selected" : ""}}>D</option>
                            </select>
                    </div>
                </div>

              <div class="form-row pb-3">

                    <div class="col">
                            <a href="{{route('pharmacies.create')}}" class="btn btn-light">Annuler</a>
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

<script>
    $(document).ready(function(){
        $('#pharmacie_tel').inputmask("9999-999999");  //static mask
    });
</script>
@endpush
