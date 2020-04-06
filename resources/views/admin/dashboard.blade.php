@extends('layout.main')

@push('styles')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

@section('content')

<div class="row">
    <div class="col-lg-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body p-3">

                <div class="d-flex justify-content-between align-items-start">
                    <div class="col-sm-7">
                        <h4 class="card-title mt-2 text-uppercase">Visites par secteur: 90 derniers jours</h4>
                    </div>

                    <div class="col-auto">
                        <select id="delegue-filter" class="custom-select custom-select-sm">
                            @foreach($secteurs as $sect)
                                <option value="{{$sect->secteur_id}}">{{$sect->libelle}}</option>
                            @endforeach
                        </select>

                    </div>

                </div>
                <div id="columnChart" >
                    <div class="d-flex justify-content-center">
                        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body p-3">

                <div class="d-flex justify-content-between align-items-start">
                    <div class="col-sm-6">
                        <h4 class="card-title mt-2 text-uppercase">Visites par specialité: 90 derniers jours</h4>
                    </div>
                    <div class="col-auto">
                        <select id="secteur-filter" class="custom-select custom-select-sm">
                            @foreach($secteurs as $sect)
                                <option value="{{$sect->secteur_id}}">{{$sect->libelle}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <select id="spec-filter" class="custom-select custom-select-sm">
                            @foreach($specs as $spec)
                                <option value="{{$spec->specialite_id}}">{{$spec->code}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="stackedChart" >
                    <div class="d-flex justify-content-center">
                        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body p-3">
                <h4 class="card-title mt-2 text-uppercase">derniers médecins créés</h4>
                <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <th>Medecin</th>
                                <th>Spécialité</th>
                                <th>Ville</th>
                                <th>Créer par</th>
                            </thead>
                            <tbody>
                            @foreach($medecins as $med)
                                  <tr>
                                      <td class="text-uppercase">{{$med->nom .' '.$med->prenom}}</td>
                                      <td class="text-uppercase">{{$med->specialite->code}}</td>
                                      <td class="text-uppercase">{{$med->ville->libelle}}</td>
                                      <td class="text-uppercase">{{$med->created_by}}</td>
                                  </tr>
                                @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="col-sm-7">
                        <h4 class="card-title mt-2">Visites par ville: 90 derniers jours</h4>
                    </div>
                    <div class="col-auto">
                        <select id="villes-filter" class="custom-select custom-select-sm">
                            @foreach($villes as $ville)
                                <option value="{{$ville->ville_id}}">{{$ville->libelle}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="villesColumnChart" >
                    <div class="d-flex justify-content-center">
                        <div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript" src="{{asset('js/adDash.js')}}" ></script>
@endpush
