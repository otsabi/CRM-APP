@extends('layout.main')

@push('styles')
<link rel="stylesheet" href="{{asset('theme/vendors/sweetalert2/dist/sweetalert2.min.css')}}">
@endpush

@section('content')

    <div class="row">

        <div class="col-sm-12">
            @if(session('status'))
                <div class="alert alert-success" role="alert">
                    Well done ! -  {{session('status')}}
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
                    <i class="mdi mdi-account-badge-horizontal-outline"></i>&nbsp;Modification visite
                </div>

                <div class="card-body">

                    <form class="forms-sample" action="{{route('phvisites.update',['phvisite' => $visite->visitephar_id])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-row pb-3">
                            <div class="col-sm-12 col-md-4">
                                <label for="date_v">Date visite</label>
                                <input type="text" class="form-control" disabled id="date_v" value="{{Carbon\Carbon::createFromFormat('Y-m-d',$visite->date_visite)->format('d/m/Y')}}">
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <label for="etat_actuelle">Etat actuelle</label>
                                <input type="text" class="form-control" disabled id="etat_actuelle" value="{{$visite->etat}}">
                            </div>

                            <div class="col-sm-12 col-md-4 pl-md-3 mt-4 mt-sm-0">
                                <label for="new_etat">Changer l'etat en :</label>
                                <select name="new_etat" id="new_etat" class="form-control" required>
                                    <option value="">Choisir...</option>
                                    <option value="Réalisé">Réalisé</option>
                                    <option value="Reporté">Reporté</option>
                                </select>
                            </div>

                        </div>

                        <div class="form-row pb-3"></div>

                        <div class="form-row pb-3">
                            <div class="col-sm-12 col-md-6">
                                <label for="pharma">Pharmacie</label>
                                <input type="text" class="form-control" disabled id="pharma" value="{{$visite->pharmacie->libelle}} - {{$visite->pharmacie->zone_ph}}">
                            </div>

                            <div class="col-sm-12 col-md-6 pl-md-5 mt-4 mt-sm-0">
                                <label for="note">Note</label>
                                <textarea class="form-control form-control-lg" id="note" name="note" placeholder="Ecrivez quelque chose"></textarea>
                            </div>

                        </div>

                        <div class="form-row pb-3"> </div>

                        <div class="form-row pb-3">
                            <div class="col">
                                <button id="newproduct" class="btn btn-sm btn-secondary float-right" type="button"> <i class="mdi mdi-plus"></i> Produit présenté</button>
                            </div>
                        </div>

                        <div class="form-row pb-3">

                            <div class="col">
                                <table class="table table-bordered" id="products">
                                    <thead>
                                    <tr>
                                        <th>Produit</th>
                                        <th>Nombre de boîtes</th>
                                        <th>Supprimer</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <select name="product[]" class="form-control form-control-sm" required>
                                                <option value=""></option>
                                                @foreach($produits as $produit)
                                                    <option value="{{$produit->produit_id}}">{{$produit->code_produit}}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td>
                                            <input type="number" class="form-control form-control-sm" name="nbr_b[]" required>
                                        </td>

                                        <td>
                                            <button type="button" class="delproduct btn btn-sm btn-danger"><i class="mdi mdi-delete"></i>Supprimer</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                        <hr />

                        <div class="form-row">
                            <div class="col">
                                <button class="btn btn-primary float-right" type="submit">Valider</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{asset('theme/vendors/sweetalert2/dist/sweetalert2.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $('#newproduct').on('click',function (event) {
            event.preventDefault();
            var product = '<td><select name="product[]" class="form-control form-control-sm" required><option value=""></option>@foreach($produits as $produit)<option value="{{$produit->produit_id}}">{{$produit->code_produit}}</option>@endforeach</select></td>';
            var nbr_b = '<td><input type="number" class="form-control form-control-sm" name="nbr_b[]" required ></td>';
            var btn_delete = '<td> <button type="button" class="delproduct btn btn-sm btn-danger"> <i class="mdi mdi-delete"></i> Supprimer </button> </td>';
            var ligne = '<tr>' + product + nbr_b + btn_delete + '</tr>';
            $('#products>tbody').append(ligne);
        });

        $(document).on('click','.delproduct',function (event) {
            event.preventDefault();
            $(this).closest('tr').remove();
        });

        $('#new_etat').on('change',function (event) {
            //event.preventDefault();
            var selected = $(this).val();

            if(selected.length == 0 || selected === "Réalisé"){
                $('#newproduct').removeAttr('disabled');
            }
            else if(selected === "Reporté"){
                Swal.fire({
                    title: 'Attention !',
                    text: 'Pour Reporter cette visite, nous devons vider le tableau des produits présentés !',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, Je confirme !',
                }).then(function(result){
                    if(result.value){
                        $(this).prop('selected',true);
                        $('#newproduct').attr('disabled',true);
                        $('#products>tbody>tr').remove();
                    }else if(result.dismiss === Swal.DismissReason.cancel){
                        $('#new_etat option:first-child').prop('selected',true);
                        $('#newproduct').removeAttr('disabled');
                    }
                });
            }
        });

    });
</script>
@endpush