@extends('layout.main')

@section('content')

    <div class="row">

        <div class="col-sm-12 grid-margin stretch-card">

            <div class="card">
                <div class="card-header">
                    <i class="mdi mdi-account-badge-horizontal-outline"></i>&nbsp;Visite Pharmacie
                </div>

                <div class="card-body">

                    <form class="forms-sample" >

                        <div class="form-row pb-3">
                            <div class="col-sm-12 col-md-6">
                                <label for="date_v">Date visite</label>
                                <input type="text" class="form-control" disabled id="date_v" value="{{Carbon\Carbon::createFromFormat('Y-m-d',$visite->date_visite)->format('d/m/Y')}}">
                            </div>

                            <div class="col-sm-12 col-md-6">
                                <label for="etat_actuelle">Etat</label>
                                <input type="text" class="form-control" disabled id="etat_actuelle" value="{{$visite->etat}}">
                            </div>
                        </div>

                        <div class="form-row pb-3"></div>

                        <div class="form-row pb-3">
                            <div class="col-sm-12 col-md-6">
                                <label for="med">Pharmacie</label>
                                <input type="text" class="form-control" disabled id="med" value="{{$visite->pharmacie->libelle}} - {{$visite->pharmacie->potentiel}} - {{$visite->pharmacie->ville->libelle}}">
                            </div>

                            <div class="col-sm-12 col-md-6 ">
                                <label for="note">Note</label>
                                <textarea class="form-control form-control-lg" value="" disabled id="note" name="note" >{{$visite->note}}</textarea>
                            </div>

                        </div>

                        <div class="form-row pb-3"> </div>

                        @if(count($visite->products) > 0)
                            <div class="form-row pb-3">

                                <div class="col">
                                    <table class="table table-bordered" id="products">
                                        <thead>
                                            <tr>
                                                <th>Produit</th>
                                                <th>Nombre des boîtes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($visite->products as $product)
                                            <tr>
                                                <td>{{$product->code_produit}}</td>
                                                <td>{{$product->pivot->nb_boites}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        @endif

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection