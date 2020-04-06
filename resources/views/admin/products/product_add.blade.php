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
                <i class="mdi mdi-account-circle"></i>&nbsp; Nouveau Produit
            </div>
          <div class="card-body">

            <form class="forms-sample" action="{{route('admin.products.store')}}" method="POST">
                @csrf
                <div class="form-row pb-3">
                    <div class="col">
                        <label for="code">Code</label>
                        <input type="text" name="code"class="form-control {{$errors->has('code') ? 'is-invalid':''}}" id="code" value="{{ old('code') }}" placeholder="Code" required>
                    </div>
                    <div class="col">
                        <label for="libelle">Libelle</label>
                        <input type="text" name="libelle" class="form-control {{$errors->has('libelle') ? 'is-invalid':''}}" id="libelle" value="{{ old('libelle') }}" placeholder="Libelle" required>
                    </div>
                    <div class="col ">
                            <label for="price">Prix</label>
                    <input type="number" class="form-control  {{$errors->has('price') ? 'is-invalide':''}}" name="price" id="price" required>



                    </div>
                    <div class="col">

                        <label for="gamme">Gamme</label>
                        <select class="form-control selectpicker {{$errors->has('gamme') ? 'is-invalid':''}}" name="gamme[]" id="gamme" class="" multiple >
                                @foreach ($gammes as $gamme)
                                    <option value="{{$gamme->gamme_id}}" {{ $gamme->gamme_id == old('gamme') ? 'selected' : '' }}> {{$gamme->libelle}} </option>
                                @endforeach

                        </select>
                    </div>
                </div>
                <div class="form-row pb-3">
                </div>




              <div class="form-row pb-3">

                    <div class="col">
                            <a href="{{route('admin.products.index')}}" class="btn btn-light">Annuler</a>
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



@endpush
