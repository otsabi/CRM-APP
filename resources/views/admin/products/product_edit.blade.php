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
                    <i class="mdi mdi-account-edit"></i>&nbsp; Modifier Produit
                </div>
              <div class="card-body">
                <form class="forms-sample" action="{{route('admin.products.update',$produit->produit_id)}}" method="POST">
                        @method('PUT')
                        @csrf
                    <div class="form-row pb-3">
                        <div class="col-4">
                            <label for="code">Code</label>
                            <input type="text" name="code" class="form-control" id="code" placeholder="code produit" value="{{$produit->code_produit}}" required>
                        </div>
                        <div class="col-4">
                            <label for="libelle">Libelle</label>
                            <input type="text" name="libelle" class="form-control" id="libelle" placeholder="Libelle  " value="{{$produit->libelle}}" required>
                        </div>
                        <div class="col-4">

                            <label for="produit_gamme">Gamme</label>
                            <select class="form-control selectpicker" name="produit_gamme[]" id="gamme"  multiple required>
                                @foreach ($gammes as $gamme)
                                  <option value="{{$gamme->gamme_id}}" {{ in_array($gamme->gamme_id, $produit_gammes ) ? 'selected' : ''}} > {{$gamme->libelle}} </option>
                                @endforeach

                            </select>

                        </div>
                    </div>

                    <div class="form-row pb-5">


                        <div class="col-3">
                            <label for="price">Price</label>
                            <input type="number" name="price" class="form-control" id="price" placeholder="Prix  " value="{{$produit->prix}}" required>

                        </div>

                        <div class="col">


                        </div>

                    </div>



                  <div class="form-row pt-3">
                        <div class="col">
                                <a class="btn btn-light" href="{{route('admin.products.index')}}">Annuler</a>
                                <button type="submit" class="btn btn-success mr-2 float-right">Valider</button>
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
